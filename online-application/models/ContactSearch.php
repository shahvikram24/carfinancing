<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Application;

/**
 * ApplicationSearch represents the model behind the search form about `app\models\Application`.
 */
class ContactSearch extends Application
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vehicle_type_id', 'month_of_birth', 'day_of_birth', 'year_of_birth', 'province_id', 'residence_years', 'years_on_job', 'months_on_job'], 'integer'],
            [['first_name', 'last_name', 'email', 'phone', 'address', 'postal_code', 'city', 'rent_or_own', 'monthly_payment', 'company_name', 'job_title', 'work_phone', 'monthly_income', 'sin_number'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Application::find();

        $query->joinWith(['vehicleType', 'province']);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'vehicle_type_id' => $this->vehicle_type_id,
            'month_of_birth' => $this->month_of_birth,
            'day_of_birth' => $this->day_of_birth,
            'year_of_birth' => $this->year_of_birth,
            'province_id' => $this->province_id,
            'residence_years' => $this->residence_years,
            'years_on_job' => $this->years_on_job,
            'months_on_job' => $this->months_on_job,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'postal_code', $this->postal_code])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'rent_or_own', $this->rent_or_own])
            ->andFilterWhere(['like', 'monthly_payment', $this->monthly_payment])
            ->andFilterWhere(['like', 'company_name', $this->company_name])
            ->andFilterWhere(['like', 'job_title', $this->job_title])
            ->andFilterWhere(['like', 'work_phone', $this->work_phone])
            ->andFilterWhere(['like', 'monthly_income', $this->monthly_income])
            ->andFilterWhere(['like', 'sin_number', $this->sin_number]);

        return $dataProvider;
    }
}
