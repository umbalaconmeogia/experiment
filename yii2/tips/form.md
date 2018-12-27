
## Generate parameter like modelName[attributeName]=value in GET url

Use Html::getInputName() to generate parameter name.
Example
```php
<?= Html::a('Show', ['index', Html::getInputName($model, 'month') => $month], ['class' => 'btn btn-primary']) ?>
```
