<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	
	echo Html::tag('h1', 'Formulário de Grupo');
	
	$form = ActiveForm::begin([
		'id' => 'frmGrupo',
		'action' => Url::to(['grupo/editar'], true),
		'method' => 'POST',
		'options' => ['class' => 'form-horizontal'],
	]);
	
	echo Html::activeHiddenInput($grupo, 'IdGrupo', []);
	echo $form->field($grupo, 'Nome');

	echo Html::submitButton('Salvar', ['class' => 'btn btn-primary']);
	echo Html::button('Voltar', ['onclick'=>'window.location.href = "' . Url::to(['grupo/listar'], true) . '"', 'class'=>'btn btn-secondary']);
	
	ActiveForm::end();
?>