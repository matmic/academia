<?php
	use yii\grid\GridView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			'IdUnidadeFederacao',
			'Nome',
			'Sigla',
			[
				'header' => 'Operações',
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view} {update}',
				'buttons' => [
					'view' => function($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',  Url::to(['unidade-federacao/visualizar', 'IdUnidadeFederacao'=>$key], true));
					},
					'update' => function($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>',  Url::to(['unidade-federacao/editar', 'IdUnidadeFederacao'=>$key], true));
					},
				],
			],
		],
	]);
?>