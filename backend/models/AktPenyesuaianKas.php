<?php

namespace backend\models;

use Yii;
use backend\models\AktMitraBisnis;

/**
 * This is the model class for table "akt_penyesuaian_kas".
 *
 * @property int $id_penyesuaian_kas
 * @property string $no_transaksi
 * @property string $tanggal
 * @property int $id_akun
 * @property int $id_mitra_bisnis
 * @property string $no_referensi
 * @property int $id_kas_bank
 * @property int $id_mata_uang
 * @property double $jumlah
 * @property string $keterangan
 */
class AktPenyesuaianKas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'akt_penyesuaian_kas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['no_transaksi', 'tanggal', 'id_akun', 'tipe', 'id_kas_bank', 'id_mata_uang', 'jumlah'], 'required'],
            [['tanggal', 'id_akun', 'jumlah'], 'safe'],
            [['id_kas_bank', 'id_mata_uang', 'tipe'], 'integer'],
            [['keterangan'], 'string'],
            [['no_transaksi', 'no_referensi'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_penyesuaian_kas' => 'Id Penyesuaian Kas',
            'no_transaksi' => 'No Transaksi',
            'tanggal' => 'Tanggal',
            'id_akun' => 'Nama Akun',
            'tipe' => 'Tipe',
            'no_referensi' => 'No Referensi',
            'id_kas_bank' => 'Kas/Bank',
            'id_mata_uang' => 'Mata Uang',
            'jumlah' => 'Jumlah',
            'keterangan' => 'Keterangan',
        ];
    }
    public function getakun()
    {
        return $this->hasOne(AktAkun::className(), ['id_akun' => 'id_akun']);
    }
    public function getmata_uang()
    {
        return $this->hasOne(AktMataUang::className(), ['id_mata_uang' => 'id_mata_uang']);
    }

    public function getkas_bank()
    {
        return $this->hasOne(AktKasBank::className(), ['id_kas_bank' => 'id_kas_bank']);
    }


    public static function createJurnalUmum($model, $no_transaksi)
    {

        #jurnal_umum_kode
        $no_jurnal_umum = AktJurnalUmum::getKodeJurnalUmum();

        # create jurnal umum

        $model_jurnal_umum = new AktJurnalUmum();
        $model_jurnal_umum->no_jurnal_umum = $no_jurnal_umum;
        $model_jurnal_umum->tanggal = date('Y-m-d');
        $model_jurnal_umum->tipe = 2;
        $model_jurnal_umum->keterangan = 'Penyesuain Kas : ' . $no_transaksi;
        $model_jurnal_umum->save(FALSE);

        # end create jurnal umum

        $model_jurnal_umum_detail = new AktJurnalUmumDetail();
        $model_jurnal_umum_detail->id_jurnal_umum = $model_jurnal_umum->id_jurnal_umum;
        $model_jurnal_umum_detail->id_akun = $model->id_akun;
        $model_jurnal_umum_detail->debit = $model->jumlah;
        $model_jurnal_umum_detail->kredit = 0;
        $model_jurnal_umum_detail->keterangan = 'Penyesuaian Kas : ' .  $no_transaksi;
        $model_jurnal_umum_detail->save(false);

        $model_jurnal_umum_detail2 = new AktJurnalUmumDetail();
        $model_jurnal_umum_detail2->id_jurnal_umum = $model_jurnal_umum->id_jurnal_umum;
        $model_jurnal_umum_detail2->id_akun = 1;
        $model_jurnal_umum_detail2->kredit = $model->jumlah;
        $model_jurnal_umum_detail2->debit = 0;
        $model_jurnal_umum_detail2->keterangan = 'Penyesuaian Kas : ' .  $no_transaksi;
        $model_jurnal_umum_detail2->save(false);

        $model_akun = AktAkun::find()->where(['id_akun' => $model->id_akun])->one();
        $nama_akun_lower = strtolower($model_akun->nama_akun);

        $model_akt_kas_bank = AktKasBank::find()->where(['id_kas_bank' => $model->id_kas_bank])->one();

        if ($model->tipe == 1) {
            $model_akun->saldo_akun = $model_akun->saldo_akun + $model->jumlah;
            $model_akt_kas_bank->saldo = $model_akt_kas_bank->saldo + $model->jumlah;
        } else if ($model->tipe == 2) {
            $model_akun->saldo_akun = $model_akun->saldo_akun - $model->jumlah;
            $model_akt_kas_bank->saldo = $model_akt_kas_bank->saldo - $model->jumlah;
        }

        $model_akun->save(false);
        $model_akt_kas_bank->save(false);


        $history_transaksi_kas = new AktHistoryTransaksi();
        $history_transaksi_kas->nama_tabel = 'akt_kas_bank';
        $history_transaksi_kas->id_tabel = $model->id_kas_bank;
        $history_transaksi_kas->id_jurnal_umum = $model_jurnal_umum_detail2->id_jurnal_umum_detail;
        $history_transaksi_kas->save(false);


        $history_transaksi = new AktHistoryTransaksi();
        $history_transaksi->nama_tabel = 'akt_penyesuaian_kas';
        $history_transaksi->id_tabel = $model->id_penyesuaian_kas;
        $history_transaksi->id_jurnal_umum = $model_jurnal_umum->id_jurnal_umum;
        $history_transaksi->save(false);
    }

    public static function deleteJurnalUmum($model, $id)
    {
        $history_transaksi_count = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_penyesuaian_kas'])->count();
        if ($history_transaksi_count > 0) {

            $history_transaksi = AktHistoryTransaksi::find()->where(['id_tabel' => $id])->andWhere(['nama_tabel' => 'akt_penyesuaian_kas'])->one();
            $jurnal_umum = AktJurnalUmum::find()->where(['id_jurnal_umum' => $history_transaksi['id_jurnal_umum']])->one();
            $jurnal_umum_detail = AktJurnalUmumDetail::find()->where(['id_jurnal_umum' => $jurnal_umum['id_jurnal_umum']])->all();

            foreach ($jurnal_umum_detail as $ju) {
                $akun = AktAkun::find()->where(['id_akun' => $ju->id_akun])->one();
                $akt_kas_bank = AktKasBank::find()->where(['id_kas_bank' => $model->id_kas_bank])->one();

                if (strtolower($akun->nama_akun) != 'kas') {

                    if ($model->tipe == 1) {
                        $akun->saldo_akun = $akun->saldo_akun - $model->jumlah;
                    } else if ($model->tipe == 2) {
                        $akun->saldo_akun = $akun->saldo_akun + $model->jumlah;
                    }
                } else if (strtolower($akun->nama_akun) == 'kas') {
                    $history_transaksi_kas = AktHistoryTransaksi::find()
                        ->where(['id_tabel' => $model->id_kas_bank])
                        ->andWhere(['nama_tabel' => 'akt_kas_bank'])
                        ->andWhere(['id_jurnal_umum' => $ju->id_jurnal_umum_detail])->one();

                    if ($model->tipe == 1) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo - $model->jumlah;
                    } else if ($model->tipe == 2) {
                        $akt_kas_bank->saldo = $akt_kas_bank->saldo + $model->jumlah;
                    }

                    $history_transaksi_kas->delete();
                }

                $akun->save(false);
                $akt_kas_bank->save(false);
                $ju->delete();
            }

            $history_transaksi->delete();
            $jurnal_umum->delete();
        }
    }
}
