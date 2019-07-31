<?php

namespace app\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class BaseController extends Controller
{
	public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
					[
						'allow' => true,
                        'actions' => ['login', 'index', 'esqueceu-sua-senha', 'alterar-senha'],
                        'roles' => ['?'],
					],
                ],
				'denyCallback' => function($rule, $action) {
					return $this->redirect(['professor/login']);
				},
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
}