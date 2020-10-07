<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktProduksiBom;

/**
 * AktProduksiBomSearch represents the model behind the search form of `backend\models\AktProduksiBom`.
 */
class AktProduksiBomSearch extends AktProduksiBom
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_produksi_bom' ,'id_bom'], 'integer'],
            [['tanggal', 'tipe', 'id_pegawai', 'id_customer', 'id_akun', 'no_produksi_bom'], 'safe'],
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
        $query = AktProduksiBom::find();
        $query->joinWith(['pegawai']);
        $query->joinWith(['mitra_bisnis']);
        $query->joinWith(['akun']);
        $query->joinWith(['bom']);
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
            'id_produksi_bom' => $this->id_produksi_bom,
            'no_produksi_bom' => $this->no_produksi_bom,
            'tanggal' => $this->tanggal,
            // 'id_pegawai' => $this->id_pegawai,
            // 'id_customer' => $this->id_customer,
            'id_bom' => $this->id_bom,
            // 'id_akun' => $this->id_akun,
        ]);

        $query->andFilterWhere(['like', 'tipe', $this->tipe])
        ->andFilterWhere(['like', 'akt_pegawai.nama_pegawai', $this->id_pegawai])
        ->andFilterWhere(['like', 'akt_akun.nama_akun', $this->id_akun])
        ->andFilterWhere(['like', 'akt_mitra_bisnis.nama_mitra_bisnis', $this->id_customer]);

        return $dataProvider;
    }
}
