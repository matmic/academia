<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Professor;
use app\models\Aluno;
use app\models\Treino;

class TreinoController extends Controller
{
    public function actionListar()
    {
		$treinos = Treino::find()->where(['IndicadorAtivo' => '1']);
		
		$provider = new ActiveDataProvider([
			'query' => $treinos,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		
		return $this->render('listar', ['dataProvider' => $provider]);
    }
	
	public function actionVisualizar($IdTreino) {
		$treino = Treino::findOne($IdTreino);
		
		if (!empty($treino)) {
			return $this->render('visualizar', ['treino' => $treino]);
		} else {
			Yii::$app->session->setFlash('error', 'Treino inválido!');
			return $this->redirect('listar');
		}
	}
	
	public function actionEditar() {
		if (isset($_GET['IdTreino'])) {
			$IdTreino = $_GET['IdTreino'];
			$treino = Treino::findOne($IdTreino);

			if (!empty($treino)) {
				return $this->render('editar', ['treino' => $treino]);
			} else {
				Yii::$app->session->setFlash('error', 'Treino inválido!');
				return $this->redirect('listar');
			}
		} elseif (isset($_POST['Treino'])) {
			if (!empty($_POST['Treino']['IdTreino'])) {
				$IdTreino = $_POST['Treino']['IdTreino'];
				$treino = Treino::findOne($IdTreino);
				
				if (!empty($treino)) {
					$treino->attributes = $_POST['Treino'];
					
					if ($treino->save()) {
						Yii::$app->session->setFlash('success', 'Treino salvo com sucesso!');
						return $this->redirect('listar');
					} else {
						Yii::$app->session->setFlash('error', 'Não foi possível salvar o treino!');
						return $this->redirect('listar');
					}
				} else {
					Yii::$app->session->setFlash('error', 'Treino inválido!');
					return $this->redirect('listar');
				}
			} else {
				$treino = new Treino();
				$treino->attributes =  $_POST['Treino'];
				
				if ($treino->save()) {
					Yii::$app->session->setFlash('success', 'Treino salvo com sucesso!');
					return $this->redirect('listar');
				} else {
					VarDumper::dump($treino->getErrors(), 10, true);die;
					Yii::$app->session->setFlash('error', 'Não foi possível salvar o treino!');
					return $this->redirect('listar');
				}
			}
		} else {
			$treino = new Treino();
			$professores = Professor::find()->select(['IdProfessor', 'Nome'])->asArray()->all();
			
			return $this->render('editar', ['treino' => $treino, 'professores' => $professores]);
		}
	}
}
