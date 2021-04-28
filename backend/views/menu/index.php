<?php

use backend\widgets\Bar;
use backend\grid\CheckboxColumn;
use backend\grid\ActionColumn;
use backend\grid\GridView;

/** @var $this yii\web\View */
/* @var $searchModel app\models\search\MenuSearch */
$this->params['breadcrumbs'][] = 'Menu'
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>            <div class="ibox-content">
                <?=Bar::widgets() ?>
                <?=$this->render('_search', ['model' => $searchModel]); ?>
                                                <?= GridView::widgets([
                                'dataProvider' => $dataProvider,
                                'filterModel' => $searchModel,
       'columns' => [
                                ['class' => CheckboxColumn::className()],
                           'id',
           'type',
           'parent_id',
           'name',
           'url:url',
           //'icon',
           //'sort',
           //'target',
           //'is_absolute_url:url',
           //'is_display',
           //'created_at',
           //'updated_at',
                                ['class' => ActionColumn::className(),],
                            ],
                        ]); ?>
                                            </div>
        </div>
    </div>
</div>




