<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Esqueceu sua senha?';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);
echo Html::tag('p', 'Digite seu e-mail e enviaremos instruções para redefinir sua senha');

$form = ActiveForm::begin([
    'id' => 'frmEsqueceuSenha',
    'action' => Url::to(['professor/esqueceu-sua-senha'], true),
    'method' => 'POST',
    'options' => [],
]);

echo $form->field($professor, 'Email')->textInput(['type'=>'email']);

echo Html::submitButton('Alterar Senha', ['class' => 'botoesSalvarVoltar btn btn-primary']);

ActiveForm::end();
?>