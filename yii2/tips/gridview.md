# Gridview

## Display options

### Make the table not overflow the panel
Set `style` for the table in GridView `options`.
Example
```php
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'options' => ['style' => 'width: 100%'],
    'filterModel' => $searchModel,
    'columns' => $columns,
]); ?>
```