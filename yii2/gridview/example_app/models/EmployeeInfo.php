<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "employee_info".
 *
 * @property int $id
 * @property int $employee_id
 * @property string $code
 * @property string|null $value
 *
 * @return string $codeStr Get human readable name of code.
 * @return string $valueStr Get human readable name of value.
 */
class EmployeeInfo extends \yii\db\ActiveRecord
{
    const CODE_BIRTH_DATE = 'birth_date';
    const CODE_ADDRESS = 'address';
    const CODE_GENDER = 'gender';

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_info';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'code'], 'required'],
            [['employee_id'], 'integer'],
            [['code', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'employee_id' => Yii::t('app', 'Employee'),
            'code' => Yii::t('app', 'Code'),
            'value' => Yii::t('app', 'Value'),
        ];
    }

    /**
     * @return string[]
     */
    public static function codeOptionArr()
    {
        return [
            self::CODE_BIRTH_DATE => Yii::t('app', 'Birth date'),
            self::CODE_ADDRESS => Yii::t('app', 'Address'),
            self::CODE_GENDER => Yii::t('app', 'Gender'),
        ];
    }

    /**
     * @return string
     */
    public function getCodeStr()
    {
        return ArrayHelper::getValue(self::codeOptionArr(), $this->code);
    }

    /**
     * Get label of specified $code.
     * @param string $code
     * @return string
     */
    public static function codeLabel($code)
    {
        return self::codeOptionArr()[$code];
    }

    /**
     * @return string[]
     */
    public static function codes()
    {
        return array_keys(self::codeOptionArr());
    }

    /**
     * @return string[]
     */
    public static function genderOptionArr()
    {
        return [
            self::GENDER_MALE => Yii::t('app', 'Male'),
            self::GENDER_FEMALE => Yii::t('app', 'Female'),
        ];
    }

    /**
     * @return string
     */
    public function getValueStr()
    {
        if ($this->code == self::CODE_GENDER) {
            $result = ArrayHelper::getValue(self::genderOptionArr(), $this->value);
        } else {
            $result = $this->value;
        }
        return $result;
    }
}
