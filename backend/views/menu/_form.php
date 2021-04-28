<?php

use backend\widgets\ActiveForm;

/** @var $this yii\web\View */
/** @var $model common\models\Menu */
/** @var $form backend\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?=$this->render('/widgets/_ibox-title')?>
            <div class="ibox-content">
                <?php $form = ActiveForm::begin([
                    'options' => [
                        'class' => 'form-horizontal;
                    ]
                ]); ?>
                <div class="hr-line-dashed">
                        <?= $form->field($model, 'type')->textInput() ?>
                      <div class="hr-line-dashed"></div>

                      <?= $form->field($model, 'parent_id')->textInput() ?>
                      <div class="hr-line-dashed"></div>

                      <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                      <div class="hr-line-dashed"></div>

                      <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                      <div class="hr-line-dashed"></div>

                      <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
                      <div class="hr-line-dashed"></div>

                      <?= $form->field($model, 'sort')->textInput() ?>
                      <div class="hr-line-dashed"></div>

                      <?= $form->field($model, 'target')->textInput(['maxlength' => true]) ?>
                      <div class="hr-line-dashed"></div>

                      <?= $form->field($model, 'is_absolute_url')->textInput() ?>
                      <div class="hr-line-dashed"></div>

                      <?= $form->field($model, 'is_display')->textInput() ?>
                      <div class="hr-line-dashed"></div>

                      <?= $form->field($model, 'created_at')->textInput() ?>
                      <div class="hr-line-dashed"></div>

                      <?= $form->field($model, 'updated_at')->textInput() ?>
                      <div class="hr-line-dashed"></div>

                            <?=$form->defaultButtons() ?>
                        <?php ActiveForm::end();?>
                </div>
            </div>
        </div>
    </div>
</div>

