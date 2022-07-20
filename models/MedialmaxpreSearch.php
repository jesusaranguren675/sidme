<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Medialmaxpre;

/**
 * MedialmaxpreSearch represents the model behind the search form of `app\models\Medialmaxpre`.
 */
class MedialmaxpreSearch extends Medialmaxpre
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_medi_alma_x_pre', 'id_medicamento_almacen', 'id_presentacion'], 'integer'],
            [['stock'], 'number'],
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
        $query = Medialmaxpre::find();

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
            'id_medi_alma_x_pre' => $this->id_medi_alma_x_pre,
            'id_medicamento_almacen' => $this->id_medicamento_almacen,
            'id_presentacion' => $this->id_presentacion,
            'stock' => $this->stock,
        ]);

        return $dataProvider;
    }
}
