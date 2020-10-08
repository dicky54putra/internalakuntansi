<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPenjualanPengiriman;

/**
 * AktPenjualanPengirimanSearch represents the model behind the search form of `backend\models\AktPenjualanPengiriman`.
 */
class AktPenjualanPengirimanSearch extends AktPenjualanPengiriman
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_penjualan_pengiriman', 'id_penjualan'], 'integer'],
            [['no_pengiriman', 'tanggal_pengiriman', 'pengantar', 'keterangan_pengantar', 'foto_resi', 'penerima', 'keterangan_penerima', 'id_mitra_bisnis_alamat'], 'safe'],
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
        $query = AktPenjualanPengiriman::find();
        $query->joinWith("mitra_bisnis_alamat");

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
            'id_penjualan_pengiriman' => $this->id_penjualan_pengiriman,
            'tanggal_pengiriman' => $this->tanggal_pengiriman,
            'id_penjualan' => $this->id_penjualan,
            // 'id_mitra_bisnis_alamat' => $this->id_mitra_bisnis_alamat,
        ]);

        $query->andFilterWhere(['like', 'no_pengiriman', $this->no_pengiriman])
            ->andFilterWhere(['like', 'pengantar', $this->pengantar])
            ->andFilterWhere(['like', 'keterangan_pengantar', $this->keterangan_pengantar])
            ->andFilterWhere(['like', 'foto_resi', $this->foto_resi])
            ->andFilterWhere(['like', 'penerima', $this->penerima])
            ->andFilterWhere(['like', 'keterangan_penerima', $this->keterangan_penerima])
            ->andFilterWhere(['like', 'mitra_bisnis_alamat.keterangan_alamat', $this->id_mitra_bisnis_alamat]);

        return $dataProvider;
    }
}
