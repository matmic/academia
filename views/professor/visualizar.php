<?php
	use yii\widgets\DetailView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
	echo Html::tag('h1', 'Professor');
	echo Html::a('Voltar', ['professor/listar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo '<div class="table-responsive">';
	echo DetailView::widget([
		'model' => $professor,
		'attributes' => [
			'IdProfessor',
			'Nome',
			'Email',
			[
				'attribute' => 'DataInclusao',
				'format' => ['date', 'php:d/m/Y'],
			],
			'IndicadorAtivo',
		],
	]);
	echo '</div>';
?>