<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Pessoa;
use app\models\Endereco;
use yii\data\ActiveDataProvider;

class PessoaController extends Controller
{
    public function actionListar()
    {
		$pessoas = Pessoa::find()->joinWith('endereco');
		
		$provider = new ActiveDataProvider([
			'query' => $pessoas,
			'pagination' => [
				'pageSize' => 10,
			],
			// 'sort' => [
				// 'attributes' => [
					// 'Nome',
					// 'grupo.Nome', 
					// 'IdAparelho'
				// ],
			// ],
		]);
		
		return $this->render('listar', ['dataProvider' => $provider]);
    }
	
	public function actionVisualizar($IdPessoa) {
		$pessoa = Pessoa::find($IdPessoa)->with('endereco')->one();
		
		if (!empty($pessoa)) {
			return $this->render('visualizar', ['pessoa' => $pessoa]);
		} else {
			Yii::$app->session->setFlash('error', 'Pessoa inválida!');
			return $this->redirect('listar');
		}
	}
	
	public function actionEditar() {
		if (isset($_GET['IdPessoa'])) {
			$IdPessoa = $_GET['IdPessoa'];
			$pessoa = Pessoa::findOne($IdPessoa);

			if (!empty($pessoa)) {
				return $this->render('editar', ['pessoa' => $pessoa]);
			} else {
				Yii::$app->session->setFlash('error', 'Pessoa inválida!');
				return $this->redirect('listar');
			}
		} elseif (isset($_POST['Pessoa'])) {
			if (!empty($_POST['Pessoa']['IdPessoa'])) {
				$IdPessoa = $_POST['Pessoa']['IdPessoa'];
				$pessoa = Aparelho::findOne($IdPessoa);
				
				if (!empty($pessoa)) {
					$pessoa->attributes = $_POST['Pessoa'];
					
					if ($pessoa->save()) {
						Yii::$app->session->setFlash('success', 'Pessoa salva com sucesso!');
						return $this->redirect('listar');
					} else {
						Yii::$app->session->setFlash('error', 'Não foi possível salvar a pessoa!');
						return $this->redirect('listar');
					}
				} else {
					Yii::$app->session->setFlash('error', 'Pessoa inválida!');
					return $this->redirect('listar');
				}
			} else {
				$pessoa = new Pessoa();
				$pessoa->attributes =  $_POST['Pessoa'];
				
				if ($pessoa->save()) {
					Yii::$app->session->setFlash('success', 'Pessoa salva com sucesso!');
					return $this->redirect('listar');
				} else {
					Yii::$app->session->setFlash('error', 'Não foi possível salvar a pessoa!');
					return $this->redirect('listar');
				}
			}
		} else {
			$pessoa = new Pessoa();
			return $this->render('editar', ['pessoa' => $pessoa]);
		}
	}
}
