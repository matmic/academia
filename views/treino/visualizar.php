<?php
	use yii\widgets\DetailView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
	echo Html::tag('h1', 'Treino');
	echo Html::a('Voltar', ['treino/listar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	//\yii\helpers\VarDumper::dump($treino, 10, true);die;
	
	echo DetailView::widget([
		'model' => $treino,
		'attributes' => [
			'IdTreino',
			'NomeProfessor',
			'NomeAluno',
			'Nome',
			'Objetivos',
			'DataInclusao',
			'IndicadorAtivo',
		],
	]);
?>