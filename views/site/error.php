<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        O erro acima ocorreu enquanto o servidor processava sua requisição.
    </p>
    <p>
        Por favor nos contate se você acha que isso é um erro do serviro. Obrigado.
    </p>

</div>
