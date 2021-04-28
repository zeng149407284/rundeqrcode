<?php
/*
 *@ClassName: Generator
 *@Description: curd模板类
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-25 15:43:03
 *@LastEditors: 
 *@LastEditTime: 
*/

namespace backend\components\gii\crud;

use Yii;
use ReflectionClass;
use yii\gii\CodeFile;
use yii\gii\generators\crud\Generator as CrudGenerator;
use yii\helpers\StringHelper;

class Generator extends CrudGenerator
{
    /*
     *@Description: 
     *@Param: $attribute
     *@Param: 
     *@return: string
     *@Author: zenglinbo
    */
    public function generateActiveSearchField($attribute)
    {
        $tableSchema = $this->getTableSchema();
        if ($tableSchema === false) {
            return "\$form->field(\$model, '$attribute', 
                ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
                'size' => 8, 'options' => ['class' => 'col-sm-3']])";
        }
        $column = $tableSchema->columns[$attribute];
        if ($column->phpType === 'boolean') {
            return "\$form->field(\$model, '$attribute')->chekbox()";
        }

        return "\$form->field(\$model, '$attribute', 
            ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
            'size' => 8, 'options' => ['class' => 'col-sm-3']])";
    }

    public function formView()
    {
        $class = new ReflectionClass(CrudGenerator::className());
        return dirname($class->getFileName()) . '/form.php';
    }

    public function generate()
    {
        $controllerFile = Yii::getAlias('@' . str_replace('\\', '/', 
            ltrim($this->controllerClass, '\\')) . '.php');
        $files = [
            new CodeFile($controllerFile, $this->render('controller.php'))
        ];

        if (!empty($this->searchModelClass)) {
            $searchModel = Yii::getAlias('@' . str_replace('\\', '/', 
            ltrim($this->searchModelClass, '\\')) . '.php');
            $files[] = new CodeFile($searchModel, $this->render('search.php'));
        }

        $modelClass = StringHelper::basename($this->modelClass);

        $files[] = new CodeFile(Yii::getAlias("@common/services/") . $modelClass . 
            'ServiceInterface.php', $this->render("serviceInterface.php"));
        
        $files[] = new CodeFile(Yii::getAlias("@common/services/") . $modelClass . 
            'Service.php', $this->render("service.php"));
        
        $viewPath = $this->getViewPath();
        $templatePath = $this->getTemplatePath() . '/views';
        foreach (scandir($templatePath) as $file) {
            if (empty($this->searchModelClass) && $file === '_search.php') {
                continue;
            }
            if (is_file($templatePath . '/' . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                $files[] = new CodeFile("$viewPath/$file", $this->render("views/$file"));
            }
        }
        $type = Yii::$app->getRequest()->post("generate");
        if ($type !== null) {
            $services = require Yii::getAlias("@common/config/") . 'services.php';
            $key = $modelClass . "Service";
            if (!isset($services[$key])) {
                $str = file_get_contents(Yii::getAlias("@common/config/") . 'services.php');
                $lines = explode("\n", $str);
                foreach ($lines as $key => $line) {
                    $line = trim($line);
                    if (empty($line)) {
                        unset($lines[$key]);
                    }
                }
                $temp[] = "    \\common\services\\" . $modelClass . "ServiceInterface::ServiceName => [";
                $temp[] = "        'class' => \\common\services\\" . $modelClass . "Service::className(),";
                $temp[] = "    ],";
                array_splice($lines, count($lines) - 1, 0, $temp);
                file_put_contents(Yii::getAlias("@common/config/") . 'services.php', implode("\n", $lines));
            }
        }
        return $files;
    }
}


