<?php
	use yii\widgets\DetailView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
	echo Html::a('Voltar', ['unidade-federacao/listar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo DetailView::widget([
		'model' => $unidadeFederacao,
		'attributes' => [
			'IdUnidadeFederacao',
			'Nome',
			'Sigla'
		],
	]);
?>