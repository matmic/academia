<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\UnidadeFederacao;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;

class UnidadeFederacaoController extends Controller
{
    public function actionListar()
    {
		$unidadesFederacao = UnidadeFederacao::find();
		
		$provider = new ActiveDataProvider([
			'query' => $unidadesFederacao,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		
		return $this->render('listar', ['dataProvider' => $provider]);
    }
	
	public function actionVisualizar($IdUnidadeFederacao) {
		$unidadeFederacao = UnidadeFederacao::findOne($IdUnidadeFederacao);
		
		if (!empty($unidadeFederacao)) {
			return $this->render('visualizar', ['unidadeFederacao' => $unidadeFederacao]);
		} else {
			Yii::$app->session->setFlash('error', 'Unidade da Federação inválida!');
			return $this->redirect('listar');
		}
	}
	
	public function actionEditar() {
		if (isset($_GET['IdUnidadeFederacao'])) {
			$IdUnidadeFederacao = $_GET['IdUnidadeFederacao'];
			$unidadeFederacao = UnidadeFederacao::findOne($IdUnidadeFederacao);

			if (!empty($unidadeFederacao)) {
				return $this->render('editar', ['unidadeFederacao' => $unidadeFederacao]);
			} else {
				Yii::$app->session->setFlash('error', 'Unidade da Federação inválida!');
				return $this->redirect('listar');
			}
		} elseif (isset($_POST['UnidadeFederacao'])) {
			if (!empty($_POST['UnidadeFederacao']['IdUnidadeFederacao'])) {
				$IdUnidadeFederacao = $_POST['UnidadeFederacao']['IdUnidadeFederacao'];
				$unidadeFederacao = UnidadeFederacao::findOne($IdUnidadeFederacao);
				
				if (!empty($unidadeFederacao)) {
					$unidadeFederacao->attributes = $_POST['UnidadeFederacao'];
					
					if ($unidadeFederacao->save()) {
						Yii::$app->session->setFlash('success', 'Unidade da Federação salva com sucesso!');
						return $this->redirect('listar');
					} else {
						Yii::$app->session->setFlash('error', 'Não foi possível salvar a Unidade da Federação!');
						return $this->redirect('listar');
					}
				} else {
					Yii::$app->session->setFlash('error', 'Unidade da Federação inválida!');
					return $this->redirect('listar');
				}
			} else {
				$unidadeFederacao = new UnidadeFederacao();
				$unidadeFederacao->attributes =  $_POST['UnidadeFederacao'];
				
				if ($unidadeFederacao->save()) {
					Yii::$app->session->setFlash('success', 'Unidade da Federação salva com sucesso!');
					return $this->redirect('listar');
				} else {
					VarDumper::dump($unidadeFederacao->getErrors(), 10, true); die;
					Yii::$app->session->setFlash('error', 'Não foi possível salvar a Unidade da Federação!');
					return $this->redirect('listar');
				}
			}
		} else {
			$unidadeFederacao = new UnidadeFederacao();
			return $this->render('editar', ['unidadeFederacao' => $unidadeFederacao]);
		}
	}
}
