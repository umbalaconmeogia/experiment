<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "department".
 *
 * @property int $id
 * @property string $name
 * @property int|null $manager_id
 *
 * @property Employee[] $employee
 * @property Employee $manager
 */
class Department extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'department';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['manager_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'manager_id' => Yii::t('app', 'Manager'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employee::className(), ['department_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getManager()
    {
        return $this->hasOne(Employee::className(), ['id' => 'manager_id']);
    }

    /**
     * Also clear department of Employee that belongs to this Department.
     * {@inheritdoc}
     */
    public function beforeDelete()
    {
        $result = parent::beforeDelete();

        if ($result) {
            // Clear all Department's manager that is this Employee.
            Employee::updateAll(['department_id' => NULL], ['department_id' => $this->id]);
        }

        return $result;
    }

    public static function allDepartmentOptionArr()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'name');
    }
}
