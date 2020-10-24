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
use yii\helpers\ArrayHelper;

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

<<<<<<< HEAD
        $sum_pendapatan = Yii::$app->db->createCommand("SELECT SUM(saldo_akun) FROM akt_akun where jenis = 4")->queryScalar();
        $sum_beban = Yii::$app->db->createCommand("SELECT SUM(saldo_akun) FROM akt_akun where jenis = 8")->queryScalar();

        $sum_omzet = $sum_pendapatan - $sum_beban;
=======
        // $sum_pendapatan = Yii::$app->db->createCommand("SELECT SUM(saldo_akun) FROM akt_akun where jenis = 4")->queryScalar();
        // $sum_beban = Yii::$app->db->createCommand("SELECT SUM(saldo_akun) FROM akt_akun where jenis = 8")->queryScalar();
        $sum_pendapatan = Yii::$app->db->createCommand("SELECT SUM(nominal) FROM akt_penerimaan_pembayaran")->queryScalar();

        // $sum_omzet = $sum_pendapatan - $sum_beban;
        if (!empty($sum_pendapatan)) {
            $sum_omzet = $sum_pendapatan;
        } else {
            $sum_omzet = 0;
        }
>>>>>>> 731cfed3fece0ab1886e838f6a727eb1810d8018

        $saldo_kas = AktAkun::find()->where(['id_akun' => 1])->one();
        $saldo_piutang = Yii::$app->db->createCommand("SELECT SUM(saldo_akun) as saldo FROM `akt_akun` WHERE nama_akun LIKE '%piutang%'")->queryScalar();
        $saldo_hutang = Yii::$app->db->createCommand("SELECT SUM(saldo_akun) as saldo FROM `akt_akun` WHERE nama_akun LIKE '%hutang%'")->queryScalar();
        $month = date('m');
        $year = date('Y');
        $tanggal = Yii::$app->db->createCommand("SELECT tanggal_order_penjualan FROM akt_penjualan WHERE status >= 3 AND MONTH(tanggal_order_penjualan) = '$month' AND YEAR(tanggal_order_penjualan) = '$year' GROUP BY tanggal_order_penjualan")->query();
        $tanggal2 = Yii::$app->db->createCommand("SELECT tanggal_order_pembelian FROM akt_pembelian WHERE status >= 3 AND MONTH(tanggal_order_pembelian) = '$month' AND YEAR(tanggal_order_pembelian) = '$year' GROUP BY tanggal_order_pembelian")->query();

        $tanggal_labels = Yii::$app->db->createCommand("SELECT tanggal_order_penjualan FROM akt_penjualan WHERE status >= 3 AND MONTH(tanggal_order_penjualan) = '$month' AND YEAR(tanggal_order_penjualan) = '$year' GROUP BY tanggal_order_penjualan")->query();
        $tanggal_labels2 = Yii::$app->db->createCommand("SELECT tanggal_order_pembelian FROM akt_pembelian WHERE status >= 3 AND MONTH(tanggal_order_pembelian) = '$month' AND YEAR(tanggal_order_pembelian) = '$year' GROUP BY tanggal_order_pembelian")->query();

        $penjualan = Yii::$app->db->createCommand("SELECT SUM(akt_penjualan_detail.qty) AS penjualan, akt_item.nama_item FROM `akt_penjualan_detail` LEFT JOIN akt_penjualan ON akt_penjualan.id_penjualan = akt_penjualan_detail.id_penjualan LEFT JOIN akt_item_stok ON akt_item_stok.id_item_stok = akt_penjualan_detail.id_item_stok LEFT JOIN akt_item ON akt_item.id_item = akt_item_stok.id_item WHERE MONTH(tanggal_order_penjualan) = '$month' AND YEAR(tanggal_order_penjualan) = '$year'  GROUP BY akt_item.id_item ORDER BY penjualan DESC LIMIT 5")->query();

        $sum_penjualan = Yii::$app->db->createCommand("SELECT SUM(akt_penjualan_detail.qty) AS penjualan FROM `akt_penjualan_detail` LEFT JOIN akt_penjualan ON akt_penjualan.id_penjualan = akt_penjualan_detail.id_penjualan WHERE MONTH(tanggal_order_penjualan) = '$month' AND YEAR(tanggal_order_penjualan) = '$year' ")->queryScalar();

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
            'tanggal_label2' => $tanggal_labels2,
            'tanggal' => $tanggal,
            'tanggal2' => $tanggal2,
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
