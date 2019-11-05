<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\BaseRestController;
use app\models\Exercicio;
use yii\data\ArrayDataProvider;

/**
 * Description of ExercicioController
 *
 * @author hermes
 */
class ExercicioController extends BaseRestController {

    public $modelClass = Exercicio::class;

    
    // acessar como POST api/exercicio/create
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
    
    // acessar como GET api/exercicio
    public function actionIndex()
    {
        return new ArrayDataProvider([
            'allModels' => Exercicio::find()->asArray()->all()
        ]);
    }
    
    // acessar como PUT api/exercicio/update?id=60
    public function actionUpdate($id){
        $model = Exercicio::findOne($id);
        if($model->load(Yii::$app->getRequest()->getBodyParams(),'') && $model->save()){
            return $model;
        }else{
            return $model->getErrors();
        }
        
    }
    
    // acessar como GET api/exercicio/view?id=60
    public function actionView($id){
        return Exercicio::findOne($id);
    }
    
    // acessar como DELETE api/exercicio/delete?id=60
    public function actionDelete($id){
        $model = Exercicio::findOne($id);
        return $model->delete();
    }
    

}
