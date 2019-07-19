<?php
	use yii\widgets\DetailView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\grid\GridView;
	
	echo Html::tag('h1', 'Treino');
	echo Html::a('Voltar', ['treino/listar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo '<div class="table-responsive">';
	echo DetailView::widget([
		'model' => $treino,
		'attributes' => [
			'IdTreino',
			'professor.Nome',
			'aluno.Nome',
			'Nome',
			'Objetivos',
			'DataInclusao',
			'IndicadorAtivo',
		],
	]);
	echo '</div>';
	
	echo '<div class="table-responsive">';
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			[
				'attribute' => 'aparelho.grupo.Nome',
				'label' => 'Grupo',
				'value' => 'aparelho.grupo.Nome',
			],
			[
				'attribute' => 'aparelho.Nome',
				'label' => 'Aparelho',
				'value' => 'aparelho.Nome',
			],
			'Series',
			'Repeticoes',
			'Peso',
		],
	]);
	echo '</div>';
?>