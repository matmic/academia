<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	
	echo Html::tag('h1', 'Formulário de Professor');
	
	$form = ActiveForm::begin([
		'id' => 'frmProfessor',
		'action' => Url::to(['professor/editar'], true),
		'method' => 'POST',
		'options' => ['class' => 'form-horizontal'],
	]);
	
	echo Html::activeHiddenInput($professor, 'IdProfessor', []);
	echo $form->field($professor, 'Nome');
	echo $form->field($professor, 'Email')->TextInput(['type'=>'email']);

	echo Html::submitButton('Salvar', ['class' => 'btn btn-primary']);
	echo Html::button('Voltar', ['onclick'=>'window.location.href = "' . Url::to(['professor/listar'], true) . '"', 'class'=>'btn btn-secondary']);
	
	ActiveForm::end();
?>