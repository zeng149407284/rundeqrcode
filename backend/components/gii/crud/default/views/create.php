<?php
/*
 *@ClassName: create.php
 *@Description: 新建模板
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-27 15:20:04
 *@LastEditors: 
 *@LastEditTime: 
*/

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var $this yii\web\View */
/** @var yii\gii\generators\crud\Generator $generator */
echo "<?php\n"
?>

use yii\helper\Url;

/** @var $this yii\web\View */
/** @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->params['breadcrumbs'] = [
    ['label' => yii::t('app', '<?=Inflector::camel2words(StringHelper::basename($generator->modelClass))?>'),
     'url' => Url::to(['index'])],
    ['label' => yii::t('app', 'Create') . 
     yii::t('app', '<?=Inflector::camel2words(StringHelper::basename($generator->modelClass))?>')],
];
?>
<?="<?= " ?>$this->render('_form', [
    'model' => $model,
]) ?>


