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