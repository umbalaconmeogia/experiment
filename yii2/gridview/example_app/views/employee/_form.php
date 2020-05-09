<?php

use app\models\Department;
use app\models\EmployeeInfo;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'department_id')->dropDownList(Department::allDepartmentOptionArr()) ?>

    <?= $form->field($model, 'employeeInfoValues[' . EmployeeInfo::CODE_BIRTH_DATE . ']')
        ->label(EmployeeInfo::codeLabel(EmployeeInfo::CODE_BIRTH_DATE))
        ->textInput(['type' => 'date']) ?>

    <?= $form->field($model, 'employeeInfoValues[' . EmployeeInfo::CODE_GENDER . ']')
        ->label(EmployeeInfo::codeLabel(EmployeeInfo::CODE_GENDER))
        ->radioList(EmployeeInfo::genderOptionArr()) ?>

    <?= $form->field($model, 'employeeInfoValues[' . EmployeeInfo::CODE_ADDRESS . ']')
        ->label(EmployeeInfo::codeLabel(EmployeeInfo::CODE_ADDRESS))
        ->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
