<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	use yii\widgets\MaskedInput;
	
	echo Html::tag('h1', 'Formulário de Pessoa');
	
	$form = ActiveForm::begin([
		'id' => 'frmPessoa',
		'action' => Url::to(['pessoa/editar'], true),
		'method' => 'POST',
		'options' => ['class' => 'form-horizontal'],
	]);
	
	echo Html::activeHiddenInput($pessoa, 'IdPessoa', []);
	echo $form->field($pessoa, 'Nome');
	echo $form->field($pessoa, 'CPF')->textInput(['type'=>'number'])->widget(MaskedInput::className(), ['mask' => '999.999.999-99', 'clientOptions' => ['removeMaskOnSubmit' => true]]);
	//echo $form->field($pessoa, 'DataNascimento')->widget(\yii\jui\DatePickerDatePicker::class, ['language' => 'pt-BR', 'dateFormat' => 'dd/mm/YYYY']);
	echo $form->field($pessoa, 'DataNascimento')->textInput(['type' => 'date', 'max' => '2999-12-31']);
	echo $form->field($pessoa, 'Email')->textInput(['type' => 'email']);
	
	echo Html::submitButton('Salvar', ['class' => 'btn btn-primary']);
	echo Html::button('Voltar', ['onclick'=>'window.location.href = "' . Url::to(['pessoa/listar'], true) . '"', 'class'=>'btn btn-secondary']);
	
	ActiveForm::end();
?>