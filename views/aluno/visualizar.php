<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\DetailView;

$this->title = $aluno->Nome;
$this->params['breadcrumbs'][] = ['label' => 'Alunos', 'url' => ['listar']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);
echo Html::button('Editar', ['onClick'=>'window.location.href="' . Url::to(['aluno/editar', 'IdAluno'=>$aluno->IdAluno], true) .'";', 'style'=>'margin-bottom: 10px', 'class'=>'botoesSalvarVoltar btn btn-primary']);
echo Html::button('Voltar', ['onClick'=>'window.history.back();', 'style'=>'margin-bottom: 10px', 'class'=>'botoesSalvarVoltar btn btn-secondary']);
?>

<fieldset>
    <legend style="cursor: pointer;" data-toggle="collapse" data-target="#divDadosAluno">
        Dados do Aluno
    </legend>
    <div class="collapse table-responsive" id="divDadosAluno">
        <?php
        echo DetailView::widget([
            'model' => $aluno,
            'attributes' => [
                'Nome',
                [
                    'attribute' => 'DataNascimento',
                    'format' => ['date', 'php:d/m/Y'],
                ],
                [
                    'attribute' => 'IndicadorDorPeitoAtividadesFisicas',
                    'value' => function ($data) {
                        return ($data->IndicadorDorPeitoAtividadesFisicas == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                ],
                [
                    'attribute' => 'IndicadorDorPeitoUltimoMes',
                    'value' => function ($data) {
                        return ($data->IndicadorDorPeitoUltimoMes == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                ],
                [
                    'attribute' => 'IndicadorPerdaConscienciaTontura',
                    'value' => function ($data) {
                        return ($data->IndicadorPerdaConscienciaTontura == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                ],
                [
                    'attribute' => 'IndicadorProblemaArticular',
                    'value' => function ($data) {
                        return ($data->IndicadorProblemaArticular == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                ],
                [
                    'attribute' => 'IndicadorTabagista',
                    'value' => function ($data) {
                        return ($data->IndicadorTabagista == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                ],
                [
                    'attribute' => 'IndicadorDiabetico',
                    'value' => function ($data) {
                        return ($data->IndicadorDiabetico == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                ],
                [
                    'attribute' => 'IndicadorFamiliarAtaqueCardiaco',
                    'value' => function ($data) {
                        return ($data->IndicadorFamiliarAtaqueCardiaco == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
                    },
                ],
                'Lesoes',
                'Observacoes',
                'TreinoEspecifico',
                [
                    'attribute' => 'DataInclusao',
                    'format' => ['date', 'php:d/m/Y'],
                ],
                'IndicadorAtivo',
                [
                    'label' => 'Disponibilidade',
                    'value' => $aluno->getDisponibilidadesTexto(),
                ]
            ],
        ]);
        ?>
    </div>
</fieldset>

<fieldset>
    <legend style="cursor: pointer;" data-toggle="collapse" data-target="#divTreinos">
        Treinos
    </legend>
    <div class="table-responsive collapse" id="divTreinos">
        <?php
        echo GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'attribute' => 'professor',
                    'label' => 'Professor',
                    'value' => 'professor.Nome',
                ],
                'Nome',
                'Objetivos',
                'DataInclusao',
                'IndicadorAtivo',
                [
                    'header' => 'Operações',
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view} {update}',
                    'buttons' => [
                        'view' => function($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',  Url::to(['treino/visualizar', 'IdTreino' => $key], true));
                        },
                        'update' => function($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>',  Url::to(['treino/editar', 'IdTreino' => $key], true));
                        },
                    ],
                ],
            ],
        ]);
        ?>
    </div>
</fieldset>