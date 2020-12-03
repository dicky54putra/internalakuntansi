<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\models\Log;

use backend\models\AktAkun;
use backend\models\AktKasBank;
use backend\models\Setting;
use backend\models\AktPenjualan;
use yii\helpers\ArrayHelper;
use backend\models\AktPembelian;
use backend\models\AktPembelianHartaTetap;
use backend\models\AktPembelianHartaTetapDetail;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error', 'popup'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'popup'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '@app/views/site/error.php',
            ],
        ];
    }

    public function actionPopup()
    {
        return $this->render('popup');
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $sum_omzet = Yii::$app->db->createCommand("SELECT SUM(total) FROM akt_penjualan WHERE akt_penjualan.status = 3 OR akt_penjualan.status = 4")->queryScalar();

        $saldo_kas = Yii::$app->db->createCommand("SELECT SUM(saldo) from akt_kas_bank")->queryScalar();
        if (!empty($saldo_kas)) {
            $saldo_kas = $saldo_kas;
        } else {
            $saldo_kas = 0;
        }
        $saldo_piutang = Yii::$app->db->createCommand("SELECT SUM(saldo_akun) as saldo FROM `akt_akun` WHERE nama_akun LIKE '%piutang%'")->queryScalar();
        // $saldo_hutang = Yii::$app->db->createCommand("SELECT SUM(saldo_akun) as saldo FROM `akt_akun` WHERE nama_akun LIKE '%hutang%'")->queryScalar();

        #perhitungan pembelian yang belum di bayar
        $saldo_hutang_pembelian_barang = 0;
        $queryAktPembelian = AktPembelian::find()->where(['!=', 'akt_pembelian.status', '1'])->andWhere(['!=', 'akt_pembelian.total', 0])->orderBy("id_pembelian desc")->all();
        foreach ($queryAktPembelian as $key => $value) {
            # code...
            $query = (new \yii\db\Query())->from('akt_pembayaran_biaya')->where(['id_pembelian' => $value->id_pembelian]);
            $sum_nominal = $query->sum('nominal');

            $kekurangan_pembayaran = 0;
            $total =  $value->total;

            $totalan_belum_dibayar = 0;
            if ($sum_nominal != 0) {
                $total = $value->total + $value->uang_muka;
                $total_belum_dibayar = $total - $sum_nominal;

                if ($sum_nominal > $total) {
                    $kelebihan = $sum_nominal - $total;
                    // return 'Kelebihan : ' . ribuan($kelebihan);
                }
                $a = ($total_belum_dibayar) . ' (1)';
                $totalan_belum_dibayar += $total_belum_dibayar;
                // echo $a;
            } else {
                $b = ($total) . ' (2)<br>';
                $totalan_belum_dibayar += $total;
                // echo $b;
            }

            $saldo_hutang_pembelian_barang += $totalan_belum_dibayar;
        }

        #perhitungan pembelian harta tetap
        $saldo_hutang_pembelian_harta_tetap = 0;
        $queryAktPembelianHartaTetap = AktPembelianHartaTetap::find()->where(['status' => '2'])->orderBy('id_pembelian_harta_tetap desc')->all();
        foreach ($queryAktPembelianHartaTetap as $key => $value) {
            # code...
            $query = (new \yii\db\Query())->from('akt_pembayaran_biaya_harta_tetap')->where(['id_pembelian_harta_tetap' => $value->id_pembelian_harta_tetap]);
            $sum_nominal = $query->sum('nominal');

            $kekurangan_pembayaran = 0;

            $total_ = AktPembelianHartaTetapDetail::find()->where(['id_pembelian_harta_tetap' => $value->id_pembelian_harta_tetap])->sum('harga');

            $total = 0;
            $totalan_belum_dibayar_pembelian_harta_tetap = 0;
            if ($sum_nominal != 0) {
                $total = $total_;
                $total_belum_dibayar = $total - $sum_nominal;

                if ($sum_nominal > $total) {
                    $kelebihan = $sum_nominal - $total;
                    // return 'Kelebihan : ' . ribuan($kelebihan);
                }
                $a = $total_belum_dibayar;
                $totalan_belum_dibayar_pembelian_harta_tetap += $a;
            } else {
                $b = $total_;
                $totalan_belum_dibayar_pembelian_harta_tetap += $b;
            }

            $saldo_hutang_pembelian_harta_tetap += $totalan_belum_dibayar_pembelian_harta_tetap;
        }

        $saldo_hutang = $saldo_hutang_pembelian_barang + $saldo_hutang_pembelian_harta_tetap;

        $month = date('m');
        $year = date('Y');


        $tanggal_labels = Setting::getTanggal('tanggal_penjualan', 'akt_penjualan');

        $penjualan = Yii::$app->db->createCommand("SELECT SUM(akt_penjualan_detail.qty) AS penjualan, akt_item.nama_item FROM `akt_penjualan_detail` LEFT JOIN akt_penjualan ON akt_penjualan.id_penjualan = akt_penjualan_detail.id_penjualan LEFT JOIN akt_item_stok ON akt_item_stok.id_item_stok = akt_penjualan_detail.id_item_stok LEFT JOIN akt_item ON akt_item.id_item = akt_item_stok.id_item WHERE MONTH(tanggal_penjualan) = '$month' AND YEAR(tanggal_penjualan) = '$year'  GROUP BY akt_item.id_item ORDER BY penjualan DESC LIMIT 5")->query();

        $sum_penjualan = Yii::$app->db->createCommand("SELECT SUM(akt_penjualan_detail.qty) AS penjualan FROM `akt_penjualan_detail` LEFT JOIN akt_penjualan ON akt_penjualan.id_penjualan = akt_penjualan_detail.id_penjualan WHERE MONTH(tanggal_penjualan) = '$month' AND YEAR(tanggal_penjualan) = '$year' ")->queryScalar();


        $akt_kas_bank = AktKasBank::find()
            ->select(['akt_kas_bank.*', 'akt_mata_uang.mata_uang'])
            ->leftJoin('akt_mata_uang', '`akt_mata_uang`.`id_mata_uang` = `akt_kas_bank`.`id_mata_uang`')
            ->asArray()
            ->all();


        return $this->render('index', [
            'akt_kas_bank' => $akt_kas_bank,
            'sum_penjualan' => $sum_penjualan,
            'penjualan' => $penjualan,
            'tanggal_label' => $tanggal_labels,
            'sum_omzet' => $sum_omzet,
            'saldo_kas' => $saldo_kas,
            'saldo_piutang' => $saldo_piutang,
            'saldo_hutang' => $saldo_hutang,
        ]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $input_log = new Log();
            $input_log->level = '0';
            $input_log->category = 'Login';
            $input_log->log_time = microtime('get_as_float');
            $input_log->prefix = Yii::$app->user->identity->nama;
            $input_log->message = 'Login';
            $input_log->save(false);

            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
}
