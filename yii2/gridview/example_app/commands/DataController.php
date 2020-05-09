<?php
namespace app\commands;

use app\models\Department;
use app\models\Employee;
use app\models\EmployeeInfo;
use batsg\helpers\HDateTime;
use batsg\models\BaseModel;
use yii\console\Controller;

class DataController extends Controller
{
    /**
     * Initiate sample data.
     * Syntax
     * ```shell
     * php yii data/sample
     * ```
     */
    public function actionSample()
    {
        for ($departmentIndex = 1; $departmentIndex <= 3; $departmentIndex++) {
            $this->createDepartment($departmentIndex);
        }
    }

    /**
     * @param int $departmentIndex
     * @return Department
     */
    private function createDepartment($departmentIndex)
    {
        $department = BaseModel::findOneCreateNew(['name' => "Department $departmentIndex"], TRUE, Department::class);
        $manager = FALSE;
        for ($employeeIndex = 1; $employeeIndex <= 3; $employeeIndex++) {
            $employee = $this->createEmployee($department, $departmentIndex, $employeeIndex);
            if (!$manager) {
                $manager = $employee;
            }
        }
        $department->manager_id = $manager->id;
        BaseModel::saveThrowErrorModel($department);
        return $department;
    }

    /**
     * @param Department $department
     * @param int $departmentIndex
     * @param int $employeeIndex
     * @return Employee
     */
    private function createEmployee($department, $departmentIndex, $employeeIndex)
    {
        // Create Employee
        $employeeName = "Employee {$departmentIndex}_{$employeeIndex}";
        /** @var Employee $employee */
        $employee = BaseModel::findOneCreateNew([
            'name' => $employeeName,
            'department_id' => $department->id,
        ], TRUE, Employee::class);

        // Create EmployeeInfo
        $houseNumber = $departmentIndex + $employeeIndex;
        $this->createEmployeeInfo($employee, $houseNumber);

        return $employee;
    }

    /**
     * @param Employee $employee
     * @param int $houseNumber
     */
    private function createEmployeeInfo(Employee $employee, $houseNumber)
    {
        // Create gender
        BaseModel::findSetAttr([
            'employee_id' => $employee->id,
            'code' => EmployeeInfo::CODE_GENDER,
            'value' => (string)($houseNumber % 2 + 1),
        ], ['employee_id', 'code'], TRUE, EmployeeInfo::class);
        // Create birth date
        BaseModel::findSetAttr([
            'employee_id' => $employee->id,
            'code' => EmployeeInfo::CODE_BIRTH_DATE,
            'value' => HDateTime::createFromYmdHms(1980, $houseNumber % 12 + 1, $houseNumber % 29 + 1)->toDateStr(),
        ], ['employee_id', 'code'], TRUE, EmployeeInfo::class);
        // Create address
        BaseModel::findSetAttr([
            'employee_id' => $employee->id,
            'code' => EmployeeInfo::CODE_GENDER,
            'value' => "$houseNumber Nottingham street, Palo Alto, CA",
        ], ['employee_id', 'code'], TRUE, EmployeeInfo::class);
    }
}
