<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	
	$this->title = 'Formulário de Grupo';
	$this->params['breadcrumbs'][] = ['label' => 'Listar', 'url' => ['listar']];
	$this->params['breadcrumbs'][] = $this->title;
	
	echo Html::tag('h1', $this->title);
	
	$form = ActiveForm::begin([
		'id' => 'frmGrupo',
		'action' => Url::to(['grupo/editar'], true),
		'method' => 'POST',
		'options' => [],
	]);
	
	echo Html::activeHiddenInput($grupo, 'IdGrupo', []);
	echo $form->field($grupo, 'Nome');

	echo Html::submitButton('Salvar', ['class' => 'botoesSalvarVoltar btn btn-primary']);
	echo Html::button('Voltar', ['onClick'=>'window.history.back();', 'class'=>'botoesSalvarVoltar btn btn-secondary']);
	
	ActiveForm::end();
?>