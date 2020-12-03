<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktReturPembelian;

/**
 * AktReturPembelianSearch represents the model behind the search form of `backend\models\AktReturPembelian`.
 */
class AktReturPembelianSearch extends AktReturPembelian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_retur_pembelian',  'status_retur'], 'integer'],
            [['no_retur_pembelian', 'tanggal_retur_pembelian', 'id_pembelian'], 'safe'],
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
        $query = AktReturPembelian::find()->orderBy(['no_retur_pembelian' => SORT_DESC]);

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

        if (!empty($this->tanggal_retur_pembelian)) {
            $query->andFilterWhere(["date_format(tanggal_retur_pembelian, '%d-%m-%Y')" => $this->tanggal_retur_pembelian]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_retur_pembelian' => $this->id_retur_pembelian,
            // 'tanggal_retur_pembelian' => $this->tanggal_retur_pembelian,
            'id_pembelian' => $this->id_pembelian,
            'status_retur' => $this->status_retur,
        ]);

        $query->andFilterWhere(['like', 'no_retur_pembelian', $this->no_retur_pembelian]);

        return $dataProvider;
    }
}
