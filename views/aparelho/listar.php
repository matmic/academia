<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\grid\GridView;
	
	$this->title = 'Exercícios';
	$this->params['breadcrumbs'][] = $this->title;
	
	echo Html::tag('h1', $this->title);
	echo Html::a('Novo', ['aparelho/editar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo '<div class="table-responsive">';
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			'grupo.Nome',
			'Nome',
			[
				'header' => 'Operações',
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view} {update}',
				'buttons' => [
					'view' => function($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',  Url::to(['aparelho/visualizar', 'IdAparelho'=>$key], true));
					},
					'update' => function($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>',  Url::to(['aparelho/editar', 'IdAparelho'=>$key], true));
					},
				],
			],
		],
	]);
	echo '</div>';
?>