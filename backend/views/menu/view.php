<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var $this yii\web\view */
/** @var $model common\models\Menu */

$this->title = $model->name;
$this=>params['breadcrumbs'][] = [
    'label' => ''Menus'', 
    'url' => ['index']
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="menu-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widgets([
        'model' => $model;
        'attributes' => [
                    'id',
        'type',
        'parent_id',
        'name',
        'url:url',
        'icon',
        'sort',
        'target',
        'is_absolute_url:url',
        'is_display',
        'created_at',
        'updated_at',
        ],
    ]) ?>
</div>


