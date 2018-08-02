<?php
namespace app\commands;

use app\models\Company;
use app\models\Employee;
use yii\console\Controller;

class DataController extends Controller
{
    /**
     * Syntax:
     * ./yii data/create-company
     */
    public function actionCreateCompany()
    {
        $codes = ['vn', 'jp'];
        for ($i = 1; $i <= 10; $i++) {
            $company = Company::findOneCreateNew(['name' => "Company $i"]);
            $company->country_code = $codes[$i % 2];
            $company->saveThrowError();
        }
    }

    /**
     * Syntax:
     * ./yii data/create-employee
     */
    public function actionCreateEmployee()
    {
        for ($i = 1; $i <= 100; $i++) {
            $employee = Employee::findOneCreateNew(['name' => "Employee $i"]);
            $employee->company_id = $i % 10 + 1;
            $employee->gender = $i % 2 + 1;
            $employee->saveThrowError();
        }
    }
}
