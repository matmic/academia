<?php
	use yii\widgets\DetailView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\grid\GridView;
	
	echo Html::tag('h1', 'Treino');
	echo Html::a('Voltar', ['treino/listar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo '<div class="table-responsive">';
	echo DetailView::widget([
		'model' => $treino,
		'attributes' => [
			'IdTreino',
			[
				'attribute' => 'professor.Nome',
				'label' => 'Professor',
			],
			[
				'attribute' => 'aluno.Nome',
				'label' => 'Aluno',
			],
			'Nome',
			'Objetivos',
			'DataInclusao',
			'IndicadorAtivo',
		],
	]);
	echo '</div>';
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
							'attribute' => 'aparelho.Nome',
							'label' => 'Exercício',
						],
						[
							'value' => 'Series',
							'label' => 'Séries',
						],
						[
							'value' => 'Repeticoes',
							'format' => 'raw',
							'label' => 'Repetições',
						],
						[
							'value' => 'Peso',
							'format' => 'raw',
							'label' => 'Peso',
						],
					],
				]);
			?>
			</div>
		</fieldset>
	<?php endforeach; ?>
</div>