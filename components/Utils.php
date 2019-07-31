<?php

namespace app\components;

class Utils
{
    /**
     * Gera um token randфmico para alteraзгo da senha
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
     * Esconde parte do email do usuбrio ao enviar email para alteraзгo de senha
     * @param $email
     * @return string
     */
    public static function hideEmail($email) {
        // Formata o nome do email (a parte antes do @)
        $email = explode('@',  $email);
        $name = $email[0];
        $lengthName = floor(strlen($name) / 2);

        $str = substr($name, 0, $lengthName) . str_repeat('*', strlen($name) - $lengthName) . '@';

        // Formata o domнnio (a parte depois do @ e antes do .)
        $resto = $email[1];
        $resto = explode('.', $resto);
        $domain = $resto[0];
        $lengthDomain = floor(strlen($domain) / 2);

        return $str . substr($domain, 0, $lengthDomain) . str_repeat('*', strlen($domain) - $lengthDomain) . '.' . $resto[1];
    }
}