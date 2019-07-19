<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use app\models\Professor;
use app\models\Aluno;

class AuxiliarController extends Controller
{
    // public function actionAutoCompleteProfessor($term) {
		// $professores = Professor::find()->select(['IdProfessor', 'Nome'])->where(['and', 'IndicadorAtivo="1"', ['like', 'Nome', $term]])->orderBy('Nome')->all();
		
		// if ($professores != null) {
			// $arr = array();
			// foreach ($professores as $row) {
				// $arr[] = array(
					// 'label' => $row->Nome,
					// 'IdProfessor' => $row->IdProfessor,
				// );
			// }
			// echo json_encode($arr);
		// } else {
			// return false;
		// }
	// }
	
	// public function actionAutoCompleteAluno($term) {
		// $alunos = Aluno::find()->select(['IdAluno', 'Nome'])->where(['and', 'IndicadorAtivo="1"', ['like', 'Nome', $term]])->orderBy('Nome')->all();
		
		// if ($alunos != null) {
			// $arr = array();
			// foreach ($alunos as $row) {
				// $arr[] = array(
					// 'label' => $row->Nome,
					// 'IdAluno' => $row->IdAluno,
				// );
			// }
			// echo json_encode($arr);
		// } else {
			// return false;
		// }
	// }
}
