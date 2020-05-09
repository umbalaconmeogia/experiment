<?php

namespace app\models;

use Exception;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $name
 * @property int|null $department_id
 *
 * @property EmployeeInfo[] $employeeInfos
 * @property EmployeeInfo[] $employeeInfoHashCode Map between code and EmployeeInfo.
 */
class Employee extends \yii\db\ActiveRecord
{
    /**
     * @var string[] Store EmployeeInfo(s). Map between info code and its value
     */
    public $employeeInfoValues;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['department_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['employeeInfoValues'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'department_id' => Yii::t('app', 'Department'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartment()
    {
        return $this->hasOne(Department::className(), ['id' => 'department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeInfos()
    {
        return $this->hasMany(EmployeeInfo::className(), ['employee_id' => 'id']);
    }

    /**
     * @return string[] Map between EmployeeInfo(s) code=>value
     */
    public function getEmployeeInfoHashCode()
    {
        return ArrayHelper::map($this->employeeInfos, 'code', function($model) { return $model; });
    }

    /**
     * @return string
     */
    private function getEmnployeeInfoValue($code)
    {
        return isset($this->employeeInfoHashCode[$code]) ? $this->employeeInfoHashCode[$code]->value : NULL;
    }

    /**
     * {@inheritdoc}
     */
    public function afterFind()
    {
        foreach ($this->employeeInfoValues as $code => $one) {
            $this->employeeInfoValues[$code] = $this->getEmnployeeInfoValue($code);
        }
        parent::afterFind();
    }

    /**
     * Delete all EmployeeInfo when delete this Employee.
     * Also clear manager of Department that is this Employee.
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        $result = parent::beforeDelete();

        if ($result) {
            // Delete all relative EmployeeInfo
            EmployeeInfo::deleteAll(['employee_id' => $this->id]);
            // Clear all Department's manager that is this Employee.
            Department::updateAll(['manager_id' => NULL], ['manager_id' => $this->id]);
        }

        return $result;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            // Create new EmployeeInfo(s)
            foreach ($this->employeeInfoValues as $code => $value) {
                $model = new EmployeeInfo();
                $model->employee_id = $this->id;
                $model->code = $code;
                $model->value = empty($value) ? NULL : $value;
                $model->save();
            }
        } else {
            // Update EmployeeInfo(s) by input value stored in $this->employeeInfoValues.
            foreach ($this->employeeInfos as $employeeInfo){
                $code = $employeeInfo->code;
                $employeeInfo->value = empty($this->employeeInfoValues[$code]) ? NULL : $this->employeeInfoValues[$code];
                $employeeInfo->save();
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function __construct($config = [])
    {
        // Initiate $this->employeeInfoValues
        foreach (EmployeeInfo::codes() as $code) {
            $config['employeeInfoValues'][$code] = null;
        }
        parent::__construct($config);
    }
}
