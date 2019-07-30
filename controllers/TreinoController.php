<?php

namespace app\controllers;

use Yii;
use DateTime;
use Exception;
use DateTimeZone;
use app\models\Grupo;
use app\models\Treino;
use app\models\Exercicio;
use app\models\Frequencia;
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
            $frequencias = Frequencia::find()->where(['IdTreino' => $IdTreino])->orderBy('DataFrequencia DESC');

            $dataProvider = new ActiveDataProvider([
                'query' => $frequencias,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]);

            return $this->render('visualizar', ['treino' => $treino, 'dataProviderFrequencia' => $dataProvider, 'arrProviders' => Exercicio::getExerciciosDoTreino($IdTreino)]);
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

    public function actionMarcarFrequencia()
    {
        if (isset($_POST['IdTreino']) && !empty($_POST['IdTreino'])) {
            $IdTreino = $_POST['IdTreino'];
            $dataAtual = (new DateTime('now', new DateTimeZone('America/Sao_Paulo')))->format('Y-m-d');

            $frequencia = Frequencia::find()->where(['IdTreino' => $IdTreino, 'DataFrequencia' => $dataAtual])->one();

            if (empty($frequencia)) {
                $frequencia = new Frequencia();
                $frequencia->IdTreino = $IdTreino;

                if ($frequencia->save()) {
                    echo json_encode(array(
                        "msg" => 'Frequência salva com sucesso!',
                        "erro" => 0,
                    ));
                } else {
                    echo json_encode(array(
                        "msg" => 'Não foi possível salvar a frequência!',
                        "erro" => 1,
                    ));
                }
            } else {
                echo json_encode(array(
                    "msg" => 'A frequência de hoje já foi adicionada!',
                    "erro" => 1,
                ));
            }
        } else {
            echo json_encode(array(
                "msg" => 'Não foi possível salvar a frequência!',
                "erro" => 1,
            ));
        }
    }
}