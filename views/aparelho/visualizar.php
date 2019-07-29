<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\widgets\DetailView;
	
	$this->title = $aparelho->Nome;
	$this->params['breadcrumbs'][] = ['label' => 'Exercícios', 'url' => ['listar']];
	$this->params['breadcrumbs'][] = $this->title;
	
	echo Html::tag('h1', $this->title);
    echo Html::button('Editar', ['onClick'=>'window.location.href="' . Url::to(['aparelho/editar', 'IdAparelho'=>$aparelho->IdAparelho], true) .'";', 'style'=>'margin-bottom: 10px', 'class'=>'botoesSalvarVoltar btn btn-primary']);
    echo Html::button('Voltar', ['onClick'=>'window.history.back();', 'style'=>'margin-bottom: 10px', 'class'=>'botoesSalvarVoltar btn btn-secondary']);
	
	echo '<div class="table-responsive">';
	echo DetailView::widget([
		'model' => $aparelho,
		'attributes' => [
			'Nome',
			'grupo.Nome',
		],
	]);
	echo '</div>';
?>