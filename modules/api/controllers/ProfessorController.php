<?php
namespace app\modules\api\controllers;

use app\modules\api\BaseRestController;
use app\models\Professor;

/**
 * Description of ProfessorController
 *
 * @author abel
 */
class ProfessorController extends BaseRestController {
    
    public $modelClass = Professor::class;
    
}
