# Kartick widget sample

## SwitchInput

### Reverse the ON/OFF value of

Normally, the uncheck value (OFF) is 0, check value (ON) is 1.
To use value in reverse order (for example, 1 for ON (allowing edit), 0 for OFF (fixed data, not allow editing)), set `value` and `uncheck` options.

```php
<?php
    $form = ActiveForm::begin([
        'action' => ['update', 'id' => $model->id],
    ]);

    echo Html::hiddenInput('callbackUrl', Url::current());
    echo $form->field($model, 'adjust_status')->label(false)
    ->widget(SwitchInput::classname(), [
        'options' => [
            'value' => 0,
            'uncheck' => 1,
        ],
        'pluginEvents' => [
            "switchChange.bootstrapSwitch" => "function() { this.form.submit(); }",
        ]
    ]);

    ActiveForm::end();
?>
```

## Kartik Gridview

### Overview
An enhance extension of yii\grid\GridView.

* Demo page: http://demos.krajee.com/grid</li>
* Github: https://github.com/kartik-v/yii2-grid</li>

If a column in kartik\grid\GridView is specified using attribute 'class', it should use \kartik\grid\XXXColumn instead of \yii\grid\XXXColumn (for example \kartik\grid\SerialColumn or \kartik\grid\ActionColumn, because the kartik GridView will call some new functions from the column class.

### Make header floated for vertical long table

Set Grid option 'floatHeader' => true
```php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'pjax' => true,
    'hover' => true,
    'floatHeader' => true,
    'columns' => $gridColumns,
    'showPageSummary' => true,
]);
```

### Hover when move mouse over a row

yii\grid\GridView does not support hover action. Use kartik\grid\GridView and set <code>'hover' => true</code>

## Use ArrayDataProvider

* If you have an array of model objects or array of array and want to display it on GridView, use ArrayDataProvider.
* The different between array of model objects and array of array is the way you access to model elements ($model->attributeName or $model['attributeName']).
* Must set 'key' attribute when create ArrayDataProvider (at least, to use kartik-v/yii2-editable)
