<?php
	use yii\widgets\DetailView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
	echo Html::tag('h1', 'Grupo');
	echo Html::a('Voltar', ['grupo/listar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo DetailView::widget([
		'model' => $grupo,
		'attributes' => [
			'IdGrupo',
			'Nome',
		],
	]);
?>