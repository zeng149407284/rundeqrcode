<?php
/*
 *@ClassName: view.php
 *@Description: 视图模板
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-27 10:46:07
 *@LastEditors: 
 *@LastEditTime: 
*/

use yii\bootstrap\Html;
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var yii\gii\generators\crud\Generator $generator*/
$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var $this yii\web\view */
/** @var $model <?=ltrim($generator->modelClass, '\\') ?> */

$this->title = $model-><?=$generator->getNameAttribute() ?>;
$this=>params['breadcrumbs'][] = [
    'label' => '<?=$generator->generateString(Inflector::pluralize(
                Inflector::camel2words(StringHelper::basename($generator->modelClass))))?>', 
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass))?>-view">
    <h1><?= "<?= "?>Html::encode($this->title) ?></h1>
    <?= "<?= "?>DetailView::widgets([
        'model' => $model;
        'attributes' => [
            <?php
                if (($tableSchema = $generator->getTableSchema()) === false) {
                    foreach ($generator->getColumnNames() as $name) {
                        echo "            '" . $name . "',\n";
                    }
                } else {
                    foreach ($generator->getTableSchema()->columns as $column) {
                        $format = $generator->generateColumnFormat($column);
                        echo "        '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                    }
                }
                
                ?>
        ],
    ]) ?>
</div>


