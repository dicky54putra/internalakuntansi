<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\JurnalTransaksiDetail;

/**
 * JurnalTransaksiDetailSearch represents the model behind the search form of `backend\models\JurnalTransaksiDetail`.
 */
class JurnalTransaksiDetailSearch extends JurnalTransaksiDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_jurnal_transaksi_detail', 'id_jurnal_transaksi', 'id_akun'], 'integer'],
            [['tipe'], 'safe'],
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
        $query = JurnalTransaksiDetail::find();

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
            'id_jurnal_transaksi_detail' => $this->id_jurnal_transaksi_detail,
            'id_jurnal_transaksi' => $this->id_jurnal_transaksi,
            'id_akun' => $this->id_akun,
        ]);

        $query->andFilterWhere(['like', 'tipe', $this->tipe]);

        return $dataProvider;
    }
}
