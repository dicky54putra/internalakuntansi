<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\AktPengajuanBiaya;

/**
 * AktPengajuanBiayaSearch represents the model behind the search form of `backend\models\AktPengajuanBiaya`.
 */
class AktPengajuanBiayaSearch extends AktPengajuanBiaya
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pengajuan_biaya', 'approver1', 'approver2', 'approver3', 'status', 'sumber_dana', 'status_pembayaran'], 'integer'],
            [['nomor_pengajuan_biaya', 'tanggal_pengajuan', 'nomor_purchasing_order', 'nomor_kendaraan', 'volume', 'keterangan_pengajuan', 'jenis_bayar', 'dibayar_oleh', 'dibayar_kepada', 'alamat_dibayar_kepada', 'approver1_date', 'approver2_date', 'approver3_date', 'alasan_reject', 'tanggal_jatuh_tempo', 'dibuat_oleh'], 'safe'],
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
        $query = AktPengajuanBiaya::find();
        $query->joinWith("login");

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
            'id_pengajuan_biaya' => $this->id_pengajuan_biaya,
            'tanggal_pengajuan' => $this->tanggal_pengajuan,
            // 'dibuat_oleh' => $this->dibuat_oleh,
            'approver1' => $this->approver1,
            'approver2' => $this->approver2,
            'approver3' => $this->approver3,
            'approver1_date' => $this->approver1_date,
            'approver2_date' => $this->approver2_date,
            'approver3_date' => $this->approver3_date,
            'status' => $this->status,
            'tanggal_jatuh_tempo' => $this->tanggal_jatuh_tempo,
            'sumber_dana' => $this->sumber_dana,
            'status_pembayaran' => $this->status_pembayaran,
        ]);

        $query->andFilterWhere(['like', 'nomor_pengajuan_biaya', $this->nomor_pengajuan_biaya])
            ->andFilterWhere(['like', 'nomor_purchasing_order', $this->nomor_purchasing_order])
            ->andFilterWhere(['like', 'nomor_kendaraan', $this->nomor_kendaraan])
            ->andFilterWhere(['like', 'volume', $this->volume])
            ->andFilterWhere(['like', 'keterangan_pengajuan', $this->keterangan_pengajuan])
            ->andFilterWhere(['like', 'jenis_bayar', $this->jenis_bayar])
            ->andFilterWhere(['like', 'dibayar_oleh', $this->dibayar_oleh])
            ->andFilterWhere(['like', 'dibayar_kepada', $this->dibayar_kepada])
            ->andFilterWhere(['like', 'alamat_dibayar_kepada', $this->alamat_dibayar_kepada])
            ->andFilterWhere(['like', 'alasan_reject', $this->alasan_reject])
            ->andFilterWhere(['like', 'login.nama', $this->dibuat_oleh]);

        return $dataProvider;
    }
}
