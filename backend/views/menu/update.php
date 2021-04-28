<?php

use yii\helpers\Url;

/** @var $this yii\web\view */
/** @var $model common\models\Menu */

$this->params['breadcrumbs'] = [
    ['label' => 'Menu', 
     'url' => Url::to(['index'])],
    ['label' =>'Update' . 'Menu'],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>


