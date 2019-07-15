<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	
	echo Html::tag('h1', 'Formulário de Aluno');
	
	$form = ActiveForm::begin([
		'id' => 'frmAluno',
		'action' => Url::to(['aluno/editar'], true),
		'method' => 'POST',
		'options' => ['class' => 'form-horizontal'],
	]);
	
	echo Html::activeHiddenInput($aluno, 'IdAluno', []);
	echo $form->field($aluno, 'Nome');
	echo $form->field($aluno, 'DataNascimento')->TextInput(['type'=>'date', 'max' => '2199-12-31']);
	
	echo $form->field($aluno, 'IndicadorDorPeitoAtividadesFisicas')->checkbox();
	echo $form->field($aluno, 'IndicadorDorPeitoUltimoMes')->checkbox();
	echo $form->field($aluno, 'IndicadorPerdaConscienciaTontura')->checkbox();
	echo $form->field($aluno, 'IndicadorProblemaArticular')->checkbox();
	echo $form->field($aluno, 'IndicadorTabagista')->checkbox();
	echo $form->field($aluno, 'IndicadorDiabetico')->checkbox();
	echo $form->field($aluno, 'IndicadorFamiliarAtaqueCardiaco')->checkbox();
	
	echo $form->field($aluno, 'Lesoes')->TextArea();
	echo $form->field($aluno, 'Observacoes')->TextArea();
	echo $form->field($aluno, 'TreinoEspecifico')->TextArea();

	echo Html::submitButton('Salvar', ['class' => 'btn btn-primary']);
	echo Html::button('Voltar', ['onclick'=>'window.location.href = "' . Url::to(['aluno/listar'], true) . '"', 'class'=>'btn btn-secondary']);
	
	ActiveForm::end();
?>