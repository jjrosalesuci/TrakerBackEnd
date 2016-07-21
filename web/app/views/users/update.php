<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DatUser */

$this->title = 'Update Dat User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dat Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dat-user-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
