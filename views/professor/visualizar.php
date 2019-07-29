<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Professor';
$this->params['breadcrumbs'][] = ['label' => 'Professores', 'url' => ['listar']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);
echo Html::a('Editar', Url::to(['professor/editar', 'IdProfessor'=>$professor->IdProfessor], true), ['style'=>'margin-bottom: 10px', 'class'=>'botoesSalvarVoltar btn btn-primary']);
echo Html::button('Voltar', ['onClick'=>'window.history.back();', 'style'=>'margin-bottom: 10px', 'class'=>'botoesSalvarVoltar btn btn-secondary']);
?>

<div class="table-responsive">
    <?php
    echo DetailView::widget([
        'model' => $professor,
        'attributes' => [
            'Nome',
            'Email',
            [
                'attribute' => 'DataInclusao',
                'format' => ['date', 'php:d/m/Y'],
            ],
            'IndicadorAtivo',
        ],
    ]);
    ?>
</div>