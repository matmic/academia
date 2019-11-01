<?php
namespace app\modules\api;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBasicAuth;
use yii\rest\Serializer;
use app\models\Api;

/**
 * Description of BaseRestController
 *
 * @author abel
 */
class BaseRestController extends ActiveController {
    
    /**
     * @var array Configuração de serialização dos objetos da requisição
     */
    public $serializer = [
        'class' => Serializer::class,
        'collectionEnvelope' => 'items',
    ];
    
    public function behaviors() {

        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => function ($username, $password) {
                $user = Api::findByUsername($username);
                $result = Yii::$app->getSecurity()->validatePassword($password, $user->Senha);

                if ($user && $result) {
                    return $user;
                }
            }
        ];
        return $behaviors;
    }
    
    public function actions() {
        $actions = parent::actions();
        unset($actions['view'], $actions['create'], $actions['update'], $actions['delete'], $actions['options'], $actions['index']);
        return $actions;
    }
    
    
    
    
}
