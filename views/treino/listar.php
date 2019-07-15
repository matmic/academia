<?php
	use yii\grid\GridView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
	echo Html::tag('h1', 'Treino');
	echo Html::a('Novo', ['treino/editar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			[
				'attribute' => 'professor.Nome',
				'label' => 'Professor',
			],
			[
				'attribute' => 'aluno.Nome',
				'label' => 'Aluno',
			],
			'Nome',
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