<?php

use yii\helpers\Html;
use backend\widgets\ActiveForm;
use yii\helpers\Url;

/** @var $this yii\web\View */
/** @var $model app\models\search\MenuSearch */
/** @var $form yii\widgets\ActiveForm */
?>

<div class="menu-search ibox-heading row search" style="margin-top: 5px;padding-top:5px">
<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]);?>
    <?= $form->field($model, 'id', 
            ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
            'size' => 8, 'options' => ['class' => 'col-sm-3']]) ?>

    <?= $form->field($model, 'type', 
            ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
            'size' => 8, 'options' => ['class' => 'col-sm-3']]) ?>

    <?= $form->field($model, 'parent_id', 
            ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
            'size' => 8, 'options' => ['class' => 'col-sm-3']]) ?>

    <?= $form->field($model, 'name', 
            ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
            'size' => 8, 'options' => ['class' => 'col-sm-3']]) ?>

    <?= $form->field($model, 'url', 
            ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
            'size' => 8, 'options' => ['class' => 'col-sm-3']]) ?>

    <?php // echo $form->field($model, 'icon', 
            ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
            'size' => 8, 'options' => ['class' => 'col-sm-3']]) ?>

    <?php // echo $form->field($model, 'sort', 
            ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
            'size' => 8, 'options' => ['class' => 'col-sm-3']]) ?>

    <?php // echo $form->field($model, 'target', 
            ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
            'size' => 8, 'options' => ['class' => 'col-sm-3']]) ?>

    <?php // echo $form->field($model, 'is_absolute_url', 
            ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
            'size' => 8, 'options' => ['class' => 'col-sm-3']]) ?>

    <?php // echo $form->field($model, 'is_display', 
            ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
            'size' => 8, 'options' => ['class' => 'col-sm-3']]) ?>

    <?php // echo $form->field($model, 'created_at', 
            ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
            'size' => 8, 'options' => ['class' => 'col-sm-3']]) ?>

    <?php // echo $form->field($model, 'updated_at', 
            ['labelOptions' => ['class' => 'col-sm-4 control-label'], 
            'size' => 8, 'options' => ['class' => 'col-sm-3']]) ?>

    <div class="col-sm-3">
        <div class="col-sm-6">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary btn-block']) ?>
        </div>
        <div class="col-sm-6">
            <?= Html::a('Reset', Url::to(['index']), ['class' => 'btn btn-default btn-block']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>

