<?php
	use yii\grid\GridView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
	echo Html::tag('h1', 'Pessoas');
	echo Html::a('Nova', ['pessoa/editar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			'IdPessoa',
			'Nome',
			[
				'header' => 'Operações',
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view} {update}',
				'buttons' => [
					'view' => function($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',  Url::to(['pessoa/visualizar', 'IdAparelho'=>$key], true));
					},
					'update' => function($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>',  Url::to(['pessoa/editar', 'IdAparelho'=>$key], true));
					},
				],
			],
		],
	]);
?>