<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Alterar Senha';
$this->params['breadcrumbs'][] = $this->title;

echo Html::tag('h1', $this->title);
echo Html::tag('p', 'Preencha os campos a seguir para alterar sua senha. Tamanho permitido: 6 a 12 caracters');

$form = ActiveForm::begin([
    'id' => 'frmAlterarSenha',
    'action' => Url::to(['professor/alterar-senha'], true),
    'method' => 'POST',
    'options' => [],
]);

echo Html::activeHiddenInput($professor, 'Email', ['value' => $email]);
echo Html::hiddenInput('token', $token, []);
echo $form->field($professor, 'Senha')->passwordInput(['minlength' => '6', 'maxlength' => '12']);
echo $form->field($professor, 'Senha')->label('Repita a senha')->passwordInput(['minlength' => '6', 'maxlength' => '12', 'name' => 'Professor[SenhaRepetida]', 'id' => 'professor-senha-repetida']);

echo Html::button('Alterar Senha', ['onclick' => 'validarSenha()', 'class' => 'botoesSalvarVoltar btn btn-primary']);

ActiveForm::end();
?>

<script>
    function validarSenha() {
        var senha = $('#professor-senha').val();
        var senhaRepetida = $('#professor-senha-repetida').val();
        var msg = 'Por favor, corrija o(s) seguinte(s) erro(s):';

        if (senha.length < 6 || senha.length > 12 || senhaRepetida.length < 6 || senhaRepetida.length > 12) {
            msg += '\n- A senha deve conter entre 6 e 12 caracters;'
        }

        if (senha !== senhaRepetida) {
            msg += '\n- As senhas são diferentes;'
        }

        if (msg !== 'Por favor, corrija o(s) seguinte(s) erro(s):') {
            alert(msg);
            return false;
        } else {
            $('#frmAlterarSenha').submit();
        }
    }
</script>
