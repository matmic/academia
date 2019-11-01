<?php

use yii\helpers\json;
use app\models\Professor;
use yii\data\ActiveDataProvider;	

if (Yii::$app->user->isGuest) : 
    echo "Acesso Negado";
else :
    $professores = Professor::find()->where(['IndicadorAtivo' => '1']);
		
	$provider = new ActiveDataProvider([
		'query' => $professores,
		'pagination' => [
			'pageSize' => 10,
		],
	]);

	echo Json::encode($provider->getModels());
endif;
	echo "\nOlá corno!";

?>