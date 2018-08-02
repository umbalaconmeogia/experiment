<?php

use app\models\Company;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Employee;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="employee-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_id')->widget(Select2::classname(), [
        'data' => Company::hashModels(Company::findAllNotDeleted(), 'id', 'name'),
        'options' => ['placeholder' => 'Select company...'],
            'pluginOptions' => [
                'allowClear' => true
            ],
    ]);
    ?>

    <?= $form->field($model, 'gender')->radioList(Employee::genderOptionArr()) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
