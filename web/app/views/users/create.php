<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\DatUser */

$this->title = 'Create Dat User';
$this->params['breadcrumbs'][] = ['label' => 'Dat Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dat-user-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
