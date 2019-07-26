<?php

namespace app\controllers;

use Yii;
use Exception;
use app\models\Grupo;
use app\models\Treino;
use yii\web\Controller;
use app\models\Exercicio;
use yii\data\SqlDataProvider;
use yii\data\ActiveDataProvider;

class TreinoController extends BaseController
{
    public function actionListar()
    {
		$treinos = Treino::find()->joinWith(['aluno', 'professor'])->where(['treino.IndicadorAtivo' => '1']);
		
		$provider = new ActiveDataProvider([
			'query' => $treinos,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		
		$provider->sort->attributes['aluno'] = [
			'asc' => ['aluno.Nome' => SORT_ASC],
			'desc' => ['aluno.Nome' => SORT_DESC],
		];
		$provider->sort->attributes['professor'] = [
			'asc' => ['professor.Nome' => SORT_ASC],
			'desc' => ['professor.Nome' => SORT_DESC],
		];

		return $this->render('listar', ['dataProvider' => $provider]);
    }
	
	public function actionVisualizar($IdTreino) {
		$treino = Treino::find()->joinWith(['aluno', 'professor'])->where(['IdTreino' => $IdTreino])->one();
		
		if (!empty($treino)) {
			$exercicios = Exercicio::find()->joinWith(['aparelho', 'aparelho.grupo'])->where(['IdTreino' => $IdTreino]);
			$provider = new ActiveDataProvider([
				'query' => $exercicios,
				'pagination' => [
					'pageSize' => 100,
				],
			]);
			
			return $this->render('visualizar', ['treino' => $treino, 'dataProvider' => $provider, 'arrProviders' => Exercicio::getExerciciosDoTreino($IdTreino)]);
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
				$arrProviders = Grupo::getDataProviders($IdTreino);
				return $this->render('editar', ['treino' => $treino, 'arrProviders'=>$arrProviders]);
			} else {
				Yii::$app->session->setFlash('error', 'Treino inválido!');
				return $this->redirect('listar');
			}
		} elseif (isset($_POST['Treino'])) {
			if (!empty($_POST['Treino']['IdTreino'])) {
				$IdTreino = $_POST['Treino']['IdTreino'];
				$treino = Treino::findOne($IdTreino);
				
				if (!empty($treino)) {
					$transaction = Yii::$app->db->beginTransaction();
					try {
						$treino->attributes = $_POST['Treino'];
						
						if ($treino->update(true, ['IdProfessor', 'IdAluno', 'Nome', 'Objetivos', 'DataHoraUltimaAtu']) !== false) {
							Exercicio::DeletarExerciciosDoTreino($treino->IdTreino);
							
							if (isset($_POST['selection'])) {
                                foreach ($_POST['selection'] as $aparelho) {
                                    $exercicio = new Exercicio();
                                    $exercicio->IdTreino = $treino->IdTreino;
                                    $exercicio->IdAparelho = $aparelho;
                                    $exercicio->Series = $_POST['Series'][$aparelho];
                                    $exercicio->Repeticoes = $_POST['Repeticoes'][$aparelho];
                                    $exercicio->Peso = $_POST['Peso'][$aparelho];

                                    if (!$exercicio->save()) {
                                        throw new Exception('Não foi possível salvar o exercício!');
                                    }
                                }
                            }
							
							$transaction->commit();
							Yii::$app->session->setFlash('success', 'Treino salvo com sucesso!');
							return $this->redirect(['visualizar', 'IdTreino' => $treino->IdTreino]);
						} else {
							throw new Exception('Não foi possível salvar o treino!');
						}
					} catch (Exception $e) {
						$transaction->rollBack();
						Yii::$app->session->setFlash($e->getMessage());
						return $this->redirect('listar');
					}
				} else {
					Yii::$app->session->setFlash('error', 'Treino inválido!');
					return $this->redirect('listar');
				}
			} else {
				$transaction = Yii::$app->db->beginTransaction();
				try {
					$treino = new Treino();
					$treino->attributes =  $_POST['Treino'];
				
					if ($treino->save()) {
						if (isset($_POST['selection'])) {
                            foreach ($_POST['selection'] as $aparelho) {
                                $exercicio = new Exercicio();
                                $exercicio->IdTreino = $treino->IdTreino;
                                $exercicio->IdAparelho = $aparelho;
                                $exercicio->Series = $_POST['Series'][$aparelho];
                                $exercicio->Repeticoes = $_POST['Repeticoes'][$aparelho];
                                $exercicio->Peso = $_POST['Peso'][$aparelho];

                                if (!$exercicio->save()) {
                                    throw new Exception('Não foi possível salvar o exercício!');
                                }
                            }
                        }
						
						$transaction->commit();
						Yii::$app->session->setFlash('success', 'Treino salvo com sucesso!');
						return $this->redirect(['visualizar', 'IdTreino' => $treino->IdTreino]);
					} else {
						throw new Exception('Não foi possível salvar o treino!');
						return $this->redirect('listar');
					}
				} catch (Exception $e) {
					$transaction->rollBack();
					Yii::$app->session->setFlash('error', $e->getMessage());
					return $this->redirect('listar');
				}
			}
		} else {
			$treino = new Treino();
			$arrProviders = Grupo::getDataProviders();
			return $this->render('editar', ['treino' => $treino, 'arrProviders' => $arrProviders]);
		}
	}
}