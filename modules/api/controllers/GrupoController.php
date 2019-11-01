<?php
namespace app\modules\api\controllers;

use app\modules\api\BaseRestController;
use app\models\Grupo;

/**
 * Description of Grupos
 *
 * @author abel
 */
class GrupoController extends BaseRestController {
    
    public $modelClass = Grupo::class;
    
}
