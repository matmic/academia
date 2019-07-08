<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	use app\models\Grupo;
	
	echo Html::tag('h1', 'Formulário de Aparelho');
	
	$form = ActiveForm::begin([
		'id' => 'frmAparelho',
		'action' => Url::to(['aparelho/editar'], true),
		'method' => 'POST',
		'options' => ['class' => 'form-horizontal'],
	]);
	
	echo Html::activeHiddenInput($aparelho, 'IdAparelho', []);
	echo $form->field($aparelho, 'Nome');
	echo $form->field($aparelho, 'IdGrupo')->dropDownList(Grupo::getGrupos(), ['prompt'=>'']);
	
	echo Html::submitButton('Salvar', ['class' => 'btn btn-primary']);
	echo Html::button('Voltar', ['onclick'=>'window.location.href = "' . Url::to(['aparelho/listar'], true) . '"', 'class'=>'btn btn-secondary']);
	
	ActiveForm::end();
?>