<?php
/*
 *@ClassName: ViewAction
 *@Description: 视图
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-05-08 10:24:17
 *@LastEditors: 
 *@LastEditTime: 
*/

namespace backend\actions;

use backend\actions\helpers\Helper;
use Closure;
use yii\base\Action;
use yii\base\Exception;

class ViewAction extends Action
{
    public $primaryKeyIdentity = 'id';

    public $primaryKeyFromMethod = "GET";

    public $data;

    public $viewFile = 'view';

    public function run()
    {
        if (is_array($this->data)) {
            $data = $this->data;
        } elseif ($this->data instanceof Closure) {
            $primaryKeys = Helper::getPrimaryKeys($this->primaryKeyIdentity, $this->primaryKeyFromMethod);
            $getDataParams = $primaryKeys;
            array_push($getDataParams, $this);
            $data = call_user_func_array($this->data, $getDataParams);
            if (!is_array($data)) {
                throw new Exception(__CLASS__ . "::data closure must return array");
                
            }
        } else {
            throw new Exception(__CLASS__ . "::data only allows array or closure (with return array)");
            
        }
        return $this->controller->render($this->viewFile, $data);
    }
}

