<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPermintaanPembelian;

/**
 * AktPermintaanPembelianSearch represents the model behind the search form of `backend\models\AktPermintaanPembelian`.
 */
class AktPermintaanPembelianSearch extends AktPermintaanPembelian
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_permintaan_pembelian', 'id_pegawai', 'status', 'id_cabang', 'draft'], 'integer'],
            [['no_permintaan', 'tanggal', 'keterangan'], 'safe'],
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
        $query = AktPermintaanPembelian::find()->orderBy(['no_permintaan'=>SORT_DESC]);

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
            'id_permintaan_pembelian' => $this->id_permintaan_pembelian,
            'tanggal' => $this->tanggal,
            'id_pegawai' => $this->id_pegawai,
            'status' => $this->status,
            'id_cabang' => $this->id_cabang,
            'draft' => $this->draft,
        ]);

        $query->andFilterWhere(['like', 'no_permintaan', $this->no_permintaan])
            ->andFilterWhere(['like', 'keterangan', $this->keterangan]);

        return $dataProvider;
    }
}
