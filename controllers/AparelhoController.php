<?php

namespace app\controllers;

use Yii;
use app\models\Aparelho;
use yii\data\ActiveDataProvider;

class AparelhoController extends BaseController
{
    public function actionListar()
    {
		$aparelhos = Aparelho::find()->joinWith('grupo');
		
		$provider = new ActiveDataProvider([
			'query' => $aparelhos,
			'pagination' => [
				'pageSize' => 10,
			],
			'sort' => [
				'attributes' => [
					'Nome',
					'grupo.Nome', 
					'IdAparelho'
				],
			],
		]);
		
		return $this->render('listar', ['dataProvider' => $provider]);
    }
	
	public function actionVisualizar($IdAparelho) {
		$aparelho = Aparelho::find($IdAparelho)->with('grupo')->one();
		
		if (!empty($aparelho)) {
			return $this->render('visualizar', ['aparelho' => $aparelho]);
		} else {
			Yii::$app->session->setFlash('error', 'Aparelho inválido!');
			return $this->redirect('listar');
		}
	}
	
	public function actionEditar() {
		if (isset($_GET['IdAparelho'])) {
			$IdAparelho = $_GET['IdAparelho'];
			$aparelho = Aparelho::findOne($IdAparelho);

			if (!empty($aparelho)) {
				return $this->render('editar', ['aparelho' => $aparelho]);
			} else {
				Yii::$app->session->setFlash('error', 'Aparelho inválido!');
				return $this->redirect('listar');
			}
		} elseif (isset($_POST['Aparelho'])) {
			if (!empty($_POST['Aparelho']['IdAparelho'])) {
				$IdAparelho = $_POST['Aparelho']['IdAparelho'];
				$aparelho = Aparelho::findOne($IdAparelho);
				
				if (!empty($aparelho)) {
					$aparelho->attributes = $_POST['Aparelho'];
					
					if ($aparelho->save()) {
						Yii::$app->session->setFlash('success', 'Aparelho salvo com sucesso!');
						return $this->redirect('listar');
					} else {
						Yii::$app->session->setFlash('error', 'Não foi possível salvar o aparelho!');
						return $this->redirect('listar');
					}
				} else {
					Yii::$app->session->setFlash('error', 'Aparelho inválido!');
					return $this->redirect('listar');
				}
			} else {
				$aparelho = new Aparelho();
				$aparelho->attributes =  $_POST['Aparelho'];
				
				if ($aparelho->save()) {
					Yii::$app->session->setFlash('success', 'Aparelho salvo com sucesso!');
					return $this->redirect('listar');
				} else {
					Yii::$app->session->setFlash('error', 'Não foi possível salvar o aparelho!');
					return $this->redirect('listar');
				}
			}
		} else {
			$aparelho = new Aparelho();
			return $this->render('editar', ['aparelho' => $aparelho]);
		}
	}
}
