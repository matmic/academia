<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Professores';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);
echo Html::a('Novo', ['professor/editar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
?>

<div class="table-responsive">
    <?php
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'Nome',
            'Email',
            [
                'attribute' => 'DataInclusao',
                'format' => ['date', 'php:d/m/Y'],
            ],
            'IndicadorAtivo',
            [
                'header' => 'Operações',
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update}',
                'buttons' => [
                    'view' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',  Url::to(['professor/visualizar', 'IdProfessor' => $key], true));
                    },
                    'update' => function($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>',  Url::to(['professor/editar', 'IdProfessor' => $key], true));
                    },
                ],
            ],
        ],
    ]);
    ?>
</div>