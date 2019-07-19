<?php
	use yii\grid\GridView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
	echo Html::tag('h1', 'Meus Alunos');
	echo Html::a('Novo', ['professor/editar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			'aluno.Nome',
			// [
				// 'attribute' => 'DataInclusao',
				// 'format' => ['date', 'php:d/m/Y'],
			// ],
			[
				'header' => 'Operações',
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view} {update}',
				'buttons' => [
					'view' => function($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',  Url::to(['aluno/visualizar', 'IdAluno' => $model->IdAluno], true));
					},
					'update' => function($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>',  Url::to(['aluno/editar', 'IdAluno' => $model->IdAluno], true));
					},
				],
			],
		],
	]);
?>