<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	use yii\widgets\MaskedInput;
	use app\models\UnidadeFederacao;
	use yii\jui\DatePicker;
	
	echo Html::tag('h1', 'Formulário de Pessoa');
	
	$form = ActiveForm::begin([
		'id' => 'frmPessoa',
		'action' => Url::to(['pessoa/editar'], true),
		'method' => 'POST',
		'options' => ['class' => 'form-horizontal'],
	]);
	
	echo Html::activeHiddenInput($pessoa, 'IdPessoa');
	echo $form->field($pessoa, 'Nome');
	echo $form->field($pessoa, 'CPF')->textInput(['type'=>'number'])->widget(MaskedInput::className(), ['mask' => '999.999.999-99', 'clientOptions' => ['removeMaskOnSubmit' => true]]);
	//echo $form->field($pessoa, 'DataNascimento')->widget(DatePicker::className(), ['language' => 'pt-BR', 'dateFormat' => 'dd/mm/YYYY']);
	echo $form->field($pessoa, 'DataNascimento')->textInput(['type' => 'date', 'max' => '2999-12-31']);
	echo $form->field($pessoa, 'Email')->textInput(['type' => 'email']);
	
	echo Html::activeHiddenInput($endereco, 'IdEndereco');
	echo $form->field($endereco, 'Logradouro');
	echo $form->field($endereco, 'Numero');
	echo $form->field($endereco, 'Complemento');
	echo $form->field($endereco, 'Bairro');
	echo $form->field($endereco, 'Cidade');
	echo $form->field($endereco, 'IdUnidadeFederacao')->dropDownList(UnidadeFederacao::getUnidadesFederacao(), ['prompt'=>'']);
	
	echo $form->field($pessoa, 'IdAluno')->checkBox();
	echo '<div id="divAluno">';
	echo $form->field($aluno, 'Objetivos')->textArea();
	echo $form->field($aluno, 'Lesoes')->textArea();
	echo $form->field($aluno, 'Observacoes')->textArea();
	echo $form->field($aluno, 'TreinoEspecifico')->textArea();
	
	echo $form->field($aluno, 'IndicadorDorPeitoAtividadesFisicas')->checkBox();
	echo $form->field($aluno, 'IndicadorDorPeitoUltimoMes')->checkBox();
	echo $form->field($aluno, 'IndicadorPerdaConscienciaTontura')->checkBox();
	echo $form->field($aluno, 'IndicadorProblemaArticular')->checkBox();
	echo $form->field($aluno, 'IndicadorTabagista')->checkBox();
	echo $form->field($aluno, 'IndicadorDiabetico')->checkBox();
	echo $form->field($aluno, 'IndicadorFamiliarAtaqueCardiaco')->checkBox();
	echo '</div>';
	
	echo Html::submitButton('Salvar', ['class' => 'btn btn-primary']);
	echo Html::button('Voltar', ['onclick'=>'window.location.href = "' . Url::to(['pessoa/listar'], true) . '"', 'class'=>'btn btn-secondary']);
	
	ActiveForm::end();
?>
<script>
	$('#pessoa-idaluno').click(function() {
		if ($(this).is(':checked')) {
			$('#divAluno').show();
		} else {
			$('#divAluno').hide();
		}
	});
</script>