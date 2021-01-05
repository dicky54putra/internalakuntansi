<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktMitraBisnis;

/**
 * AktMitraBisnisSearch represents the model behind the search form of `backend\models\AktMitraBisnis`.
 */
class AktMitraBisnisSearch extends AktMitraBisnis
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_mitra_bisnis', 'tipe_mitra_bisnis', 'id_gmb_satu', 'id_gmb_dua', 'id_gmb_tiga', 'id_level_harga', 'id_sales', 'status_mitra_bisnis'], 'integer'],
            [['kode_mitra_bisnis', 'deskripsi_mitra_bisnis', 'nama_mitra_bisnis', 'pemilik_bisnis'], 'safe'],
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
        $query = AktMitraBisnis::find();
        $query->joinWith(['sales']);
        $query->joinWith(['level_harga']);
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
            'id_mitra_bisnis' => $this->id_mitra_bisnis,
            'tipe_mitra_bisnis' => $this->tipe_mitra_bisnis,
            'id_gmb_satu' => $this->id_gmb_satu,
            'id_gmb_dua' => $this->id_gmb_dua,
            'id_gmb_tiga' => $this->id_gmb_tiga,
            'id_level_harga' => $this->id_level_harga,
            'id_sales' => $this->id_sales,
            'status_mitra_bisnis' => $this->status_mitra_bisnis,
        ]);

        $query->andFilterWhere(['like', 'kode_mitra_bisnis', $this->kode_mitra_bisnis])
            ->andFilterWhere(['like', 'deskripsi_mitra_bisnis', $this->deskripsi_mitra_bisnis])
            ->andFilterWhere(['like', 'pemilik_bisnis', $this->pemilik_bisnis])
            ->andFilterWhere(['like', 'nama_mitra_bisnis', $this->nama_mitra_bisnis]);

        return $dataProvider;
    }
}
