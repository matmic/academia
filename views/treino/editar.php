<?php
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\widgets\ActiveForm;
	use yii\jui\AutoComplete;
	use yii\web\JsExpression;
	use yii\grid\GridView;
	use yii\grid\CheckboxColumn;
	use app\models\Professor;
	use app\models\Aluno;
	
	echo Html::tag('h1', 'Formulário de Treino');
	
	$form = ActiveForm::begin([
		'id' => 'frmTreino',
		'action' => Url::to(['treino/editar'], true),
		'method' => 'POST',
		'options' => ['class' => 'form-horizontal'],
	]);
	
	echo $form->field($treino, 'IdProfessor')->label('Professor')->dropDownList(Professor::getProfessores(), ['prompt' => '']);
	echo $form->field($treino, 'IdAluno')->label('Aluno')->dropDownList(Aluno::getAlunos(), ['prompt' => '']);
	
	// echo $form->field($treino, 'NomeProfessor')->label('Professor')->widget(AutoComplete::classname(), [
		// 'options' => ['class' => 'form-control'],
		// 'clientOptions' => [
            // 'source' => Url::to(['auxiliar/auto-complete-professor'], true),
            // 'minLength' => '3', 
			// 'autoFill' => true,
			// 'select'=> new JsExpression("function(event, ui) {
				// $('#iptIdProfessor').val(ui.item['IdProfessor']);
			// }"),
        // ],
	// ]);
	// echo Html::activeHiddenInput($treino, 'IdProfessor', ['id'=>'iptIdProfessor']);
	
	// echo $form->field($treino, 'NomeAluno')->label('Aluno')->widget(AutoComplete::classname(), [
		// 'options' => ['class' => 'form-control'],
		// 'clientOptions' => [
            // 'source' => Url::to(['auxiliar/auto-complete-aluno'], true),
            // 'minLength' => '3', 
			// 'autoFill' => true,
			// 'select'=> new JsExpression("function(event, ui) {
				// $('#iptIdAluno').val(ui.item['IdAluno']);
			// }"),
        // ],
	// ]);
	// echo Html::activeHiddenInput($treino, 'IdAluno', ['id'=>'iptIdAluno']);
	
	echo Html::activeHiddenInput($treino, 'IdTreino', []);
	echo $form->field($treino, 'Nome');
	echo $form->field($treino, 'Objetivos');
	
?>
<div id='divGridsView'>
<?php
	foreach ($arrProviders as $provider) : ?>
		<fieldset>
			<legend style="cursor: pointer;" data-toggle="collapse" data-target="#div<?= $provider['provider']->id; ?>"  id="lgd<?= $provider['provider']->id; ?>">
				<?= $provider['titulo']; ?>
			</legend>
			<div class="collapse table-responsive" id="div<?= $provider['provider']->id;?>">
			<?php
				echo GridView::widget([
					'dataProvider' => $provider['provider'],
					'columns' => [
						[
							'attribute' => 'NomeAparelho',
							'label' => 'Exercício',
						],
						[
							'footer'=>'Selecione os exercícios',
							'class' => CheckboxColumn::className(),
							'checkboxOptions' => function($model) {
								$arr = [
									'value' => $model["IdAparelho"],
									'id'=> "selection$model[IdAparelho]",
									'checked' => isset($model["Series"]) ? true : false,
								];
								
								return $arr;
							},
						],
						[
							'value' => function($model) {
								return Html::input('number', "Series[$model[IdAparelho]]", isset($model["Series"]) ? $model["Series"] : '0', ['min' => '0', 'onclick' => "$('#selection$model[IdAparelho]').prop('checked', true);"]);
							},
							'format' => 'raw',
							'label' => 'Séries',
						],
						[
							'value' => function($model) {
								return Html::input('number', "Repeticoes[$model[IdAparelho]]", isset($model["Repeticoes"]) ? $model["Repeticoes"] : '0', ['min' => '0', 'onclick' => "$('#selection$model[IdAparelho]').prop('checked', true);"]);
							},
							'format' => 'raw',
							'label' => 'Repetições',
						],
						[
							'value' => function($model) {
								return Html::input('number', "Peso[$model[IdAparelho]]", isset($model["Peso"]) ? $model["Peso"] : '0', ['min' => '0', 'onclick' => "$('#selection$model[IdAparelho]').prop('checked', true);"]);
							},
							'format' => 'raw',
							'label' => 'Peso',
						],
					],
				]);
			?>
			</div>
		</fieldset>
<?php
	endforeach;
?>
</div>
<?php
	echo Html::submitButton('Salvar', ['class' => 'btn btn-primary']);
	echo Html::button('Voltar', ['onclick'=>'window.location.href = "' . Url::to(['treino/listar'], true) . '"', 'class'=>'btn btn-secondary']);
	
	ActiveForm::end();
?>

<script>
	$(document).ready(function() {
		$('#treino-idprofessor').select2({
			'placeholder': 'Selecione uma opção...',
			'language': {
			   'noResults': function(){
				   return 'Sem resultados';
			   }
		   },
		});
		
		$('#treino-idaluno').select2({
			'placeholder': 'Selecione uma opção...',
			'language': {
			   'noResults': function(){
				   return 'Sem resultados';
			   }
		   },
		});
	});
	
	$("#frmTreino").submit(function(event) {
        var nroCheckboxChecados = $('#divGridsView').find('input[type=checkbox]:checked').length;
		
		console.log(nroCheckboxChecados);
		
         if (nroCheckboxChecados >= 1) {
            return true;
        } else {
            alert('Você deve marcar ao menos 1 exercício!');
            return false;
        }
    });
	
</script>