<?php

use yii\helper\Url;

/** @var $this yii\web\View */
/** @var $model common\models\Menu */

$this->params['breadcrumbs'] = [
    ['label' => 'Menu',
     'url' => Url::to(['index'])],
    ['label' => 'Create' . 
    'Menu'],
];
?>
<?= $this->render('_form', [
    'model' => $model,
]) ?>


