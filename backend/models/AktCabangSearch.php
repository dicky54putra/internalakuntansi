<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktCabang;

/**
 * AktCabangSearch represents the model behind the search form of `backend\models\AktCabang`.
 */
class AktCabangSearch extends AktCabang
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_cabang', 'id_customer'], 'integer'],
            [['kode_cabang', 'nama_cabang', 'nama_cabang_perusahaan', 'alamat', 'telp', 'fax', 'npwp', 'pkp'], 'safe'],
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
        $query = AktCabang::find();

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
            'id_cabang' => $this->id_cabang,
            'id_customer' => $this->id_customer,
            // 'id_foto' => $this->id_foto,
        ]);

        $query->andFilterWhere(['like', 'kode_cabang', $this->kode_cabang])
            ->andFilterWhere(['like', 'nama_cabang', $this->nama_cabang])
            ->andFilterWhere(['like', 'nama_cabang_perusahaan', $this->nama_cabang_perusahaan])
            ->andFilterWhere(['like', 'alamat', $this->alamat])
            ->andFilterWhere(['like', 'telp', $this->telp])
            ->andFilterWhere(['like', 'fax', $this->fax])
            ->andFilterWhere(['like', 'npwp', $this->npwp])
            ->andFilterWhere(['like', 'pkp', $this->pkp]);

        return $dataProvider;
    }
}
