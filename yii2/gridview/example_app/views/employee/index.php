<?php

use app\models\Employee;
use app\models\EmployeeInfo;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EmployeeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Employees');
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'yii\grid\SerialColumn'],

    'name',
    [
        'attribute' => 'departmentName',
        'value' => 'department.name',
    ],

];
foreach (EmployeeInfo::codes() as $code){
    $columns[] = [
        'label' => Yii::t('app', $code),
        'value' => function(Employee $model) use ($code) {
            return $model->employeeInfoHashCode[$code]->valueStr;
        },
        'format' => 'ntext',
        'filter' => '<input type="text" class="form-control" name="EmployeeSearch[employeeInfoValues][' . $code . ']">',
        'contentOptions' => ['class' => 'text-nowrap'],
    ];
}
$columns[] = [
    'class' => 'yii\grid\ActionColumn',
    'contentOptions' => ['class' => 'text-nowrap'],
];

?>
<div class="employee-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Employee'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
    ]); ?>


</div>
