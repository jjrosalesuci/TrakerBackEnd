<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DatUser */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Dat Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dat-user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'names',
            'lastname',
            'sex',
            'password',
            'email:email',
            'auth_key',
            'role',
            'status',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
