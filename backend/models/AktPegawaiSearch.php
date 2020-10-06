<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPegawai;

/**
 * AktPegawaiSearch represents the model behind the search form of `backend\models\AktPegawai`.
 */
class AktPegawaiSearch extends AktPegawai
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pegawai', 'id_kota', 'status_aktif'], 'integer'],
            [['kode_pegawai', 'nama_pegawai', 'alamat', 'kode_pos', 'telepon', 'handphone', 'email'], 'safe'],
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
        $query = AktPegawai::find();

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
            'id_pegawai' => $this->id_pegawai,
            'id_kota' => $this->id_kota,
            // 'kode_pos' => $this->kode_pos,
            // 'telepon' => $this->telepon,
            // 'handphone' => $this->handphone,
            'status_aktif' => $this->status_aktif,
        ]);

        $query->andFilterWhere(['like', 'kode_pegawai', $this->kode_pegawai])
            ->andFilterWhere(['like', 'nama_pegawai', $this->nama_pegawai])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
             ->andFilterWhere(['like', 'kode_pos', $this->kode_pos])
              ->andFilterWhere(['like', 'telepon', $this->telepon])
               ->andFilterWhere(['like', 'handphone', $this->handphone])
            ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
