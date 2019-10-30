<?php

namespace app\controllers;

use Yii;
use DateTime;
use DateInterval;
use yii\helpers\Url;
use yii\db\Exception;
use app\models\Treino;
use app\components\Utils;
use app\models\Professor;
use app\models\ResetPassword;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class ProfessorController extends BaseController
{
    private const NRO_MAXIMO_TENTATIVAS_LOGIN = 3;

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
					
					if ($professor->update(true, ['Nome', 'Email', 'DataHoraUltimaAtu']) !== false) {
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
			    try {
                    $professor = new Professor();
                    $professor->attributes = $_POST['Professor'];

                    $senha = Yii::$app->getSecurity()->generateRandomString(8);
                    $professor->Senha = Yii::$app->getSecurity()->generatePasswordHash($senha);

                    if ($professor->save()) {
                        //Utils::enviarEmail($professor->Nome, $professor->Email, 'Sua conta foi criada com sucesso!', Utils::montarEmailNovaConta($professor->Nome, $professor->Email, $senha, Url::to(['professor/login'], true)));
                        Yii::$app->session->setFlash('success', 'Professor salvo com sucesso!');
                        return $this->redirect('listar');
                    } else {
                        throw new Exception('Não foi possível salvar o professor!');
                    }
                } catch (Exception $e) {
                    Yii::$app->session->setFlash('error', $e->getMessage());
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
                $identity = Professor::findOne(['Email' => $_POST['Professor']['Email']]);

                if (!empty($identity)) {
                    if ($identity->getOldAttribute('IndicadorAtivo') == '1') {
                        if (Yii::$app->getSecurity()->validatePassword($_POST['Professor']['Senha'], $identity->Senha)) {
                            $identity->IndicadorAtivo = '1';
                            $identity->TentativasLogin = 0;

                            if ($identity->update(true, ['TentativasLogin', 'IndicadorAtivo', 'DataHoraUltimaAtu']) !== false) {
                                Yii::$app->user->login($identity);
                                Yii::$app->session->setFlash('success', 'Você está logado!');
                                return $this->redirect(['site/index']);
                            } else {
                                Yii::$app->session->setFlash('error', 'Não foi possível logar! Verifique as informações preenchidas!');
                                return $this->redirect(['professor/login']);
                            }
                        } else {
                            $numeroTentativasErradas = $identity->TentativasLogin;
                            $numeroTentativasErradas++;

                            if ($numeroTentativasErradas > self::NRO_MAXIMO_TENTATIVAS_LOGIN) {
                                $identity->TentativasLogin = $numeroTentativasErradas;
                                $identity->IndicadorAtivo = '0';
                                $msg = 'Sua conta foi bloqueada por excesso de tentativas de login! Solicite alteração de sua senha!';
                            } else {
                                $identity->TentativasLogin = $numeroTentativasErradas;
                                $identity->IndicadorAtivo = '1';
                                $msg = 'Não foi possível logar! Verifique as informações preenchidas!';
                            }

                            if ($identity->update(true, ['TentativasLogin', 'IndicadorAtivo', 'DataHoraUltimaAtu']) !== false) {
                                Yii::$app->session->setFlash('error', $msg);
                                return $this->redirect(['professor/login']);
                            } else {
                                Yii::$app->session->setFlash('error', 'Problema ao fazer login!');
                                return $this->redirect(['professor/login']);
                            }
                        }
                    } else {
                        $identity->TentativasLogin++;
                        $identity->IndicadorAtivo = '0';

                        if ($identity->update(true, ['TentativasLogin', 'IndicadorAtivo', 'DataHoraUltimaAtu']) !== false) {
                            Yii::$app->session->setFlash('error', 'Sua conta foi bloqueada por excesso de tentativas de login! Solicite alteração de sua senha!');
                            return $this->redirect(['professor/login']);
                        } else {
                            Yii::$app->session->setFlash('error', 'Problema ao fazer login!');
                            return $this->redirect(['professor/login']);
                        }
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

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }

    public function actionEsqueceuSuaSenha() {
        if (isset($_POST['Professor'])) {
            try {
                $professor = Professor::find()->where(['Email' => $_POST['Professor']['Email']])->one();

                if (!empty($professor)) {
                    $resetPassword = new ResetPassword();
                    $resetPassword->DataExpiracao = (new DateTime('now'))->add(new DateInterval('PT8H'))->format('Y-m-d H:i:s');//;
                    $resetPassword->Hash = Utils::getToken();
                    $resetPassword->Email = $professor->Email;

                    if ($resetPassword->save()) {
                        //Utils::enviarEmail($professor->Nome, $professor->Email, 'Troca de Senha', Utils::montarEmailAlteraoSenha($professor->Nome, Url::to(['professor/alterar-senha', 'email' => $professor->Email, 'token' => $resetPassword->Hash], true)));
                        Yii::$app->session->setFlash('success', 'Um email foi enviado para <b>' . Utils::esconderEmail($professor->Email) . '</b> com instruições de como proceder para alterar a senha!');
                        return $this->redirect(['site/index']);
                    } else {
                        throw new Exception('Usuário não encontrado!');
                    }
                } else {
                    throw new Exception('Usuário não encontrado!');
                }
            } catch (Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->render('esqueceuSuaSenha', ['professor' => new Professor()]);
            }
        } else {
            return $this->render('esqueceuSuaSenha', ['professor' => new Professor()]);
        }
    }

    public function actionAlterarSenha() {
        if (isset($_GET['email']) && isset($_GET['token']) && !empty($_GET['email']) && !empty($_GET['token'])) {
            $resetPassword = ResetPassword::find()->where(['Email' => $_GET['email'], 'Hash' => $_GET['token']])->orderBy('DataExpiracao DESC')->one();

            if (!empty($resetPassword)) {
                $now = new DateTime('now');
                $dataExpiracao = DateTime::createFromFormat('Y-m-d H:i:s', $resetPassword->DataExpiracao);

                if ($now <= $dataExpiracao) {
                    return $this->render('alterarSenha', ['token' => $_GET['token'], 'email' => $_GET['email'], 'professor' => new Professor()]);
                } else {
                    $resetPassword->delete();
                    Yii::$app->session->setFlash('error', 'Este link não existe ou já foi desativado!');
                    return $this->redirect(['site/index']);
                }
            } else {
                Yii::$app->session->setFlash('error', 'Este link não existe ou já foi desativado!');
                return $this->redirect(['site/index']);
            }
        } elseif (isset($_POST['Professor'])) {
            try {
                if ($this->isDadosValidosFormAlteracaoSenha($_POST)) {
                    $token = $_POST['token'];
                    $email = $_POST['Professor']['Email'];
                    $senha = $_POST['Professor']['Senha'];
                    $senhaRepetida = $_POST['Professor']['SenhaRepetida'];

                    $resetPassword = ResetPassword::find()->where(['Email' => $email, 'Hash' => $token])->orderBy('DataExpiracao DESC')->one();
                    if (!empty($resetPassword)) {
                        $now = new DateTime('now');
                        $dataExpiracao = DateTime::createFromFormat('Y-m-d H:i:s', $resetPassword->DataExpiracao);

                        if ($now <= $dataExpiracao) {
                            if ($senha === $senhaRepetida) {
                                $professor = Professor::find()->where(['Email' => $email])->one();

                                if (!empty($professor)) {
                                    $professor->Senha = Yii::$app->getSecurity()->generatePasswordHash($senha);

                                    if ($professor->update(true, ['Senha', 'DataHoraUltimaAtu']) !== false) {
                                        ResetPassword::DeletarHashsDoEmail($email);
                                        Yii::$app->session->setFlash('success', 'Senha alterada com sucesso!');
                                        return $this->redirect('login');
                                    } else {
                                        throw new Exception('Informações inválidas!');
                                    }
                                } else {
                                    throw new Exception('Informações inválidas!');
                                }
                            } else {
                                throw new Exception('Informações inválidas!');
                            }
                        } else {
                            throw new Exception('Informações inválidas!');
                        }
                    } else {
                        throw new Exception('Informações inválidas!');
                    }
                } else {
                    throw new Exception('Informações inválidas!');
                }
            } catch (Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->redirect(['site/index']);
            }
        } else {
            Yii::$app->session->setFlash('error', 'Ação inválida!');
            return $this->redirect(['site/index']);
        }
    }

    /**
     * Verifica se todos os campos de formulário de alteração de senha estão setados e preenchidos
     * @param $_POST
     * @return bool
     */
    private function isDadosValidosFormAlteracaoSenha($POST) {
        if (isset($POST['token']) && isset($POST['Professor']['Email']) && isset($POST['Professor']['Senha']) && isset($POST['Professor']['SenhaRepetida']) &&
        !empty($POST['token']) && !empty($POST['Professor']['Email']) && !empty($POST['Professor']['Senha']) && !empty($POST['Professor']['SenhaRepetida'])) {
            return true;
        } else {
            return false;
        }
    }
}
