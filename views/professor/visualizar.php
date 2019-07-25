<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\widgets\DetailView;
	
	$this->title = 'Professor';
	$this->params['breadcrumbs'][] = ['label' => 'Listar', 'url' => ['listar']];
	$this->params['breadcrumbs'][] = $this->title;
	
	echo Html::tag('h1', $this->title);
	echo Html::button('Voltar', ['onClick'=>'window.history.back();', 'style'=>'margin-bottom: 10px', 'class'=>'btn btn-secondary']);
	
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