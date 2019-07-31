<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);
echo Html::tag('p', 'Preencha os campos a seguir para fazer  o login:');

$form = ActiveForm::begin([
    'id' => 'frmLogin',
    'action' => Url::to(['professor/login'], true),
    'method' => 'POST',
    'options' => [],
]);

echo $form->field($professor, 'Email')->textInput(['type'=>'email']);
echo $form->field($professor, 'Senha')->passwordInput();

echo Html::submitButton('Fazer Login', ['class' => 'botoesSalvarVoltar btn btn-primary']);
echo Html::a('Esqueceu sua senha?', Url::to(['professor/esqueceu-sua-senha']), ['class' => 'botoesSalvarVoltar btn btn-secondary']);

ActiveForm::end();
?>