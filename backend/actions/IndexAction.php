<?php

namespace backend\actions;

use Yii;
use Closure;
use backend\actions\helpers\Helper;
use yii\base\Action;
use yii\base\Exception;

class IndexAction extends Action
{
    public $primaryKeyIdentity = null;
    public $primaryKeyFromMethod = "GET";
    public $data;
    public $viewFile = null;

    public function run()
    {
        $primaryKeys = Helper::getPrimaryKeys($this->primaryKeyIdentity, $this->primaryKeyFromMethod);

        $data = $this->data;
        if ($data instanceof Closure) {
            $params = [];
            if (!empty($primaryKeys)) {
                foreach ($primaryKeys as $primaryKey ) {
                    array_push($params, $primaryKey);
                }
            }
            array_push($params,Yii::$app->getRequest()->getQueryParams());
            array_push($params,$this);
            $data = call_user_func_array($this->data,$params);
            if (!is_array($data)) {
                throw new Exception("data closure must return array");
                
            }
        }else if (!is_array($data)) {
            throw new Exception(__CLASS__ . "::data must be array or closure");
            
        }

        $this->viewFile === null && $this->viewFile = $this->id;
        return $this->controller->render($this->viewFile, $data);
    }
}



