<?php
	use yii\widgets\DetailView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
	echo Html::tag('h1', 'Aparelho');
	echo Html::a('Voltar', ['aparelho/listar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo '<div class="table-responsive">';
	echo DetailView::widget([
		'model' => $aparelho,
		'attributes' => [
			'IdAparelho',
			'Nome',
			'grupo.Nome',
		],
	]);
	echo '</div>';
?>