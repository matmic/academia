<?php
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Grupo;
use yii\widgets\ActiveForm;

$this->title = 'Formulário de Exercício';
$this->params['breadcrumbs'][] = ['label' => 'Exercícios', 'url' => ['listar']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);

$form = ActiveForm::begin([
    'id' => 'frmAparelho',
    'action' => Url::to(['aparelho/editar'], true),
    'method' => 'POST',
    'options' => [],
]);

echo Html::activeHiddenInput($aparelho, 'IdAparelho', []);
echo $form->field($aparelho, 'Nome');
echo $form->field($aparelho, 'IdGrupo')->dropDownList(Grupo::getGrupos(), ['prompt'=>'']);

echo Html::submitButton('Salvar', ['class' => 'botoesSalvarVoltar btn btn-primary']);
echo Html::button('Voltar', ['onClick'=>'window.history.back();', 'class'=>'botoesSalvarVoltar btn btn-secondary']);

ActiveForm::end();
?>