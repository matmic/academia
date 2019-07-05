<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	
	$form = ActiveForm::begin([
		'id' => 'frmUnidadeFederacao',
		'action' => Url::to(['unidade-federacao/editar'], true),
		'method' => 'POST',
		'options' => ['class' => 'form-horizontal'],
	]);
	
	echo $form->field($unidadeFederacao, 'IdUnidadeFederacao');
	echo $form->field($unidadeFederacao, 'Nome');
	echo $form->field($unidadeFederacao, 'Sigla');
	echo Html::submitButton('Salvar', ['class' => 'btn btn-primary']);
	echo Html::button('Voltar', ['onclick'=>'window.location.href = "' . Url::to(['unidade-federacao/listar'], true) . '"', 'class'=>'btn btn-secondary']);
	
	ActiveForm::end();
?>