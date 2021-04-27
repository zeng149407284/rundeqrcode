<?php
/*
 *@ClassName: ServiceInface.php
 *@Description: 后台GII增删查改服务组件接接口模板
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-27 10:23:44
 *@LastEditors: 
 *@LastEditTime: 
*/

use yii\helpers\StringHelper;

/** @var yii\gii\generators\crud\Generator $generator */
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

echo "<?php\n";
?>

namespace common\services;

interface <?=$modelClass?>ServiceInterface extends ServiceInterface
{
    const ServiceName = '<?=lcfirst($modelClass)?>Service';
}






