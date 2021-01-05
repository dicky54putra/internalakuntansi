<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\JurnalTransaksi;

/**
 * JurnalTransaksiSearch represents the model behind the search form of `backend\models\JurnalTransaksi`.
 */
class JurnalTransaksiSearch extends JurnalTransaksi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_jurnal_transaksi'], 'integer'],
            [['nama_transaksi'], 'safe'],
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
        $query = JurnalTransaksi::find();

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
            'id_jurnal_transaksi' => $this->id_jurnal_transaksi,
        ]);

        $query->andFilterWhere(['like', 'nama_transaksi', $this->nama_transaksi]);

        return $dataProvider;
    }
}
