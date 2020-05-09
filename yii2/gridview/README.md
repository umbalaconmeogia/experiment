# yii2 GridView tips

## Search for external join table attributes

In GridView that showing data of Department, we want to allow searching with department manager's name.

![Department list](images/DepartmentList.png)

* In DepartmentSearch, adding safe attribute $managerName, and add it to search condition.
  ```php
    class DepartmentSearch extends Department
    {
        public $managerName;

        public function rules()
        {
            return [
                [['managerName'], 'safe'],
                // Other attributes
            ];
        }

        public function search($params)
        {
            $query = Department::find()->joinWith('manager mang');
            // Other process

            $query->andFilterWhere(['like', 'mang.name', $this->managerName]);
            // Other process
        }

    }
  ```

## Sort for external attributes
  ```php
    class DepartmentSearch extends Department
    {
        public function search($params)
        {
            // Other process
            $dataProvider->sort->attributes['managerName'] = [
                // The tables are the ones our relation are configured to
                // in my case they are prefixed with "tbl_"
                'asc' => ['mang.name' => SORT_ASC],
                'desc' => ['mang.name' => SORT_DESC],
            ];
            // Other process
        }

    }
  ```

## Search for clustering external join table attributes

## Example code

Example code is put in `example_app` directory.

### Prequisite

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
