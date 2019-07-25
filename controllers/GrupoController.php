<?php

namespace app\controllers;

use Yii;
use app\models\Grupo;
use yii\web\Controller;
use yii\data\ActiveDataProvider;

class GrupoController extends BaseController
{
    public function actionListar()
    {
		$grupos = Grupo::find();
		
		$provider = new ActiveDataProvider([
			'query' => $grupos,
			'pagination' => [
				'pageSize' => 10,
			],
		]);
		
		return $this->render('listar', ['dataProvider' => $provider]);
    }
	
	public function actionVisualizar($IdGrupo) {
		$grupo = Grupo::findOne($IdGrupo);
		
		if (!empty($grupo)) {
			return $this->render('visualizar', ['grupo' => $grupo]);
		} else {
			Yii::$app->session->setFlash('error', 'Grupo inválido!');
			return $this->redirect('listar');
		}
	}
	
	public function actionEditar() {
		if (isset($_GET['IdGrupo'])) {
			$IdGrupo = $_GET['IdGrupo'];
			$grupo = Grupo::findOne($IdGrupo);

			if (!empty($grupo)) {
				return $this->render('editar', ['grupo' => $grupo]);
			} else {
				Yii::$app->session->setFlash('error', 'Grupo inválido!');
				return $this->redirect('listar');
			}
		} elseif (isset($_POST['Grupo'])) {
			if (!empty($_POST['Grupo']['IdGrupo'])) {
				$IdGrupo = $_POST['Grupo']['IdGrupo'];
				$grupo = Grupo::findOne($IdGrupo);
				
				if (!empty($grupo)) {
					$grupo->attributes = $_POST['Grupo'];
					
					if ($grupo->save()) {
						Yii::$app->session->setFlash('success', 'Grupo salvo com sucesso!');
						return $this->redirect('listar');
					} else {
						Yii::$app->session->setFlash('error', 'Não foi possível salvar o grupo!');
						return $this->redirect('listar');
					}
				} else {
					Yii::$app->session->setFlash('error', 'Grupo inválido!');
					return $this->redirect('listar');
				}
			} else {
				$grupo = new Grupo();
				$grupo->attributes =  $_POST['Grupo'];
				
				if ($grupo->save()) {
					Yii::$app->session->setFlash('success', 'Grupo salvo com sucesso!');
					return $this->redirect('listar');
				} else {
					Yii::$app->session->setFlash('error', 'Não foi possível salvar o grupo!');
					return $this->redirect('listar');
				}
			}
		} else {
			$grupo = new Grupo();
			return $this->render('editar', ['grupo' => $grupo]);
		}
	}
}
