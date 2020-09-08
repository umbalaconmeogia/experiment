# yii2 Tips

## Active Record

### Query

* Use joinWith to add another table in condition
  ```php
  $query = Salary::find()->joinWith('employee.people');
  $dataProvider->query->andWhere('people.birthday > 1980');
  ```
* Not paging
  ```php
  $dataProvider = new ActiveDataProvider([
    'query' => $query,
    'pagination' => FALSE,
  ]);
  ```
* IS NULL
  ```php
  $query->andWhere('work_end_date IS NULL');
  ```
* NOT IN
  ```php
  $query->andWhere(['NOT IN', 'employee_group', [
      Employee::EMPLOYEE_SE,
      Employee::EMPLOYEE_PARTTIME,
      Employee::EMPLOYEE_SUPERVISOR,
  ]]);
  ```

## View

### Change favicon by another image (not default favicon.ico)

In layout file, add to *head* part
```html
<link rel="shortcut icon" type="image/png" href="favicon.png"/>
```

### Posting data via link

```php
<?= Html::a('Text',
    ['/controller/action'], [
    'data-method' => 'POST',
    'data-params' => [
        'param1' => 1,
        'param2' => 2,
    ],
]) ?>
```
Ref: http://www.prettyscripts.com/code/php/yii2-posting-data-via-link/

## Config

### Log

To export log to app.log and sql.log separately
```php
'log' => [
    'targets' => [
        [
            'class' => 'yii\log\FileTarget',
            'exportInterval' => 1,
            'levels' => ['error', 'warning', 'info', 'trace'],
            'logVars' => [],
            'except' => ['yii\db\*'],
        ],
        [
            'class' => 'yii\log\FileTarget',
            'levels' => ['error', 'warning', 'info', 'trace'],
            'logVars' => [],
            'categories' => ['yii\db\*'],
            'logFile' => '@app/runtime/logs/sql.log',
        ],
    ],
],
```

## Module

## Create command in module

Change the yii\base\Module::$controllerNamespace to name space of command in module.

One way to achieve that is to test the instance type of the Yii application in the module's init() method:
```php
public function init()
{
    parent::init();
    if (Yii::$app instanceof \yii\console\Application) {
        $this->controllerNamespace = 'app\modules\forum\commands';
    }
}
```

Ref: https://www.yiiframework.com/doc/guide/2.0/en/structure-modules#console-commands-in-modules