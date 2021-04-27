<?php
/*
 *@ClassName: update.php
 *@Description: 修改模板
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-27 11:41:14
 *@LastEditors: 
 *@LastEditTime: 
*/

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var yii\gii\generators\crud\Generator $generator*/
$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Url;

/** @var $this yii\web\view */
/** @var $model <?=ltrim($generator->modelClass, '\\') ?> */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', <?=Inflector::camel2words(
                StringHelper::basename($generator->modelClass))?>'), 
     'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Update') . yii::t('app', '<?=Inflector::camel2words(
                StringHelper::basename($generator->modelClass))?>')],
];
?>
<?= "<?= "?>$this->render('_form', [
    'model' => $model,
]) ?>


