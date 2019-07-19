<?php
	use yii\widgets\DetailView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
	echo Html::tag('h1', 'Grupo');
	echo Html::a('Voltar', ['grupo/listar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo '<div class="table-responsive">';
	echo DetailView::widget([
		'model' => $grupo,
		'attributes' => [
			'IdGrupo',
			'Nome',
		],
	]);
	echo '</div>';
?>