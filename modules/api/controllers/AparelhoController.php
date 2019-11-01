<?php

namespace app\modules\api\controllers;

use Yii;
use app\modules\api\BaseRestController;
use app\models\Aparelho;
use yii\data\ArrayDataProvider;

/**
 * Description of AparelhoController
 *
 * @author abel
 */
class AparelhoController extends BaseRestController {

    public $modelClass = Aparelho::class;

    
    // acessar como POST api/aparelho/create
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
    
    // acessar como GET api/aparelho
    public function actionIndex()
    {
        return new ArrayDataProvider([
            'allModels' => Aparelho::find()->asArray()->all()
        ]);
    }
    
    // acessar como PUT api/aparelho/update?id=60
    public function actionUpdate($id){
        $model = Aparelho::findOne($id);
        if($model->load(Yii::$app->getRequest()->getBodyParams(),'') && $model->save()){
            return $model;
        }else{
            return $model->getErrors();
        }
        
    }
    
    // acessar como GET api/aparelho/view?id=60
    public function actionView($id){
        return Aparelho::findOne($id);
    }
    
    // acessar como DELETE api/aparelho/delete?id=60
    public function actionDelete($id){
        $model = Aparelho::findOne($id);
        return $model->delete();
    }
    

}
