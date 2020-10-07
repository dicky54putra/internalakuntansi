<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktProduksiManual;

/**
 * AktProduksiManualSearch represents the model behind the search form of `backend\models\AktProduksiManual`.
 */
class AktProduksiManualSearch extends AktProduksiManual
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_produksi_manual', 'tanggal', 'status_produksi'], 'integer'],
            [['no_produksi_manual', 'id_pegawai', 'id_customer', 'id_akun'], 'safe'],
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
        $query = AktProduksiManual::find();
        $query->joinWith(['mitra_bisnis']);
        $query->joinWith(['akun']);
        $query->joinWith(['pegawai']);
        $query->orderBy('id_produksi_manual desc');

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
            'id_produksi_manual' => $this->id_produksi_manual,
            'tanggal' => $this->tanggal,
            // 'id_pegawai' => $this->id_pegawai,
            // 'id_customer' => $this->id_customer,
            // 'id_akun' => $this->id_akun,
            'status_produksi' => $this->status_produksi,
        ]);

        $query->andFilterWhere(['like', 'no_produksi_manual', $this->no_produksi_manual])
            ->andFilterWhere(['like', 'akt_pegawai.nama_pegawai', $this->id_pegawai])
            ->andFilterWhere(['like', 'akt_akun.nama_akun', $this->id_akun])
            ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer]);

        return $dataProvider;
    }
}
