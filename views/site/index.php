<?php

use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = Yii::$app->name;
?>
        <h1>З вясёлымі Калядамі цябе!</h1>

        <p class="lead">А каб атрымаць падарункі, табе трэба прайсці квэст</p>

        <p><a class="btn btn-lg btn-success" href="<?= Url::to(['/site/quest']) ?>">Пачаць квэст</a></p>
