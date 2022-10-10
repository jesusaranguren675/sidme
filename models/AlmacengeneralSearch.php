<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Almacengeneral;

/**
 * AlmacengeneralSearch represents the model behind the search form of `app\models\Almacengeneral`.
 */
class AlmacengeneralSearch extends Almacengeneral
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idal_gral', 'idmedi', 'cantidad'], 'integer'],
            [['descripcion'], 'safe'],
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Almacengeneral::find();

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
            'idal_gral' => $this->idal_gral,
            'idmedi' => $this->idmedi,
            'cantidad' => $this->cantidad,
        ]);

        $query->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
