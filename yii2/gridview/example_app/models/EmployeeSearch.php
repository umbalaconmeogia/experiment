<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Employee;
use Yii;

/**
 * EmployeeSearch represents the model behind the search form of `app\models\Employee`.
 */
class EmployeeSearch extends Employee
{
    public $departmentName;

    /**
     * Set searching pagination.
     * * If NULL, then use DataProvider default value.
     * * If FALSE, then get all record without pagination.
     * * Otherwise, get number of records equals to specified value.
     * @var int Set pagination.
     */
    public $pagination = NULL;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'department_id'], 'integer'],
            [['name'], 'safe'],
            [['departmentName'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'departmentName' => Yii::t('app', 'Department name'),
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = EmployeeSearch::find()->joinWith('department')->with('employeeInfos');

        // Join with EmployeeInfo horizontally.
        $infoCodes = EmployeeInfo::codes();
        foreach ($infoCodes as $code) {
            $query->leftJoin("employee_info $code", "{$code}.employee_id = employee.id AND {$code}.code = :code", ['code' => $code]);
        }

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if ($this->pagination !== NULL) {
            $dataProvider->pagination = $this->pagination;
        }

        $dataProvider->sort->attributes['departmentName'] = [
            // The tables are the ones our relation are configured to
            // in my case they are prefixed with "tbl_"
            'asc' => ['department.name' => SORT_ASC],
            'desc' => ['department.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'department_id' => $this->department_id,
        ]);

        $query->andFilterWhere(['like', 'employee.name', $this->name]);
        $query->andFilterWhere(['like', 'department.name', $this->departmentName]);

        // Add search condition of EmployeeInfo
        foreach ($infoCodes as $code) {
            if (isset($this->employeeInfoValues[$code])) {
                $query->andFilterWhere(['like', "{$code}.value", $this->employeeInfoValues[$code]]);
            }
        }

        return $dataProvider;
    }
}
