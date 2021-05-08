<?php
/*
 *@ClassName: DoAction
 *@Description: 执行动作
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-30 09:48:27
 *@LastEditors: 
 *@LastEditTime: 
*/

namespace backend\actions;

use yii;
use Closure;
use stdClass;
use backend\actions\helpers\Helper;
use yii\base\Action;
use yii\base\Exception;
use yii\web\Response;
use yii\web\UnprocessableEntityHttpException;

class DoAction extends Action
{
    /** @var string|array 主键名*/
    public $primaryKeyIdentity = null;
    /** @var string 主键来源方式(GET or POST) */
    public $primaryKeyFromMethod = "GET";
    /** @var string|array 成功重定向到的链接 */
    public $successRedirect = null;
    /** @var Closure 真正的执行逻辑 */
    public $do;
    /** @var string 成功后在页面显示消息提示 */
    public $successTipsMessage = "success";

    public function init()
    {
        parent::init();
        if ($this->successTipsMessage === "success") {
            $this->successTipsMessage = "成功!!!";
        }
    }

    public function run()
    {
        $primaryKeys = Helper::getPrimaryKeys($this->primaryKeyIdentity, $this->primaryKeyFromMethod);
        if (!$this->do instanceof Closure) {
            throw new Exception(__CLASS__ . "::do must be closure");
        }

        $postData = Yii::$app->getRequest()->post();

        $doData = [];

        if (!empty($primaryKeys)) {
            foreach ($primaryKeys as $primaryKey ) {
                array_push($doData, $primaryKey);
            }
        }

        array_push($doData, $postData, $this);

        $doResult = call_user_func_array($this->do, $doData);

         //判断是否有Ajax
         if (Yii::$app->getRequest()->getIsAjax()) {
            //只有$doResult为true表示创建成功
            if ($$doResult === true) {
                Yii::$app->getResponse()->format = Response::FORMAT_JSON;
                return ['code' => 0, 'msg' => 'success', 'data' => new stdClass()];
            } else {
                throw new UnprocessableEntityHttpException(Helper::getErrorString($createResult));
            }
        } else {
            if ($doResult === true) {
                Yii::$app->getSession()->setFlash('success', $this->successTipsMessage);
                if ($this->successRedirect)//成功重定向
                    return $this->controller->redirect($this->successRedirect);
                $url = Yii::$app->getSession()->get(self::CREATE_REFERER);
                if ($url) {
                    return $this->controller->redirect($url);
                }
                //默认值是重定向到当前控制器index（注意：如果当前控制器没有索引操作，将得到一个HTTP404错误）
                return $this->controller->redirect(["index"]);
            } else {
                //创建失败，返回错误
                Yii::$app->getSession()->setFlash('error', Helper::getErrorString($createResult));
            }
            
        }
    }
}



