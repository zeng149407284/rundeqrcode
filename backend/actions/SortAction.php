<?php
/*
 *@ClassName: SortAction
 *@Description: 排序动作类
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-30 11:01:01
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
use yii\base\InvalidArgumentException;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use yii\web\UnprocessableEntityHttpException;

class SortAction extends Action
{
    public $doSort = null;
    public $successTipsMessage = "success";

    public function init()
    {
        parent::init();
        if ($this->successTipsMessage === "success") {    
            $this->successTipsMessage = "成功";
        }
    }

    public function run()
    {   
        if (Yii::$app->request->getIsPost()) {
            if (!$this->doSort instanceof Closure ) {
                throw new Exception(__CLASS__ . "::doSort must be closure");
                
            }
            $post = Yii::$app->getRequest()->post();
            if (isset($post[Yii::$app->getRequest()->csrfParam])) {
                unset($post[Yii::$app->getRequest()->csrfParam]);
            }
            reset($post);
            $temp = current($post);
            $condition = array_keys($temp)[0];
            $value = $temp[$condition];
            $condition = json_decode($condition, true);
            if (!is_array($condition)) {
                throw new InvalidArgumentException("SortColumn generate html must post data like xxx[{pk:'unique'}]=number");
            }
            $result = call_user_func_array($this->doSort,[$condition, $value, $this]);

            if (Yii::$app->getRequest()->getIsAjax()) {
                Yii::$app->getResponse()->format = Response::FORMAT_JSON;;
                if ($result === true) {
                    return ['code' => 0,'msg' => 'success', 'data' => new stdClass()];
                } else {
                    throw new UnprocessableEntityHttpException(Helper::getErrorString($result));
                }
            } else {
                if ($result === true) {
                    Yii::$app->getSession()->setFlash('success', $this->successTipsMessage);    
                } else {
                    Yii::$app->getSession()->setFlash('error', Helper::getErrorString($result));
                }
                return $this->controller->goBack();
            }
            
        } else {
            throw new MethodNotAllowedHttpException("排序必须是通过POST传输参数");
        }
    }
}

