<?php
	use yii\grid\GridView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
	echo Html::tag('h1', 'Alunos');
	echo Html::a('Novo', ['aluno/editar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo '<div class="table-responsive">';
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			'IdAluno',
			'Nome',
			[
				'attribute' => 'DataNascimento',
				'format' => ['date', 'php:d/m/Y'],
			],
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
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',  Url::to(['aluno/visualizar', 'IdAluno' => $key], true));
					},
					'update' => function($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>',  Url::to(['aluno/editar', 'IdAluno' => $key], true));
					},
				],
			],
		],
	]);
	echo '</div>';
?>