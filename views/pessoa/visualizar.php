<?php
	use yii\widgets\DetailView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
	echo Html::tag('h1', 'Pessoa');
	echo Html::a('Voltar', ['pessoa/listar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo DetailView::widget([
		'model' => $pessoa,
		'attributes' => [
			'IdPessoa',
			'Nome',
		],
	]);
?>