<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktMitraBisnisPembelianPenjualan;

/**
 * AktMitraBisnisPembelianPenjualanSearch represents the model behind the search form of `backend\models\AktMitraBisnisPembelianPenjualan`.
 */
class AktMitraBisnisPembelianPenjualanSearch extends AktMitraBisnisPembelianPenjualan
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mitra_bisnis_pembelian_penjualan', 'id_mitra_bisnis', 'id_mata_uang', 'termin_pembelian', 'tempo_pembelian', 'termin_penjualan', 'tempo_penjualan', 'id_akun_hutang', 'id_akun_piutang'], 'integer'],
            [['batas_hutang', 'batas_frekuensi_hutang', 'batas_piutang', 'batas_frekuensi_piutang'], 'safe'],
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
        $query = AktMitraBisnisPembelianPenjualan::find();

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
            'id_mitra_bisnis_pembelian_penjualan' => $this->id_mitra_bisnis_pembelian_penjualan,
            'id_mitra_bisnis' => $this->id_mitra_bisnis,
            'id_mata_uang' => $this->id_mata_uang,
            'termin_pembelian' => $this->termin_pembelian,
            'tempo_pembelian' => $this->tempo_pembelian,
            'termin_penjualan' => $this->termin_penjualan,
            'tempo_penjualan' => $this->tempo_penjualan,
            'id_akun_hutang' => $this->id_akun_hutang,
            'id_akun_piutang' => $this->id_akun_piutang,
        ]);

        $query->andFilterWhere(['like', 'batas_hutang', $this->batas_hutang])
            ->andFilterWhere(['like', 'batas_frekuensi_hutang', $this->batas_frekuensi_hutang])
            ->andFilterWhere(['like', 'batas_piutang', $this->batas_piutang])
            ->andFilterWhere(['like', 'batas_frekuensi_piutang', $this->batas_frekuensi_piutang]);

        return $dataProvider;
    }
}
