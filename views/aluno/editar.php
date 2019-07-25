<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	
	$this->title = 'Formulário de Aluno';
	$this->params['breadcrumbs'][] = ['label' => 'Listar', 'url' => ['listar']];
	$this->params['breadcrumbs'][] = $this->title;
	
	echo Html::tag('h1', $this->title);
	
	$form = ActiveForm::begin([
		'id' => 'frmAluno',
		'action' => Url::to(['aluno/editar'], true),
		'method' => 'POST',
		'options' => [],
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

	echo Html::submitButton('Salvar', ['class' => 'botoesSalvarVoltar btn btn-primary']);
	echo Html::button('Voltar', ['onClick'=>'window.history.back();', 'class'=>'botoesSalvarVoltar btn btn-secondary']);
	
	ActiveForm::end();
?>