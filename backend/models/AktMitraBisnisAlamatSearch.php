<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktMitraBisnisAlamat;

/**
 * AktMitraBisnisAlamatSearch represents the model behind the search form of `backend\models\AktMitraBisnisAlamat`.
 */
class AktMitraBisnisAlamatSearch extends AktMitraBisnisAlamat
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mitra_bisnis_alamat', 'id_mitra_bisnis', 'id_kota', 'alamat_pengiriman_penagihan'], 'integer'],
            [['keterangan_alamat', 'alamat_lengkap', 'telephone', 'fax', 'kode_pos'], 'safe'],
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
        $query = AktMitraBisnisAlamat::find();

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
            'id_mitra_bisnis_alamat' => $this->id_mitra_bisnis_alamat,
            'id_mitra_bisnis' => $this->id_mitra_bisnis,
            'id_kota' => $this->id_kota,
            'alamat_pengiriman_penagihan' => $this->alamat_pengiriman_penagihan,
        ]);

        $query->andFilterWhere(['like', 'keterangan_alamat', $this->keterangan_alamat])
            ->andFilterWhere(['like', 'alamat_lengkap', $this->alamat_lengkap])
            ->andFilterWhere(['like', 'telephone', $this->telephone])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'kode_pos', $this->kode_pos]);

        return $dataProvider;
    }
}
