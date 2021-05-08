<?php
/*
 *@ClassName: DeleteAction
 *@Description: 删除动作类,只允许POST请求，但可以赋值抛出查询或需要删除记录的正文。
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-29 11:22:05
 *@LastEditors: 
 *@LastEditTime: 
*/
namespace backend\actions;

use Yii;
use stdClass;
use Closure;
use backend\actions\helpers\Helper;
use yii\base\Action;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use yii\web\UnprocessableEntityHttpException;

class DeleteAction extends Action
{
    /** @var string|array 主键名 */
    public $primaryKeyIdentity = "id";
    /** @var Closure  */
    public $doDelete;

    public function run()
    {
            // 删除必须通过POST
        if (Yii::$app->getRequest()->getIsPost()) {
            if(!is_string($this->primaryKeyIdentity))
            {
                throw new Exception(__CLASS__ . "::primaryKeyIdentity only permit string");  
            }
            $data = Yii::$app->getRequest()->post($this->primaryKeyIdentity, null);
            //不在POST参数，单个删除
            if ($data === null) {
                $data = Yii::$app->getRequest()->get($this->primaryKeyIdentity, null);
            }
            if (!$data) {
                throw new BadRequestHttpException("{$this->primaryKeyIdentity} doesn't exist");
            }
            //判断$data数据
            if (is_string($data)) {
                if ((strpos($data, "{") === 0 && strpos(strrev($data), '}') === 0) || (strpos($data,"[") === 0 && strpos(strrev($data),"]") === 0)) {
                    $data = json_decode($data, true);   
                } else {
                    $data = [$data];
                }
                
            }
            !isset($data[0]) && $data = [$data];

            $errors = [];
            foreach ($data as $id ) {
                $deleteResult = call_user_func_array($this->doDelete, [$id, $this]);
                if ($deleteResult !== true && $deleteResult !== "" && $deleteResult !== null) {
                    $errors[] = Helper::getErrorString($deleteResult);
                }
            }
            if (count($errors) == 0) {
                if (Yii::$app->getRequest()->getIsAjax()) {
                    Yii::$app->getResponse()->format = Response::FORMAT_JSON;
                    return ['code' => 0, 'msg' => 'success', 'data' => new stdClass()];
                } else {
                    return $this->controller->redirect(Yii::$app->getRequest()->getReferrer());
                }
                
            } else {
                if (Yii::$app->getRequest()->getIsAjax()) {
                    Yii::$app->getResponse()->format = Response::FORMAT_JSON;
                    throw new UnprocessableEntityHttpException(implode("<br>", $errors));
                } else {
                    Yii::$app->getSession()->setFlash('error', implode("<br>",$errors));
                }
                
            }
            
        } else {
            throw new MethodNotAllowedHttpException("删除必须通过POST办法");
        }
        
    }
}
