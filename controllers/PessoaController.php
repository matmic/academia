<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Pessoa;
use app\models\Endereco;
use app\models\Aluno;
use yii\data\ActiveDataProvider;
use yii\helpers\VarDumper;

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
			$pessoa = Pessoa::find()->where(['IdPessoa'=>$IdPessoa])->with(['endereco', 'aluno'])->one();

			if (!empty($pessoa)) {
				return $this->render('editar', ['pessoa' => $pessoa, 'endereco'=>$pessoa->endereco, 'aluno'=>(!empty($pessoa->aluno) ? $pessoa->aluno : new Aluno())]);
			} else {
				Yii::$app->session->setFlash('error', 'Pessoa inválida!');
				return $this->redirect('listar');
			}
		} elseif (isset($_POST['Pessoa'])) {
			if (!empty($_POST['Pessoa']['IdPessoa'])) {
				$transaction = Yii::$app->db->beginTransaction();
				try {
					$pessoa = Pessoa::find()->where(['IdPessoa'=>$_POST['Pessoa']['IdPessoa']])->with(['endereco', 'aluno'])->one();
					
					if (!empty($pessoa)) {
						$pessoa->endereco->attributes = $_POST['Endereco'];
						// TODO REFORMULAR
						if ($pessoa->endereco->save()) {
							$pessoa->attributes = $_POST['Pessoa'];
							
							if ($_POST['Pessoa']['IdAluno'] == '1') {
								
								if ($pessoa->IdAluno == null) {
									$aluno = new Aluno();
									$aluno->attributes = $_POST['Aluno'];
									$pessoa->aluno = $aluno;
								} else {
									$aluno = $pessoa->aluno;
									$aluno->attributes = $_POST['Aluno'];
									$pessoa->aluno = $aluno;
								}
																	
								if ($pessoa->aluno->save()) {
									$pessoa->IdAluno = $aluno->IdAluno;
								} else {
									throw new \Exception('Não foi possível salvar o aluno!');
								}
							} else {
								if ($pessoa->IdAluno != null) {
									$pessoa->IdAluno = null;
									$pessoa->aluno->delete();
									
								}
							}
							
							if ($pessoa->save()) {
								$transaction->commit();
								Yii::$app->session->setFlash('success', 'Pessoa salva com sucesso!');
								return $this->redirect('listar');
							} else {
								throw new \Exception('Não foi possível salvar a pessoa!');
							}
						} else {
							throw new \Exception('Não foi possível salvar o endereço!');
						}
					}
				} catch (Exception $e) {
					$transaction->rollBack();
				}
			} else {
				$transaction = Yii::$app->db->beginTransaction();
				try {
					$endereco = new Endereco();
					$endereco->attributes = $_POST['Endereco'];
					if ($endereco->save()) {
						$pessoa = new Pessoa();
						$pessoa->attributes = $_POST['Pessoa'];
						$pessoa->IdEndereco = $endereco->IdEndereco;
						$pessoa->Senha = Yii::$app->getSecurity()->generatePasswordHash('414124344');
						
						if ($_POST['Pessoa']['IdAluno'] == '1') {
							$aluno = new Aluno();
							$aluno->attributes = $_POST['Aluno'];
							
							if ($aluno->save()) {
								$pessoa->IdAluno = $aluno->IdAluno;
							} else {
								throw new \Exception('Não foi possível salvar o aluno!');
							}
						} else {
							$pessoa->IdAluno = null;
						}
						
						if ($pessoa->save()) {
							$transaction->commit();
							Yii::$app->session->setFlash('success', 'Pessoa salva com sucesso!');
							return $this->redirect('listar');
						} else {
							throw new \Exception('Não foi possível salvar a pessoa!');
						}
					} else {
						throw new \Exception('Não foi possível salvar o endereço!');
					}
				} catch (\Exception $e) {
					$transaction->rollBack();
					Yii::$app->session->setFlash('error', $e->getMessage());
					return $this->redirect('listar');
				}
			}
		} else {
			$pessoa = new Pessoa();
			$endereco = new Endereco();
			$aluno = new Aluno();
			$pessoa->IdAluno = true;
			return $this->render('editar', ['pessoa' => $pessoa, 'endereco' => $endereco, 'aluno' => $aluno]);
		}
	}
}
