<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Aluno;

class AlunoController extends Controller
{
    public function actionListar()
    {
		$alunos = Aluno::find()->where(['IndicadorAtivo' => '1']);
		
		$provider = new ActiveDataProvider([
			'query' => $alunos,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		
		return $this->render('listar', ['dataProvider' => $provider]);
    }
	
	public function actionVisualizar($IdAluno) {
		$aluno = Aluno::findOne($IdAluno);
		
		if (!empty($aluno)) {
			return $this->render('visualizar', ['aluno' => $aluno]);
		} else {
			Yii::$app->session->setFlash('error', 'Aluno inválido!');
			return $this->redirect('listar');
		}
	}
	
	public function actionEditar() {
		if (isset($_GET['IdAluno'])) {
			$IdAluno = $_GET['IdAluno'];
			$aluno = Aluno::findOne($IdAluno);

			if (!empty($aluno)) {
				return $this->render('editar', ['aluno' => $aluno]);
			} else {
				Yii::$app->session->setFlash('error', 'Aluno inválido!');
				return $this->redirect('listar');
			}
		} elseif (isset($_POST['Aluno'])) {
			if (!empty($_POST['Aluno']['IdAluno'])) {
				$IdAluno = $_POST['Aluno']['IdAluno'];
				$aluno = Aluno::findOne($IdAluno);
				
				if (!empty($aluno)) {
					$aluno->attributes = $_POST['Aluno'];
					$arrSalvar = [
						'Nome', 
						'DataNascimento', 
						'IndicadorDorPeitoAtividadesFisicas', 
						'IndicadorDorPeitoUltimoMes', 
						'IndicadorPerdaConscienciaTontura',
						'IndicadorProblemaArticular',
						'IndicadorTabagista',
						'IndicadorDiabetico',
						'IndicadorFamiliarAtaqueCardiaco',
						'Lesoes',
						'Observacoes',
						'TreinoEspecifico',
					];
					
					if ($aluno->update(true, $arrSalvar) !== false) {
						Yii::$app->session->setFlash('success', 'Aluno salvo com sucesso!');
						return $this->redirect('listar');
					} else {
						Yii::$app->session->setFlash('error', 'Não foi possível salvar o aluno!');
						return $this->redirect('listar');
					}
				} else {
					Yii::$app->session->setFlash('error', 'Aluno inválido!');
					return $this->redirect('listar');
				}
			} else {
				$aluno = new Aluno();
				$aluno->attributes =  $_POST['Aluno'];
				
				if ($aluno->save()) {
					Yii::$app->session->setFlash('success', 'Aluno salvo com sucesso!');
					return $this->redirect('listar');
				} else {
					Yii::$app->session->setFlash('error', 'Não foi possível salvar o aluno!');
					return $this->redirect('listar');
				}
			}
		} else {
			$aluno = new Aluno();
			return $this->render('editar', ['aluno' => $aluno]);
		}
	}
}
