<?php

use yii\helpers\Url;

$this->title = 'Fitness Hall Academia';
?>
<div class="site-index">
    <div style="background-color: #fff !important; padding: 0 !important;" class="jumbotron">
        <!--        <h1>Fitness Hall Academia</h1>-->
        <img src="<?= Yii::$app->homeUrl; ?>img/fitness-hall2.png" alt="">
        <p class="lead">Portal para manutenção das fichas de alunos.</p>

        <?php if (Yii::$app->user->isGuest) : ?>
            <p><a class="btn btn-lg btn-success" href="<?= Url::to(['professor/login'], true); ?>">Faça login!</a></p>
        <?php else: ?>
            <p><a class="btn btn-lg btn-success" href="<?= Url::to(['professor/meus-alunos'], true); ?>">Veja seus
                    alunos!</a></p>
        <?php endif; ?>
    </div>
</div>
