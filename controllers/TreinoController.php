<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Professor;
use app\models\Aluno;
use app\models\Treino;
use app\models\Aparelho;
use app\models\Exercicio;
use app\models\Grupo;
use yii\helpers\VarDumper;
use Exception;
use yii\data\SqlDataProvider;

class TreinoController extends Controller
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
		$treino = Treino::find()->where(['IdTreino' => $IdTreino])->one();
		
		if (!empty($treino)) {
			
			$exercicios = Exercicio::find()->joinWith(['aparelho', 'aparelho.grupo'])->where(['IdTreino' => $IdTreino]);
			$provider = new ActiveDataProvider([
				'query' => $exercicios,
				'pagination' => [
					'pageSize' => 100,
				],
			]);
			
			return $this->render('visualizar', ['treino' => $treino, 'dataProvider' => $provider]);
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
				$provider = new SqlDataProvider([
					'sql' => 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, EXE.Series, EXE.Repeticoes, EXE.Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho AND EXE.IdTreino = :IdTreino INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo',
					'params' => [':IdTreino' => $IdTreino],
					'pagination' => [
						'pageSize' => 100,
					],
					'sort' => [
						'attributes' => [
							'NomeGrupo',
							'NomeAparelho',
						],
					],
				]);
				
				return $this->render('editar', ['treino' => $treino, 'dataProvider'=>$provider]);
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
				$transaction = Yii::$app->db->beginTransaction();
				try {
					$treino = new Treino();
					$treino->attributes =  $_POST['Treino'];
				
					if ($treino->save()) {
						
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
						
						$transaction->commit();
						Yii::$app->session->setFlash('success', 'Treino salvo com sucesso!');
						return $this->redirect('listar');
					} else {
						throw new Exception('Não foi possível salvar o treino!');
						return $this->redirect('listar');
					}
				} catch (Exception $e) {
					Yii::$app->session->setFlash('error', $e->getMessage());
					return $this->redirect('listar');
				}
			}
		} else {
			$treino = new Treino();

			$provider = new SqlDataProvider([
				'sql' => 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho FROM aparelho AP INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo',
				'pagination' => [
					'pageSize' => 100,
				],
				// 'sort' => [
					// 'attributes' => [
						// 'NomeGrupo',
						// 'NomeAparelho',
					// ],
				// ],
			]);
			
			$arrProviders = Grupo::getDataProvidersGrupos();
			
			return $this->render('editar', ['treino' => $treino, 'dataProvider' => $provider, 'arrProviders' => $arrProviders]);
		}
	}
}