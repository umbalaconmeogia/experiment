
## Generate parameter like modelName[attributeName]=value in GET url

Use Html::getInputName() to generate parameter name.

Example
```php
<?= Html::a('Show', ['index', Html::getInputName($model, 'month') => $month], ['class' => 'btn btn-primary']) ?>
```
will generate ```<a href="index?ModelClass[month]=1" class="btn btn-primary">Show</a>``` (assum $model is an object of ModelClass).

## Html input to select a month

* Use <input type="month"> to generate the input element.
* The value of the input should be in type of *yyyy-mm*
* Usually, the month data saved in the database in type of date *yyyy-mm-dd*, so it is needed to convert between data in DB and the value of form input element.

Practice
* In search model (which receive data from the form in type of yyyy-mm), convert month data to yyyy-mm-01 before comparing.
* In view form (which model contains data in the type of yyyy-mm-01), convert month data to yyyy-mm to set to input field.

Sample
Search model
```php
public function search($params)
{
        // some code here
        
        // Convert from yyyy-mm (input from form) to yyyy-mm-01
        // TODO: I feel that this is nogood to put this code here.
        if (!$this->month) {
            $this->month = HDateTime::now()->firstDayOfMonth()->toDateStr();
        if (substr_count($this->month, '-') == 1) {
            $this->month = "{$this->month}-01";
        }
        
        // some code here
}
```
Search form in view file:
```php
<?php $form = ActiveForm::begin([
    'action' => ['index'],
    'method' => 'get',
]); ?>
<div class="row">
    <div class="col-md-6">
        <?php echo $form->field($searchModel, 'month')->input('month', [
            // Convert from yyyy-mm-dd to yyyy-mm
            'value' => HDateTime::createFromString($searchModel->month)->toString('Y-m'),
        ])->label(false) ?>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
```
