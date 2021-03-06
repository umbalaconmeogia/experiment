<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\Company;
use yii\console\Controller;
use app\models\Project;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class TestDataController extends Controller
{
    /**
     * Syntax:
     * ./yii test-data/index
     */
    public function actionIndex()
    {
        \Yii::$app->db->transaction(function() {
            for ($companyId = 1; $companyId <= 10; $companyId++) {
                $company = new Company([
                    'name' => "会社 $companyId",
                ]);
                $company->saveThrowError();
                for ($projectId = 1; $projectId <= 10; $projectId++) {
                    $project = new Project([
                        'name' => "案件 {$companyId}_$projectId",
                        'company_id' => $company->id,
                    ]);
                    $project->saveThrowError();
                }
            }
        });
    }
}
