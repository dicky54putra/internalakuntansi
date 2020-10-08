<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPengajuanBiayaDetail;

/**
 * AktPengajuanBiayaDetailSearch represents the model behind the search form of `backend\models\AktPengajuanBiayaDetail`.
 */
class AktPengajuanBiayaDetailSearch extends AktPengajuanBiayaDetail
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pengajuan_biaya_detail', 'id_pengajuan_biaya', 'id_akun', 'debit', 'kredit'], 'integer'],
            [['kode_rekening', 'nama_pengajuan'], 'safe'],
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
        $query = AktPengajuanBiayaDetail::find();

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
            'id_pengajuan_biaya_detail' => $this->id_pengajuan_biaya_detail,
            'id_pengajuan_biaya' => $this->id_pengajuan_biaya,
            'id_akun' => $this->id_akun,
            'debit' => $this->debit,
            'kredit' => $this->kredit,
        ]);

        $query->andFilterWhere(['like', 'kode_rekening', $this->kode_rekening])
            ->andFilterWhere(['like', 'nama_pengajuan', $this->nama_pengajuan]);

        return $dataProvider;
    }
}
