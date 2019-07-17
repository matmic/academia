<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	use yii\jui\AutoComplete;
	use yii\web\JsExpression;
	use yii\grid\GridView;
	use yii\grid\CheckboxColumn;
	
	echo Html::tag('h1', 'Formulário de Treino');
	
	$form = ActiveForm::begin([
		'id' => 'frmTreino',
		'action' => Url::to(['treino/editar'], true),
		'method' => 'POST',
		'options' => ['class' => 'form-horizontal'],
	]);
	
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
	
	
	echo GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			[
				'attribute' => 'grupo',
				'label' => 'Grupo',
				'value' => 'grupo.Nome',
			],
			'Nome',
			[
				'class' => CheckboxColumn::className(),
				'checkboxOptions' => function($model) {
					$arr = [
						'value' => $model->IdAparelho,
						'id'=> "selection$model->IdAparelho",
						'checked' => false,
					];
					
					return $arr;
				},
			],
			[
				'value' => function($model) {
					return Html::input('number', "Series[$model->IdAparelho]", 0, ['min' => '0', 'onclick' => "$('#selection$model->IdAparelho').prop('checked', true);"]);
				},
				'format' => 'raw',
				'label' => 'Séries',
			],
			[
				'value' => function($model) {
					return Html::input('number', "Repeticoes[$model->IdAparelho]", 0, ['min' => '0']);
				},
				'format' => 'raw',
				'label' => 'Repetições',
			],
			[
				'value' => function($model) {
					return Html::input('number', "Peso[$model->IdAparelho]", 0, ['min' => '0']);
				},
				'format' => 'raw',
				'label' => 'Peso',
			],
			[
				'header' => 'Operações',
				'class' => 'yii\grid\ActionColumn',
				'template' => '{view} {update}',
				'buttons' => [
					'view' => function($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',  Url::to(['treino/visualizar', 'IdTreino' => $key], true));
					},
					'update' => function($url, $model, $key) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>',  Url::to(['treino/editar', 'IdTreino' => $key], true));
					},
				],
			],
		],
	]);
	
	
	echo Html::submitButton('Salvar', ['class' => 'btn btn-primary']);
	echo Html::button('Voltar', ['onclick'=>'window.location.href = "' . Url::to(['treino/listar'], true) . '"', 'class'=>'btn btn-secondary']);
	
	ActiveForm::end();
?>