<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\BaseRestController;
use app\models\Treino;
use yii\data\ArrayDataProvider;

/**
 * Description of TreinoController
 *
 * @author hermes
 */
class TreinoController extends BaseRestController {

    public $modelClass = Treino::class;

    
    // acessar como POST api/treino/create
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
    
    // acessar como GET api/treino
    public function actionIndex()
    {
        return new ArrayDataProvider([
            'allModels' => Treino::find()->asArray()->all()
        ]);
    }
    
    // acessar como PUT api/treino/update?id=60
    public function actionUpdate($id){
        $model = Treino::findOne($id);
        if($model->load(Yii::$app->getRequest()->getBodyParams(),'') && $model->save()){
            return $model;
        }else{
            return $model->getErrors();
        }
        
    }
    
    // acessar como GET api/treino/view?id=60
    public function actionView($id){
        return Treino::findOne($id);
    }
    
    // acessar como DELETE api/treino/delete?id=60
    public function actionDelete($id){
        $model = Treino::findOne($id);
        return $model->delete();
    }
    

}
