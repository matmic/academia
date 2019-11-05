<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\BaseRestController;
use app\models\Aluno;
use yii\data\ArrayDataProvider;

/**
 * Description of AlunoController
 *
 * @author hermes
 */
class AlunoController extends BaseRestController {

    public $modelClass = Aluno::class;

    
    // acessar como POST api/aluno/create
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
    
    // acessar como GET api/aluno
    public function actionIndex()
    {
        return new ArrayDataProvider([
            'allModels' => Aluno::find()->asArray()->all()
        ]);
    }
    
    // acessar como PUT api/aluno/update?id=60
    public function actionUpdate($id){
        $model = Aluno::findOne($id);
        if($model->load(Yii::$app->getRequest()->getBodyParams(),'') && $model->save()){
            return $model;
        }else{
            return $model->getErrors();
        }
        
    }
    
    // acessar como GET api/aluno/view?id=60
    public function actionView($id){
        return Aluno::findOne($id);
    }
    
    // acessar como DELETE api/aluno/delete?id=60
    public function actionDelete($id){
        $model = Aluno::findOne($id);
        return $model->delete();
    }
    

}
