<?php
/*
 *@ClassName: helper.php
 *@Description: 
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-28 19:58:36
 *@LastEditors: 
 *@LastEditTime: 
*/

namespace backend\actions\helpers;

use Yii;
use yii\base\Exception;
use yii\base\Model;

class Helper
{
    public static function getPrimaryKeys($primaryKeyIdentity, $primaryKeyFromMethod)
    {
        $primaryKeys = [];

        if (!empty($primaryKeyIdentity)) {
            if (is_string($primaryKeyIdentity)) {
                $primaryKeyIdentity = [$primaryKeyIdentity];
            } else {
                throw new Exception("primaryKeyIdentity must be string or array");    
            }

            foreach ($primaryKeyIdentity as $identity) {
                if ($primaryKeyFromMethod == "GET") {
                    $primaryKeys[] = Yii::$app->getRequest()->get($identity,null);
                } else if ($primaryKeyFromMethod == "POST") {
                    $primaryKeys[] = Yii::$app->getRequest()->post($identity,null);
                } else {
                    throw new Exception("primaryKeyFromMethod must be GET or POST");
                }
            }
        }
        return $primaryKeys;
    }

    public static function getErrorString($result)
    {
        if (!is_string($result)) {
            $results = [$result];
        } else {
            $results = $result;
        }
        $error = "";
        foreach ($results as $result) {
            if ($result instanceof Model) {//如果返回model，返回错误
                $items = $result->getErrors();
                foreach ($items as $item)
                {
                    foreach ($item as $e)
                    {
                        $error .= $e . "<br>";
                    }
                }
                $error = rtrim($error, "<br>");
            } else if (is_string($result)) {
                $error = $result;
            } else {
                throw new Exception("doCreate/doUpdate/doDelete/doSort closure must return boolen, yii\base\Model or string");  
            }
        }
        return $error;
    }
}

