<?php
	use yii\widgets\DetailView;
	use yii\helpers\Html;
	use yii\helpers\Url;
	
	echo Html::tag('h1', 'Aluno');
	echo Html::a('Voltar', ['aluno/listar'], ['style'=>'margin-bottom: 10px', 'class'=>'btn btn-primary']);
	
	echo DetailView::widget([
		'model' => $aluno,
		'attributes' => [
			'IdAluno',
			'Nome',
			[
				'attribute' => 'DataNascimento',
				'format' => ['date', 'php:d/m/Y'],
			],
			[
				'attribute' => 'IndicadorDorPeitoAtividadesFisicas',
				'value' => function ($data) {
					return ($data->IndicadorDorPeitoAtividadesFisicas == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
				},
			],
			[
				'attribute' => 'IndicadorDorPeitoUltimoMes',
				'value' => function ($data) {
					return ($data->IndicadorDorPeitoUltimoMes == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
				},
			],
			[
				'attribute' => 'IndicadorPerdaConscienciaTontura',
				'value' => function ($data) {
					return ($data->IndicadorPerdaConscienciaTontura == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
				},
			],
			[
				'attribute' => 'IndicadorProblemaArticular',
				'value' => function ($data) {
					return ($data->IndicadorProblemaArticular == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
				},
			],
			[
				'attribute' => 'IndicadorTabagista',
				'value' => function ($data) {
					return ($data->IndicadorTabagista == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
				},
			],
			[
				'attribute' => 'IndicadorDiabetico',
				'value' => function ($data) {
					return ($data->IndicadorDiabetico == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
				},
			],
			[
				'attribute' => 'IndicadorFamiliarAtaqueCardiaco',
				'value' => function ($data) {
					return ($data->IndicadorFamiliarAtaqueCardiaco == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
				},
			],
			[
				'attribute' => 'IndicadorFamiliarAtaqueCardiaco',
				'value' => function ($data) {
					return ($data->IndicadorFamiliarAtaqueCardiaco == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
				},
			],
			[
				'attribute' => 'IndicadorFamiliarAtaqueCardiaco',
				'value' => function ($data) {
					return ($data->IndicadorFamiliarAtaqueCardiaco == '1' ? 'Sim' : 'Não'); // $data['name'] for array data, e.g. using SqlDataProvider.
				},
			],
			'Lesoes',
			'Observacoes',
			'TreinoEspecifico',
			[
				'attribute' => 'DataInclusao',
				'format' => ['date', 'php:d/m/Y'],
			],
			'IndicadorAtivo',
		],
	]);
?>