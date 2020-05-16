# Data format in yii2

## Use `Yii::$app->formatter`

* As integer
  ```php
  echo Yii::$app->formatter->asInteger($num);
  // Show 123,456,789
  ```
* As decimal
  ```php
  echo Yii::$app->formatter->asDecimal($num, 2);
  // Show 123,456,789.03
  ```

## In GridView

Define in column definition.

* Shortcut format "attribute:format:label"
  ```php
    'columns' => [
        'id',
        'amount:currency:Total Amount',
        'created_at:datetime',
    ]
  ```
* Use `format` attribute.
  ```php
    'columns' => [
        ['class' => SerialColumn::className()],
        [
            'attribute' => 'name',
            'format' => 'text',
            'label' => 'Name',
        ],
        [
            'attribute' => 'birth_date',
            'format' => ['date', 'php:Y-m-d'],
        ],
        [
            'header' => 'View',
            'format' => 'raw',
            'value' => function($model) {
                return Html::a($model->name, ['view', 'id' => $model->id]);
            },
        ],
    ]
  ```