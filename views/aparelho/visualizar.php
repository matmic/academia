<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $aparelho->Nome;
$this->params['breadcrumbs'][] = ['label' => 'Exercícios', 'url' => ['listar']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);
echo Html::a('Editar', Url::to(['aparelho/editar', 'IdAparelho'=>$aparelho->IdAparelho], true), ['style'=>'margin-bottom: 10px', 'class'=>'botoesSalvarVoltar btn btn-primary']);
echo Html::button('Voltar', ['onClick'=>'window.history.back();', 'style'=>'margin-bottom: 10px', 'class'=>'botoesSalvarVoltar btn btn-secondary']);
?>

<div class="table-responsive">
    <?php
    echo DetailView::widget([
        'model' => $aparelho,
        'attributes' => [
            'Nome',
            'grupo.Nome',
        ],
    ]);
    ?>
</div>