<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	use yii\jui\AutoComplete;
	use yii\web\JsExpression;
	
	echo Html::tag('h1', 'Formulário de Treino');
	
	$form = ActiveForm::begin([
		'id' => 'frmTreino',
		'action' => Url::to(['treino/editar'], true),
		'method' => 'POST',
		'options' => ['class' => 'form-horizontal'],
	]);
	
	//$data = Professor::find()->select(['Nome'])->orderBy('Nome')->asArray()->all();
	//VarDumper::dump($data, 10, true);die;
	
	echo $form->field($treino, 'NomeProfessor')->label('Professor')->widget(AutoComplete::classname(), [
		'options' => ['class' => 'form-control'],
		'clientOptions' => [
            'source' => Url::to(['auxiliar/auto-complete-professor'], true),
            'minLength' => '3', 
			'autoFill' => true,
			'select'=> new JsExpression("function(event, ui) {
				$('#iptIdProfessor').val(ui.item['IdProfessor']);
			}"),
        ],
	]);
	echo Html::activeHiddenInput($treino, 'IdProfessor', ['id'=>'iptIdProfessor']);
	
	echo $form->field($treino, 'NomeAluno')->label('Aluno')->widget(AutoComplete::classname(), [
		'options' => ['class' => 'form-control'],
		'clientOptions' => [
            'source' => Url::to(['auxiliar/auto-complete-aluno'], true),
            'minLength' => '3', 
			'autoFill' => true,
			'select'=> new JsExpression("function(event, ui) {
				$('#iptIdAluno').val(ui.item['IdAluno']);
			}"),
        ],
	]);
	echo Html::activeHiddenInput($treino, 'IdAluno', ['id'=>'iptIdAluno']);
	
	echo Html::activeHiddenInput($treino, 'IdTreino', []);
	echo $form->field($treino, 'Nome');
	echo $form->field($treino, 'Objetivos');
	
	// echo $form->field($treino, 'IndicadorDorPeitoAtividadesFisicas')->checkbox();
	// echo $form->field($treino, 'IndicadorDorPeitoUltimoMes')->checkbox();
	// echo $form->field($treino, 'IndicadorPerdaConscienciaTontura')->checkbox();
	// echo $form->field($treino, 'IndicadorProblemaArticular')->checkbox();
	// echo $form->field($treino, 'IndicadorTabagista')->checkbox();
	// echo $form->field($treino, 'IndicadorDiabetico')->checkbox();
	// echo $form->field($treino, 'IndicadorFamiliarAtaqueCardiaco')->checkbox();
	
	// echo $form->field($treino, 'Lesoes')->TextArea();
	// echo $form->field($treino, 'Observacoes')->TextArea();
	// echo $form->field($treino, 'TreinoEspecifico')->TextArea();

	echo Html::submitButton('Salvar', ['class' => 'btn btn-primary']);
	echo Html::button('Voltar', ['onclick'=>'window.location.href = "' . Url::to(['treino/listar'], true) . '"', 'class'=>'btn btn-secondary']);
	
	ActiveForm::end();
?>