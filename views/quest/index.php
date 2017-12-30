<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Quest Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="quest-task-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Quest Task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'task:ntext',
            'key',
            'passed',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
