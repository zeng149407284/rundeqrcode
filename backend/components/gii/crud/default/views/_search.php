<?php
/*
 *@ClassName: _search.php
 *@Description: 搜索模板
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-27 15:59:01
 *@LastEditors: 
 *@LastEditTime: 
*/

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var $this yii\web\View */
/** @var yii\gii\generators\crud\Generator $generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use backend\widgets\ActiveForm;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $model <?=ltrim($generator->searchModelClass, '\\')?> */
/** @var $form yii\widgets\ActiveForm */
?>

<div class="<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?>-search ibox-heading row search" style="margin-top: 5px;padding-top:5px">
<?="<?php "?>$form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]);?>
<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    if (++$count < 6) {
        echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    } else {
        echo "    <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
    }  
}
?>
    <div class="col-sm-3">
        <div class="col-sm-6">
            <?= "<?= " ?>Html::submitButton(<?=$generator->generateString('Search')?>, ['class' => 'btn btn-primary btn-block']) ?>
        </div>
        <div class="col-sm-6">
            <?= "<?= "?>Html::a(<?=$generator->generateString('Reset')?>, Url::to(['index']), ['class' => 'btn btn-default btn-block']) ?>
        </div>
    </div>
    <?= "<?php "?>ActiveForm::end(); ?>
</div>

