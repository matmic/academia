<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;
use yii\widgets\DetailView;

$this->title = 'Treino';
$this->params['breadcrumbs'][] = ['label' => 'Listar', 'url' => ['listar']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);
echo Html::button('Marcar Frequência', ['onclick' => 'marcarFrequencia()', 'style' => 'margin-bottom: 10px', 'class' => 'botoesSalvarVoltar btn btn-primary']);
echo Html::a('Voltar', ['treino/listar'], ['style' => 'margin-bottom: 10px', 'class' => 'botoesSalvarVoltar btn btn-secondary']);
?>
<!-- Fieldset de dados do aluno -->
<fieldset>
    <legend style="cursor: pointer;" data-toggle="collapse" data-target="#divDadosAlunos">Dados do Aluno</legend>
    <div id="divDadosAlunos" class="collapse table-responsive">
        <?php
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
        ?>
    </div>
</fieldset>
<!-- Fim do Fieldset de dados do aluno -->

<!-- Fieldset de Exercícios -->
<fieldset>
    <legend style="cursor: pointer;" data-toggle="collapse" data-target="#divGridsView">Exercícios</legend>
    <div class="collapse" id='divGridsView'>
        <?php
        foreach ($arrProviders as $provider) : ?>
            <fieldset>
                <legend style="cursor: pointer;" data-toggle="collapse"
                        data-target="#div<?= $provider['provider']->id; ?>" id="lgd<?= $provider['provider']->id; ?>">
                    <?= $provider['titulo']; ?>
                </legend>
                <div class="show table-responsive" id="div<?= $provider['provider']->id; ?>">
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
</fieldset>
<!-- Fim do Fieldset de exercícios -->

<!-- Fieldset de frequência -->
<fieldset>
    <legend style="cursor: pointer;" data-toggle="collapse" data-target="#divFrequencia">Frequência</legend>
    <div id="divFrequencia" class="collapse table-responsive">
        <?php
        Pjax::begin(['id' => 'gridFrequencia']);

        echo GridView::widget([
            'dataProvider' => $dataProviderFrequencia,
            'columns' => [
                'DataFrequencia'
            ],
        ]);

        Pjax::end();
        ?>
    </div>
</fieldset>
<!-- Fim do Fieldset de frequência -->

<script>
    function marcarFrequencia() {
        $.ajax({
            type: 'POST',
            url: <?= json_encode(Url::to(['treino/marcar-frequencia'], true)); ?>,
            data: {
                IdTreino: <?= json_encode($treino->IdTreino); ?>,
                _csrf: '<?= Yii::$app->request->getCsrfToken()?>'
            },
            success: function (retorno) {
                var obj = JSON.parse(retorno);
                alert(obj.msg);

                if (obj.erro == '0') {
                    $.pjax.reload({container: '#gridFrequencia'});
                }
            },
        });
    }
</script>