<?php
/*
 *@ClassName: Service.php
 *@Description: 后台GII增删查改服务组件接模板
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

<?php if(!empty($generator->searchModelClass)): ?>
use <?=$generator->searchModelClass . ";\n" ?>
<?php endif; ?>
use <?= $generator->modelClass . ";\n" ?>

class <?=$modelClass?>Service extends Service implements <?=$modelClass?>ServiceInterface
{
    public function getSearchModel(array $query = [], array $options = [])
    {
        <?php if (!empty($generator->searchModelClass)) { ?>
            return new <?=$searchModelClass?>();
        <?php } else { ?>
            return null;
        <?php } ?>
    }

    public function getModel($id, array $options = [])
    {
        return <?=$modelClass?>::findOne($id);
    }

    public function newModel(array $options = [])
    {
        $model = new <?=$modelClass?>();
        $model->loadDefaultValues();
        return $model;
    }
}

