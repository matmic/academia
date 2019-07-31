<?php

namespace app\components;

use PHPMailer\PHPMailer\PHPMailer;

class Utils
{
    /**
     * Gera um token randômico para alteração da senha
     * @return string
     * @throws \Exception
     */
    public static function getToken() {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i = 0; $i < 256; $i++) {
            $token .= $codeAlphabet[random_int(0, $max-1)];
        }

        return $token;
    }

    /**
     * Esconde parte do email do usuário ao enviar email para alteração de senha
     * @param $email
     * @return string
     */
    public static function esconderEmail($email) {
        // Formata o nome do email (a parte antes do @)
        $email = explode('@',  $email);
        $name = $email[0];
        $lengthName = floor(strlen($name) / 2);

        $str = substr($name, 0, $lengthName) . str_repeat('*', strlen($name) - $lengthName) . '@';

        // Formata o domínio (a parte depois do @ e antes do .)
        $resto = $email[1];
        $resto = explode('.', $resto);
        $domain = $resto[0];
        $lengthDomain = floor(strlen($domain) / 2);

        return $str . substr($domain, 0, $lengthDomain) . str_repeat('*', strlen($domain) - $lengthDomain) . '.' . $resto[1];
    }

    /**
     * Monta o body do email para nova conta
     * @param $nome
     * @param $email
     * @param $senha
     * @param $link
     * @return string
     */
    public static function montarEmailNovaConta($nome, $email, $senha, $link)
    {
        $body = "Olá $nome, <br /><br />";
        $body .= "Sua conta foi criada com sucesso! Use as seguintes credenciais para fazer login:<br /><br />";
        $body .= "<b>Login:</b> " . $email . "<br /><b>Senha:</b> " . $senha;
        $body .= "<br /><br />Faça login <a href='$link'>aqui!</a>";
        $body .= "<br /><br />Atenciosamente,<br /><a href='https://www.fitnesshall.com.br/'>Fitness Hall Academia</a>";

        return $body;
    }

    /**
     * Monta o body do email para alteração da senha
     * @param $nome
     * @param $link
     * @return string
     */
    public static function montarEmailAlteraoSenha($nome, $link) {
        $body =  "Olá $nome, <br /><br />";
        $body .= "Para alterar sua senha acesse o seguinte link: <a href='" . $link . "'>$link</a>";
        $body .= "<br /><br />Atenciosamente,<br /><a href='https://www.fitnesshall.com.br/'>Fitness Hall Academia</a>";

        return $body;
    }

    /**
     * @param $nome
     * @param $emailDestino
     * @param $assunto
     * @param $body
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public static function enviarEmail($nome, $emailDestino, $assunto, $body) {
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->CharSet = 'UTF-8';
        $mail->Host = ""; // Servidor SMTP
        $mail->SMTPSecure = ""; // conexão segura com TLS
        $mail->Port = 587;
        $mail->SMTPAuth = true; // Caso o servidor SMTP precise de autenticação
        $mail->Username = ""; // SMTP username
        $mail->Password = ""; // SMTP password
        $mail->From = ""; // From
        $mail->FromName = "" ; // Nome de quem envia o email
        $mail->AddAddress($emailDestino, $nome); // Email e nome de quem receberá //Responder
        $mail->WordWrap = 50; // Definir quebra de linha
        $mail->IsHTML = true ; // Enviar como HTML
        $mail->Subject = $assunto; // Assunto
        $mail->Body = $body; //Corpo da mensagem caso seja HTML
        $mail->send();
    }
}