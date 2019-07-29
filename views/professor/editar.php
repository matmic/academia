<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Formulário de Professor';
$this->params['breadcrumbs'][] = ['label' => 'Professores', 'url' => ['listar']];
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);

$form = ActiveForm::begin([
    'id' => 'frmProfessor',
    'action' => Url::to(['professor/editar'], true),
    'method' => 'POST',
    'options' => [],
]);

echo Html::activeHiddenInput($professor, 'IdProfessor', []);
echo $form->field($professor, 'Nome');
echo $form->field($professor, 'Email')->TextInput(['type'=>'email']);

echo Html::submitButton('Salvar', ['class' => 'botoesSalvarVoltar btn btn-primary']);
echo Html::button('Voltar', ['onClick'=>'window.history.back();', 'class'=>'botoesSalvarVoltar btn btn-secondary']);

ActiveForm::end();
?>