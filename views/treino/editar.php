<?php
	use yii\helpers\Url;
	use yii\helpers\Html;
	use app\models\Aluno;
	use yii\grid\GridView;
	use app\models\Professor;
	use yii\widgets\ActiveForm;
	use yii\grid\CheckboxColumn;
	
	$this->title = 'Formulário de Treino';
	$this->params['breadcrumbs'][] = ['label' => 'Treinos', 'url' => ['listar']];
	$this->params['breadcrumbs'][] = $this->title;
	
	echo Html::tag('h1', $this->title);
	
	$form = ActiveForm::begin([
		'id' => 'frmTreino',
		'action' => Url::to(['treino/editar'], true),
		'method' => 'POST',
		'options' => [],
	]);
	
	echo Html::activeHiddenInput($treino, 'IdTreino', []);
	echo $form->field($treino, 'IdProfessor')->label('Professor')->dropDownList(Professor::getProfessores(), ['prompt' => '']);
	echo $form->field($treino, 'IdAluno')->label('Aluno')->dropDownList(Aluno::getAlunos(), ['prompt' => '']);
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
	echo Html::submitButton('Salvar', ['class' => 'botoesSalvarVoltar btn btn-primary']);
	echo Html::button('Voltar', ['onClick'=>'window.history.back();', 'class'=>'botoesSalvarVoltar btn btn-secondary']);
	
	ActiveForm::end();
?>

<script>
	$(document).ready(function() {
		$('#treino-idprofessor').select2({
			'placeholder': 'Selecione uma opção...',
            width: '100%',
			'language': {
			   'noResults': function(){
				   return 'Sem resultados';
			   }
		   },
		});
		
		$('#treino-idaluno').select2({
			'placeholder': 'Selecione uma opção...',
            width: '100%',
			'language': {
			   'noResults': function(){
				   return 'Sem resultados';
			   }
		   },
		});
	});
	
	// $("#frmTreino").submit(function(event) {
        // var nroCheckboxChecados = $('#divGridsView').find('input[type=checkbox]:checked').length;
		
		// console.log(nroCheckboxChecados);
		
         // if (nroCheckboxChecados >= 1) {
            // return true;
        // } else {
            // alert('Você deve marcar ao menos 1 exercício!');
            // return false;
        // }
    // });
</script>