# yii2 GridView tips

## Search and sort for external join table attributes

See [document here](searchExternalName.md)

## Search for clustering external join table attributes

See [document here](searchClustering.md)

## Set default filter

To set default filter value for GridView (filter set if nothing is specified), set it in controller action.

In the example below, Employee name is filter by "Tomy" by default.
If name is input in GridView by user, then default filter value is ignored.
```php
public function actionIndex()
{
    $searchModel = new EmployeeSearch();
    $searchModel->name = 'Tomy';
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}
```

## Set pagination in searching model

In searching model, add `$pagination` attribute to set pagination searching parameter.
In controller/action (for example), `actionIndex()`, control the pagination.
Example
```php
public function actionIndex()
{
    $searchModel = new EmployeeSearch();
    $searchModel->pagination = FALSE; // For no pagination, then get all record.
    $searchModel->pagination = NULL; // Get default pagination (equals to 20).
    $searchModel->paginiation = 50; // Get 50 records per page.
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider,
    ]);
}
```

## Example code

Example code is put in `example_app` directory.
It includes sample data stored in sqlite.

This example code is deveoped based on yii-basic-app-2.0.35 template.

### Installation

To install dependencies
```shell
composer install
```

### DB design

Database structure
![ERD](images/GridViewExample.png)

Example of data
![Data Sample](images/GridViewExampleData.png)

## Display options

### Make the table not overflow the panel

When there are many columns, the table of GridView may over the screen width. To make it fit in screen width, set `style` for the table in GridView `options`.
Example
```php
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['style' => 'width: 100%'],
    'filterModel' => $searchModel,
    'columns' => $columns,
]); ?>
```

### Make ActionColumn buttons to be opened in new tab (window)

Use ActionColumn *buttonOptions* attribute.
```php
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['style' => 'width: 100%'],
    'filterModel' => $searchModel,
    'columns' => [
        // Other column definition.

        // ActionColumn
        [
            'class' => 'yii\grid\ActionColumn',
            'buttonOptions' => [
                'target' => '_blank',
            ],
        ],
    ],
]); ?>
```