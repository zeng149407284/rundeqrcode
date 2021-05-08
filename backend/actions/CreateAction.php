<?php

/*
 *@ClassName: CreateAction
 *@Description: 操作类(创建)
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-29 09:16:31
 *@LastEditors: 
 *@LastEditTime: 
*/
namespace backend\actions;

use Yii;
use Closure;
use stdClass;
use backend\actions\helpers\Helper;
use yii\base\Action;
use yii\base\Exception;
use yii\web\Response;
use yii\web\UnprocessableEntityHttpException;

class CreateAction extends Action
{
    const CREATE_REFERER = "_create+referer";

    /** @var string|array 主键名 */
    public $primaryKeyIdentity = null;

    /** @var string 主键名获取方式 (GET or POST) */
    public $primaryKeyFromMethod = "GET";

    /** @var array|\Closure 变量将分配给视图 */
    public $data;

    /** @var string|array 成功重定向,默认是referre url */
    public $successRedirect = null;

    /** @var Closure 真正的创建逻辑，通常会调用服务层的创建方法 */
    public $doCreate;

    /** @var string 成功后更新页面顶部显示的提示消息 */
    public $successTipsMessage = "success";

    /** @var string 视图模板文件,默认是action id */
    public $viewFile = null;

    public function init()
    {
        parent::init();
        if ($this->successTipsMessage === "success") {
            $this->successTipsMessage = "成功！";
        }
    }

    public function run()
    {
        //根据指定的HTTP方法和参数获取操作
        $primaryKeys = Helper::getPrimaryKeys($this->primaryKeyIdentity, $this->primaryKeyFromMethod);
        //判断如果是POST操作
        if (Yii::$app->getRequest()->getIsPost()) {
            //动作判断
            if (!$this->doCreate instanceof Closure) {
                throw new Exception(__CLASS__ . "::doCreate must be closure");   
            }
            //得到传递的参数
            $postData = Yii::$app->getRequest()->post();
            //createData参数包: 传递给doCreate必包的形参
            $createData = [];

            if (!empty($primaryKeys)) {
                foreach ($$primaryKeys as $primaryKey) {
                    array_push($createData,$primaryKey);
                }
            }

            array_push($createData,$postData,$this);
            //调用docreate
            $createResult = call_user_func_array($this->doCreate, $createData);
            //判断是否有Ajax
            if (Yii::$app->getRequest()->getIsAjax()) {
                Yii::$app->getRequest()->format = Response::FORMAT_JSON;
                //只有$createResult为true表示创建成功
                if ($createResult === true) {
                    return ['code' => 0, 'msg' => 'success', 'data' => new stdClass()];
                } else {
                    throw new UnprocessableEntityHttpException(Helper::getErrorString($createResult));
                }
            } else {
                if ($createResult === true) {
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

        if (is_array($this->data)) {
            $data = $this->data;
        } else if ($this->data instanceof Closure) {
            $params = [];
            if (!empty($primaryKeys)) {
                foreach ($primaryKeys as $primaryKey ) {
                    array_push($params, $primaryKey);
                }
            }
            !isset($createResult) && $createResult = null;
            array_push($params, $createResult, $this);
            $data = call_user_func_array($this->data, $params);
        } else {
            throw new Exception(__CLASS__ . "::data only allows array or closure (with return array)");
            
        }
        $this->viewFile === null && $this->viewFile = $this->id;
        Yii::$app->getRequest()->getIsGet() && Yii::$app->getSession()->set(self::CREATE_REFERER, Yii::$app->getRequest()->getReferrer());
        return $this->controller->render($this->viewFile, $data);
        
    }
}
