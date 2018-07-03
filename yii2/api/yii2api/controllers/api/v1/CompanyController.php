<?php
namespace app\controllers\api\v1;

use yii\rest\ActiveController;

/**
 * Test:
 *  curl -i -H "Accept:application/json" "http://yii2api/api/v1/companies"
 */
class CompanyController extends ActiveController
{
    public $modelClass = 'app\models\CompanyApi';
}