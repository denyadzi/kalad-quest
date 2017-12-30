<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\QuestTask */

$this->title = 'Update Quest Task';
$this->params['breadcrumbs'][] = ['label' => 'Quest Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="quest-task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
