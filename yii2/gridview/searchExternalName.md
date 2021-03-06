# Search and sort for external join table attributes

In GridView that showing data of Department, we want to allow searching and sorting with department manager's name.

![Department list](images/DepartmentList.png)

## Add safe attribute $managerName to DepartmentSearch class.

```php
class DepartmentSearch extends Department
{
    public $managerName;

    public function rules()
    {
        return [
            [['managerName'], 'safe'],
            // Other stuff
        ];
    }
}
```

## Translation of additional attribute label

It's optional, but we may want provide i18n for `$managerName` attribute.

We can add it into `Department#attributeLabels()`,
but it is not good because Department does not know about attribute `managerName`.

The prefer way is to add it into `DepartmentSearch#attributeLabels()`.
We should also change the model class of the query from `Department` to `DepartmentSearch` (because GridView's DataColumn will find the label in the model of the query).

`DepartmentSearch#attributeLabels()` must return values set in `Department#attributeLabels()`, too.

```php
class DepartmentSearch extends Department
{
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'managerName' => Yii::t('app', 'Manager name'),
        ]);
    }

    public function search($params)
    {
        // Replace Department by DepartmentSearch
        $query = DepartmentSearch::find()->joinWith('manager mang');

        // other stuff
    }
}
```

## Add searching condition by `$managerName`.

```php
class DepartmentSearch extends Department
{
    public function search($params)
    {
        // Join with manager relation.
        $query = DepartmentSearch::find()->joinWith('manager mang');
        // Other stuff

        // Add searching condition by managerName
        $query->andFilterWhere(['like', 'mang.name', $this->managerName]);
        // Other stuff
    }

}
```

## Add sorting for `$managerName`

```php
class DepartmentSearch extends Department
{
    public function search($params)
    {
        // Other stuff
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // Other stuff
        ]);

        $dataProvider->sort->attributes['managerName'] = [
            'asc' => ['mang.name' => SORT_ASC],
            'desc' => ['mang.name' => SORT_DESC],
        ];
        // Other stuff
    }
}
```