<?php
namespace app\modules\api\controllers;

use app\modules\api\BaseRestController;
use app\models\Grupo;
use yii\data\ArrayDataProvider;


/**
 * Description of Grupos
 *
 * @author abel
 */
class GrupoController extends BaseRestController {
    
    public $modelClass = Grupo::class;

    // acessar como POST api/grupo/create
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
    
    // acessar como GET api/grupo
    public function actionIndex()
    {
        return new ArrayDataProvider([
            'allModels' => Grupo::find()->asArray()->all()
        ]);
    }
    
    // acessar como PUT api/grupo/update?id=60
    public function actionUpdate($id){
        $model = Grupo::findOne($id);
        if($model->load(Yii::$app->getRequest()->getBodyParams(),'') && $model->save()){
            return $model;
        }else{
            return $model->getErrors();
        }
        
    }
    
    // acessar como GET api/grupo/view?id=60
    public function actionView($id){
        return Grupo::findOne($id);
    }
    
    // acessar como DELETE api/grupo/delete?id=60
    public function actionDelete($id){
        $model = Grupo::findOne($id);
        return $model->delete();
    }
    
}
