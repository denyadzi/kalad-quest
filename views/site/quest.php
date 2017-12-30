<?php

use yii\helpers\{Html, Url};
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\QuestForm */
/* @var $form ActiveForm */

$this->title = 'Калядны квэст у вёсцы';
?>
<div class="quest-quest">

    <h3>Перад табой падказка дзе шукаць ключ &mdash; знайдзі яго і ўвядзі ў тэкставае поле</h3>

    <?php $form = ActiveForm::begin([
        'id' => 'quest-form', 
        'method' => 'POST',
        'action' => ['/site/quest-check', 'id' => $model->id],
    ]); ?>
        <?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput(['id' => 'quest-task-id']) ?>

        <p class="quest-task">
          <?= $model->task ?>
        </p>

        <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>
    
        <div class="form-group">
            <?= Html::submitButton('Адказ', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- quest-quest -->
