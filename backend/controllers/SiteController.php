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
use backend\models\AktPenjualan;
use yii\helpers\ArrayHelper;

use backend\models\AktPembelian;
use backend\models\AktPembelianHartaTetap;
use backend\models\AktPembelianHartaTetapDetail;
use backend\models\Setting;

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


        $month = date('m');
        $year = date('Y');


        $sum_omzet = Yii::$app->db->createCommand("SELECT SUM(total + uang_muka) as total FROM akt_penjualan WHERE akt_penjualan.status != 5 AND akt_penjualan.status != 1 AND MONTH(tanggal_penjualan) = '$month'")->queryScalar();

        $saldo_kas = Yii::$app->db->createCommand("SELECT SUM(saldo) from akt_kas_bank")->queryScalar();
        if (!empty($saldo_kas)) {
            $saldo_kas = $saldo_kas;
        } else {
            $saldo_kas = 0;
        }

        $saldo_hutang_pembelian = Yii::$app->db->createCommand("SELECT SUM(total - IF(akt_pembayaran_biaya.nominal IS NULL, 0, akt_pembayaran_biaya.nominal) + IF(akt_pembayaran_biaya.nominal IS NULL, 0, uang_muka)) as total
        FROM akt_pembelian 
        LEFT JOIN akt_pembayaran_biaya ON akt_pembayaran_biaya.id_pembelian = akt_pembelian.id_pembelian
        WHERE akt_pembelian.status != 6 AND akt_pembelian.status != 1 ")->queryScalar();

        $saldo_hutang_pembelian_harta_tetap = Yii::$app->db->createCommand("SELECT SUM(total - IF(akt_pembayaran_biaya_harta_tetap.nominal IS NULL, 0, akt_pembayaran_biaya_harta_tetap.nominal)) as total
        FROM akt_pembelian_harta_tetap 
        LEFT JOIN akt_pembayaran_biaya_harta_tetap ON akt_pembayaran_biaya_harta_tetap.id_pembelian_harta_tetap = akt_pembelian_harta_tetap.id_pembelian_harta_tetap
        WHERE akt_pembelian_harta_tetap.status = 2")->queryScalar();

        $saldo_hutang = $saldo_hutang_pembelian + $saldo_hutang_pembelian_harta_tetap;

        $saldo_piutang_pembelian = Yii::$app->db->createCommand("SELECT SUM(total - IF(akt_penerimaan_pembayaran.nominal IS NULL, 0, akt_penerimaan_pembayaran.nominal) + IF(akt_penerimaan_pembayaran.nominal IS NULL, 0, uang_muka)) as total
        FROM akt_penjualan 
        LEFT JOIN akt_penerimaan_pembayaran ON akt_penerimaan_pembayaran.id_penjualan = akt_penjualan.id_penjualan
        WHERE akt_penjualan.status != 5 AND akt_penjualan.status != 1 ")->queryScalar();

        $saldo_piutang_pembelian_harta_tetap = Yii::$app->db->createCommand("SELECT SUM(total - IF(akt_penerimaan_pembayaran_harta_tetap.nominal IS NULL, 0, akt_penerimaan_pembayaran_harta_tetap.nominal)) as total
        FROM akt_penjualan_harta_tetap 
        LEFT JOIN akt_penerimaan_pembayaran_harta_tetap ON akt_penerimaan_pembayaran_harta_tetap.id_penjualan_harta_tetap = akt_penjualan_harta_tetap.id_penjualan_harta_tetap
        WHERE akt_penjualan_harta_tetap.status = 2")->queryScalar();

        $saldo_piutang = $saldo_piutang_pembelian + $saldo_piutang_pembelian_harta_tetap;



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
