<?php
/*
 *@ClassName: index.php
 *@Description: 默认页模板
 *Version: V1.0.0
 *@Author: zenglinbo
 *@Email: 149407284@qq.com
 *@Date: 2021-04-27 14:03:45
 *@LastEditors: 
 *@LastEditTime: 
*/

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/** @var yii\gii\generators\crud\Generator $generator */
$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use <?=$generator->indexWidgetType === 'grid' ? "backend\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
<?=$generator->enablePjax ? 'use yii\widgets\Pjax;' : '' ?>

/** @var $this yii\web\View */
<?=!empty($generator->searchModelClass) ? "/* @var \$searchModel " . ltrim($generator->searchModelClass, '\\') . " */\n" : '' ?>
$this->params['breadcrumbs'][] = '<?=Inflector::camel2words(StringHelper::basename($generator->modelClass))?>'
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?="<?= \$this->render('/widgets/_ibox-title') ?>"?>
            <div class="ibox-content">
                <?="<?=Bar::widgets() ?>\n"?>
                <?php  if (!empty($generator->searchModelClass)) {
                    echo "<?=\$this->render('_search', ['model' => \$searchModel]); ?>\n";
                }?>
                <?=$generator->enablePjax ? '<?php Pjax::begin(); ?>' :''?>
                <?php if($generator->indexWidgetType == 'grid'): ?>
                <?= "<?= " ?>GridView::widgets([
                                'dataProvider' => $dataProvider,
                                <?= !empty($generator->searchModelClass) ? 
                                    "'filterModel' => \$searchModel,\n       'columns' => [\n" : "'columns' => [\n"; ?>
                                ['class' => CheckboxColumn::className()],
                <?php
                    $count = 0;
                    if (($tableSchema = $generator->getTableSchema()) === false) {
                        foreach ($generator->getColumnNames() as $name) {
                            if (++$count < 6) {
                                echo "            '" . $name . "',\n";
                            } else {
                                echo "             //'" . $namev . "',\n";
                            }
                        }
                    } else {
                        foreach ($tableSchema->columns as $column) {
                            $format = $generator->generateColumnFormat($column);
                            if (++$count < 6) {
                                echo "           '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                            } else {
                                echo "           //'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
                            }
                            
                        }
                    }
                    
                ?>
                                ['class' => ActionColumn::className(),],
                            ],
                        ]); ?>
                <?php else: ?>
                    <?= "<?= " ?>ListView::widgets([
                        'dataProvider' => $dataProvider,
                        'itemOptions' => ['class' => 'item'],
                        'itemView' => function ($model, $key, $index, $widget) {
                            return Html::a(Html::encode($model-><?=$nameAttribute?>), ['view', <?= $urlParams?>]);
                        },
                    ]) ?>
                <?php endif; ?>
                <?= $generator->enablePjax ? '<?php Pjax::end(); ?>' : '' ?>
            </div>
        </div>
    </div>
</div>




