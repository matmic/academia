<?php

namespace app\controllers;

use Yii;
use app\models\Aluno;
use app\models\Treino;
use yii\db\Exception;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\AlunoDisponibilidade;

class AlunoController extends BaseController
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
		$aluno = Aluno::find()->joinWith(['alunodisponibilidades', 'alunodisponibilidades.disponibilidade'])->where(['aluno.IdAluno' =>$IdAluno])->one();
		
		if (!empty($aluno)) {
			$treinos = Treino::find()->joinWith(['professor'])->where(['treino.IndicadorAtivo' => '1', 'treino.IdAluno' => $IdAluno]);
		
			$provider = new ActiveDataProvider([
				'query' => $treinos,
				'pagination' => [
					'pageSize' => 10,
				],
			]);
			
			return $this->render('visualizar', ['aluno' => $aluno, 'dataProvider' => $provider]);
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
				return $this->render('editar', ['aluno' => $aluno, 'disponibilidades' => AlunoDisponibilidade::getDisponibilidadesDoAluno($IdAluno)]);
			} else {
				Yii::$app->session->setFlash('error', 'Aluno inválido!');
				return $this->redirect('listar');
			}
		} elseif (isset($_POST['Aluno'])) {
			if (!empty($_POST['Aluno']['IdAluno'])) {
                $transaction = Yii::$app->db->beginTransaction();
                try {
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
                            'DataHoraUltimaAtu',
                        ];

                        if ($aluno->update(true, $arrSalvar) !== false) {
                            AlunoDisponibilidade::excluirDisponibilidadesDoAluno($aluno->IdAluno);

                            if (isset($_POST['AlunoDisponibilidade'])) {
                                foreach ($_POST['AlunoDisponibilidade'] as $disponibilidade) {
                                    $alunoDisponibilidade = new AlunoDisponibilidade();
                                    $alunoDisponibilidade->IdAluno = $aluno->IdAluno;
                                    $alunoDisponibilidade->IdDisponibilidade = $disponibilidade;

                                    if (!$alunoDisponibilidade->save()) {
                                        throw new Exception('Não foi possível salvar a disponibilidade');
                                    }
                                }
                            }

                            $transaction->commit();
                            Yii::$app->session->setFlash('success', 'Aluno salvo com sucesso!');
                            return $this->redirect(['visualizar', 'IdAluno' => $aluno->IdAluno]);
                        } else {
                            throw new Exception('Não foi possível salvar o aluno!');
                        }
                    } else {
                        throw new Exception('Aluno inválido!');
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', $e->getMessage());
                    return $this->redirect('listar');
                }
			} else {
                $transaction = Yii::$app->db->beginTransaction();
                try {
                    $aluno = new Aluno();
                    $aluno->attributes = $_POST['Aluno'];

                    if ($aluno->save()) {
                        if (isset($_POST['AlunoDisponibilidade'])) {
                            foreach ($_POST['AlunoDisponibilidade'] as $disponibilidade) {
                                $alunoDisponibilidade = new AlunoDisponibilidade();
                                $alunoDisponibilidade->IdAluno = $aluno->IdAluno;
                                $alunoDisponibilidade->IdDisponibilidade = $disponibilidade;

                                if (!$alunoDisponibilidade->save()) {
                                    throw new Exception('Não foi possível salvar a disponibilidade');
                                }
                            }
                        }

                        $transaction->commit();
                        Yii::$app->session->setFlash('success', 'Aluno salvo com sucesso!');
                        return $this->redirect(['visualizar', 'IdAluno' => $aluno->IdAluno]);
                    } else {
                        throw new Exception('Não foi possível salvar o aluno!');
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                    Yii::$app->session->setFlash('error', $e->getMessage());
                    return $this->redirect('listar');
                }
			}
		} else {
			$aluno = new Aluno();
			return $this->render('editar', ['aluno' => $aluno, 'disponibilidades' => []]);
		}
	}
}
