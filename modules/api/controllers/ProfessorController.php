<?php
namespace app\modules\api\controllers;


use Yii;
use app\modules\api\BaseRestController;
use app\models\Professor;
use yii\data\ArrayDataProvider;

/**
 * Description of ProfessorController
 *
 * @author abel
 */
class ProfessorController extends BaseRestController {
    
    public $modelClass = Professor::class;

    // acessar como POST api/professor/create
    public function actionCreate(){
        
        $model = new $this->modelClass();
        
        if($model->load(Yii::$app->getRequest()->getBodyParams(),'') && $model->save()){
            return $model;
        }else{
            return $model->getErrors();
        }
    }
    
    protected function verbs()
    {
        return [
            'index' => ['GET', 'HEAD'],
            'view' => ['GET', 'HEAD'],
            'create' => ['POST'],
            'update' => ['PUT', 'PATCH'],
            'delete' => ['DELETE'],
        ];
    }
    
    // acessar como GET api/professor
    public function actionIndex()
    {
        return new ArrayDataProvider([
            'allModels' => Professor::find()->asArray()->all()
        ]);
    }
    
    // acessar como PUT api/professor/update?id=60
    public function actionUpdate($id){
        $model = Professor::findOne($id);
        if($model->load(Yii::$app->getRequest()->getBodyParams(),'') && $model->save()){
            return $model;
        }else{
            return $model->getErrors();
        }
        
    }
    
    // acessar como GET api/professor/view?id=60
    public function actionView($id){
        return Professor::findOne($id);
    }
    
    // acessar como DELETE api/professor/delete?id=60
    public function actionDelete($id){
        $model = Professor::findOne($id);
        return $model->delete();
    }
    
}
