<?php


namespace app\controllers;


use yii\rest\ActiveController;

use yii\filters\auth\HttpBasicAuth;

use yii\helpers\VarDumper;

use app\models\Api;

use Yii;



class ApiController extends ActiveController

{

    public $modelClass = 'app\models\Professor'; // Example Model Table user_rest_api or define yourself


	public function behaviors()

	{

		$behaviors = parent::behaviors();

		$behaviors['authenticator'] = [

			'class' => HttpBasicAuth::className(),

			'auth' => function ($username, $password) {

				$user = Api::findByUsername($username);

				$result = Yii::$app->getSecurity()->validatePassword($password, $user->Senha);

				if ($user && $result) {
					return $user;

				}

			}

		];

		return $behaviors;

	}


}