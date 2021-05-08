<?php
/*
 *@ClassName: updateaction
 *@Description: 修改动作
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-05-07 16:04:43
 *@LastEditors: 
 *@LastEditTime: 
*/

namespace backend\actions;

use backend\actions\helpers\Helper;
use Yii;
use Closure;
use stdClass;
use yii\web\Response;
use yii\base\Action;
use yii\base\Exception;
use yii\web\UnprocessableEntityHttpException;

class UpdateAction extends Action
{
    const UPDATE_REFERER = "_updaste_referer";

    /** @var string|array 主键名 */
    public $primaryKeyIdentity = 'id';
    /** @var string 主键获得方式,默认为GET */
    public $primaryKeyFromMethod = "GET";
    /** @var array|closure 分配给视图的变量 */
    public $data;
    /** @var string|array 成功更新重定向 */
    public $successRedirect;
    /** @var closure 真正的修改逻辑,通常会调用服务层更新方法 */
    public $doUpdate;
    /** @var string 成功修改后的消息提示 */
    public $successTipsMessage = "success";
    /** @var string 视图模板路径,通常是动作名 */
    public $viewFile = null;

    public function init()
    {
        parent::init();
        if ($this->successTipsMessage == "success") {
            $this->successTipsMessage = "成功";
        }
    }

    public function run()
    {
        //根据指定的HTTP方法和参数名称获取值。将传递给$this->doUpdate closure和$this->data closure。通常用于获取主键的值。
        $primaryKeys = Helper::getPrimaryKeys($this->primaryKeyIdentity, $this->primaryKeyFromMethod);
        //如果是POST请求将执行doupdate
        if (Yii::$app->getRequest()->getIsPost()) {
            if (!$this->doUpdate instanceof Closure) {
                throw new Exception(__CLASS__ . "::doUpdate must be closure");
            }
            $postData = Yii::$app->getRequest()->post();
            $updateData = [];//传递给doUpdate必包的形参
            if (!empty($primaryKeys)) {
                foreach ($primaryKeys as $primaryKey ) {
                    array_push($updateData, $primaryKey);
                }
            }

            array_push($updateData, $postData , $this);
            $updateResult = call_user_func_array($this->doUpdate, $updateData);

            if (Yii::$app->getRequest()->getIsAjax()) {
                Yii::$app->getResponse()->format = Response::FORMAT_JSON;
                if ($updateResult === true) {
                    return ['code' => 0, 'msg' => 'success', 'data' => new stdClass()];
                } else {
                    throw new UnprocessableEntityHttpException(Helper::getErrorString($updateResult));
                } 
            } else {
                if ($updateResult === true) {
                    Yii::$app->getSession()->setFlash('success', $this->successTipsMessage);
                    if ($this->successRedirect) {
                        return $this->controller->redirect($this->successRedirect);
                    }
                    $url = Yii::$app->getSession()->get(self::UPDATE_REFERER);
                    if ($url) {
                        return $this->controller->redirect($url);
                    }
                    return $this->controller->redirect(["index"]);
                } else {
                    Yii::$app->getSession()->setFlash('error', Helper::getErrorString($updateResult));
                }
                
            }
            
        }

        if (is_array($this->data)) {
            $data = $this->data;
        } elseif ($this->data instanceof Closure) {
            $params = [];
            if (!empty($primaryKeys)) {
                foreach ($primaryKeys as $primaryKey ) {
                    array_push($params, $primaryKey);
                }
            }
            !isset($updateResult) & $updateResult = null;
            array_push($params, $updateResult, $this);
            $data = call_user_func_array($this->data, $params);
        } else {
            throw new Exception(__CLASS__ . "::data only allows array or closure (with return array)");
        }

        $this->viewFile === null && $this->viewFile = $this->id;
        Yii::$app->getRequest()->getIsGet() && Yii::$app->getSession()->set(self::UPDATE_REFERER, Yii::$app->getRequest()->getReferrer());
        return $this->controller->render($this->viewFile, $data);
        
    }
}

