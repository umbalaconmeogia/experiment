<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

	<div class="row">
		<div class="col-md-6">
			<?php $form = ActiveForm::begin(); ?>

			<?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>

			<?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

			<div class="form-group">
				<?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
			</div>

			<?php ActiveForm::end(); ?>
		</div>
		<div class="col-md-6">
			<?php if ($model->id) {
				echo \yii2mod\comments\widgets\Comment::widget([
					'model' => $model,
					'commentView' => '@app/views/common/comment/index' // path to your template
				]);
			}?>
		</div>
	</div>
</div>
