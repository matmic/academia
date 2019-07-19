<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Professor;
use app\models\Treino;

class ProfessorController extends Controller
{
    public function actionListar()
    {
		$professores = Professor::find()->where(['IndicadorAtivo' => '1']);
		
		$provider = new ActiveDataProvider([
			'query' => $professores,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		
		return $this->render('listar', ['dataProvider' => $provider]);
    }
	
	public function actionVisualizar($IdProfessor) {
		$professor = Professor::findOne($IdProfessor);
		
		if (!empty($professor)) {
			return $this->render('visualizar', ['professor' => $professor]);
		} else {
			Yii::$app->session->setFlash('error', 'Professor inválido!');
			return $this->redirect('listar');
		}
	}
	
	public function actionEditar() {
		if (isset($_GET['IdProfessor'])) {
			$IdProfessor = $_GET['IdProfessor'];
			$professor = Professor::findOne($IdProfessor);

			if (!empty($professor)) {
				return $this->render('editar', ['professor' => $professor]);
			} else {
				Yii::$app->session->setFlash('error', 'Professor inválido!');
				return $this->redirect('listar');
			}
		} elseif (isset($_POST['Professor'])) {
			if (!empty($_POST['Professor']['IdProfessor'])) {
				$IdProfessor = $_POST['Professor']['IdProfessor'];
				$professor = Professor::findOne($IdProfessor);
				
				if (!empty($professor)) {
					$professor->attributes = $_POST['Professor'];
					
					if ($professor->save()) {
						Yii::$app->session->setFlash('success', 'Professor salvo com sucesso!');
						return $this->redirect('listar');
					} else {
						Yii::$app->session->setFlash('error', 'Não foi possível salvar o professor!');
						return $this->redirect('listar');
					}
				} else {
					Yii::$app->session->setFlash('error', 'Professor inválido!');
					return $this->redirect('listar');
				}
			} else {
				$professor = new Professor();
				$professor->attributes =  $_POST['Professor'];
				
				$senha = Yii::$app->getSecurity()->generateRandomString(8);
				$professor->Senha = Yii::$app->getSecurity()->generatePasswordHash($senha);
				
				if ($professor->save()) {
					// $msg = "Olá " . $professor->Nome . "!<br />";
					// $msg .= "Sua conta foi criada com sucesso!<br /><br />";
					// $msg .= "<b>Login:</b> " . $professor->Email . "<br /><b>Senha:</b> " . $senha;
					// //$msg .= "<br /><br />Faça login <a href='https://www.ufrgs.br/pmm-pub/portal/site/login'>aqui!</a>";
					// //$msg .= "<br /><br />Atenciosamente,<br />Equipe <a href='http://www.ufrgs.br/laisc/'>LAISC</a>";
					// $to = $professor->Email . ' < ' . $professor->Email . '>';
					// $subject = 'Conta criada!';
					
					// $headers = 'From: naorespondaacademia <naorespondaacademia@naoresponda.com.br> ' . "\r\n" .
							   // 'Content-Type: text/html;charset=utf-8' . "\r\n" .
							   // 'X-Mailer: PHP/' . phpversion();
					// $real_sender = '-f naorespondaacademia@naoresponda.com.br';
					// mail($to, $subject, $msg, $headers, $real_sender);
					
					Yii::$app->session->setFlash('success', 'Professor salvo com sucesso!');
					return $this->redirect('listar');
				} else {
					Yii::$app->session->setFlash('error', 'Não foi possível salvar o professor!');
					return $this->redirect('listar');
				}
			}
		} else {
			$professor = new Professor();
			return $this->render('editar', ['professor' => $professor]);
		}
	}
	
	public function actionLogin()
	{
		if (Yii::$app->user->isGuest) {
			if (isset($_POST['Professor'])) {
				$identity = Professor::findOne(['Email' => $_POST['Professor']['Email'], 'IndicadorAtivo' => '1']);
				
				if (!empty($identity)) {
					if (Yii::$app->getSecurity()->validatePassword($_POST['Professor']['Senha'], $identity->Senha)) {
						Yii::$app->user->login($identity);
						
						Yii::$app->session->setFlash('success', 'Você está logado!');
						return $this->redirect(['site/index']);
					} else {
						Yii::$app->session->setFlash('error', 'Não foi possível logar! Verifique as informações preenchidas!');
						return $this->redirect(['professor/login']);
					}
				} else {
					Yii::$app->session->setFlash('error', 'Não foi possível logar! Verifique as informações preenchidas!');
					return $this->redirect(['professor/login']);
				}
			} else {
				$professor = new Professor();
				return $this->render('login', ['professor' => $professor]);
			}
		} else {
			return $this->redirect(['site/index']);
		}
	}
	
	public function actionMeusAlunos() {
		$treinos = Treino::find()->select(['aluno.IdAluno', 'aluno.Nome'])->distinct()->joinWith(['aluno'])->where(['aluno.IndicadorAtivo' => '1', 'IdProfessor' => Yii::$app->user->id])->orderBy('aluno.Nome');
		$provider = new ActiveDataProvider([
			'query' => $treinos,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		
		return $this->render('meusAlunos', ['dataProvider' => $provider]);
	}
}
