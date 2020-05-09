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
 * @return string $codeStr
 * @return string $genderStr Get gender name (incase this record store gender infor)
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
            'id' => 'ID',
            'employee_id' => 'Employee ID',
            'code' => 'Code',
            'value' => 'Value',
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
     * @return string[]
     */
    public static function genderOptionArr()
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
    public function getGenderStr()
    {
        return ArrayHelper::getValue(self::genderOptionArr(), $this->value);
    }
}
