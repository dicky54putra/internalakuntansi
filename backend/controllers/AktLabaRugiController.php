<?php

namespace backend\controllers;

use Yii;
use backend\models\AktLabaRugi;
use backend\models\AktLabaRugiDetail;
use backend\models\AktLaporanPosisiKeuangan;
use backend\models\AktAkun;
use backend\models\AktLaporanEkuitas;
use backend\models\AktLabaRugiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;
/**
 * AktLabaRugiController implements the CRUD actions for AktLabaRugi model.
 */
class AktLabaRugiController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all AktLabaRugi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktLabaRugiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new AktLabaRugi();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    /**
     * Displays a single AktLabaRugi model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $akun_pendapatan = Yii::$app->db->createCommand("SELECT akt_laba_rugi_detail.*,akt_akun.nama_akun FROM akt_laba_rugi_detail LEFT JOIN akt_akun ON akt_akun.id_akun = akt_laba_rugi_detail.id_akun WHERE akt_akun.jenis = 4 AND id_laba_rugi = '$id'")->query();
        $akun_beban = Yii::$app->db->createCommand("SELECT akt_laba_rugi_detail.*,akt_akun.nama_akun FROM akt_laba_rugi_detail LEFT JOIN akt_akun ON akt_akun.id_akun = akt_laba_rugi_detail.id_akun WHERE akt_akun.jenis = 8 AND id_laba_rugi = '$id'")->query();

        $lap_ekuitas = AktLaporanEkuitas::find()->where(['id_laba_rugi' => $id])->all();
        $jenis = Yii::$app->db->createCommand("SELECT jenis from akt_akun WHERE jenis = 1 OR jenis = 2 OR jenis = 5 OR jenis = 6 OR jenis = 7 GROUP BY jenis")->query();
        // $lap_posisi = Yii::$app->db->createCommand("SELECT akt_laporan_posisi_keuangan.id_akun,akt_laporan_posisi_keuangan.nominal,akt_akun.nama_akun,akt_akun.jenis FROM akt_laporan_posisi_keuangan LEFT JOIN akt_akun ON akt_akun.id_akun = akt_laporan_posisi_keuangan.id_akun WHERE id_laba_rugi = '$id'")->query();

        return $this->render('view', [
            'akun' => $akun_pendapatan,
            'beban' => $akun_beban,
            'model' => $model,
            'ekuitas' => $lap_ekuitas,
            'jenis' => $jenis
        ]);
    }

   
    public function actionCreate()
    {
       
        $model = new AktLabaRugi();
        if ($model->load(Yii::$app->request->post()) ) {
            $post_preview =  Yii::$app->request->post('post_preview');
            $post_simpan =  Yii::$app->request->post('post_simpan');
            $post_setor = Yii::$app->request->post('setor_tambahan');
            $post_periode = Yii::$app->request->post('AktLabaRugi')['periode'];
                $month = date('m');
                $year = date('y');
                if($post_periode == 1) {
                    $query_jurnal = 'WHERE MONTH(tanggal) = '.$month;
                } else if ($post_periode == 2 ) {
                    $query_jurnal = 'WHERE MONTH(tanggal) = 1 OR MONTH(tanggal) = 2 OR MONTH(tanggal) = 3 AND YEAR(tanggal) = '.$year;
                } else if ($post_periode == 3 ) {
                    $query_jurnal = 'WHERE MONTH(tanggal) = 4 OR MONTH(tanggal) = 5 OR MONTH(tanggal) = 6 AND YEAR(tanggal) = '.$year;
                } else if ($post_periode == 4 ) {
                    $query_jurnal = 'WHERE MONTH(tanggal) = 7 OR MONTH(tanggal) = 8 OR MONTH(tanggal) = 9 AND YEAR(tanggal) = '.$year;
                } else if ($post_periode == 5 ) {
                    $query_jurnal = 'WHERE MONTH(tanggal) = 10 OR MONTH(tanggal) = 11 OR MONTH(tanggal) = 12 AND YEAR(tanggal) = '.$year;
                } else if ($post_periode == 6 ) {
                    $query_jurnal = 'WHERE YEAR(tanggal) = '. $year;
                } 

                $jurnal = Yii::$app->db->createCommand("SELECT SUM(debit) FROM akt_jurnal_umum_detail LEFT JOIN akt_jurnal_umum ON akt_jurnal_umum.id_jurnal_umum = akt_jurnal_umum_detail.id_jurnal_umum $query_jurnal AND id_akun = 77")->queryScalar();
                $modal = Yii::$app->db->createCommand("SELECT kredit FROM akt_saldo_awal_akun_detail ORDER BY id_saldo_awal_akun_detail DESC LIMIT 1")->queryScalar();

                if($jurnal == null ) {
                    $jurnal = 0;
                }
            if(isset($post_preview)) {
                if($post_setor == null ) {
                    $post_setor = 0;
                }
                $akun_pendapatan = AktAkun::find()->where(['jenis' => 4])->all();
                $akun_beban = AktAkun::find()->where(['jenis' => 8])->all();
                if($modal == null) {
                    $modal = 0;
                }

                $jenis = Yii::$app->db->createCommand("SELECT jenis from akt_akun WHERE jenis = 1 OR jenis = 2 OR jenis = 5 OR jenis = 6 OR jenis = 7 GROUP BY jenis")->query();
                // echo $jurnal; die;
                $print =  $this->renderPartial('preview',[
                    'akun_pendapatan' => $akun_pendapatan,
                    'akun_beban' => $akun_beban,
                    'setor' => $post_setor,
                    'modal' => $modal,
                    'jenis' => $jenis,
                    'jurnal' => $jurnal
                ]); 
                $mPDF = new mPDF(['orientation' => 'L']);
                $mPDF->showImageErrors = true;
                $mPDF->writeHTML($print);
                $mPDF->Output();
                exit();
            } else if(isset($post_simpan)) {
                // Save laba rugi
                $id_login =  Yii::$app->user->identity->id_login;
                $model->status = 1;
                $model->tanggal_approve = date("Y-m-d h:i:sa");
                $model->id_login = $id_login;
                $model->save();

                // End save laba rugi 

                // Save laba rugi detail
                $count = Yii::$app->db->createCommand("SELECT COUNT(id_akun) FROM akt_akun WHERE jenis = 4 or jenis = 8")->queryScalar();
                $akt_akun = AktAkun::find()->where(['jenis'=> 4 ])->orWhere(['jenis' => 8])->asArray()->all();
                for($x = 0 ; $x < $count ; $x++){
                    $akt_laba_rugi_detail = new AktLabaRugiDetail();
                    $akt_laba_rugi_detail->id_laba_rugi = $model->id_laba_rugi;
                    $akt_laba_rugi_detail->id_akun = $akt_akun[$x]['id_akun'];
                    $akt_laba_rugi_detail->saldo_akun = $akt_akun[$x]['saldo_akun'];
                    $akt_laba_rugi_detail->save(false);
                }

                // end save laba rugi detail

                // save ekuitas

                $sum_pendapatan = Yii::$app->db->createCommand('SELECT SUM(saldo_akun) FROM akt_akun WHERE jenis = 4')->queryScalar();
                $sum_beban = Yii::$app->db->createCommand('SELECT SUM(saldo_akun) FROM akt_akun WHERE jenis = 8')->queryScalar();
                $laba_bersih = $sum_pendapatan - $sum_beban;
                $model_ekuitas = new AktLaporanEkuitas();
                $model_ekuitas->id_laba_rugi = $model->id_laba_rugi;
                $model_ekuitas->setor_tambahan = $post_setor;
                $model_ekuitas->prive = $jurnal;
                $model_ekuitas->modal = $modal;
                $model_ekuitas->laba_bersih = $laba_bersih;
                $model_ekuitas->save(false);

                // end save ekuitas

                // save laporan posisi keuangan

                $count_posisi = Yii::$app->db->createCommand("SELECT COUNT(id_akun) FROM akt_akun WHERE jenis = 1 OR jenis = 2 OR jenis = 5 OR jenis = 6 OR jenis = 7")->queryScalar();
                $akt_akun_posisi = AktAkun::find()->where(['jenis'=> 1 ])->orWhere(['jenis' => 2])->orWhere(['jenis' => 5])->orWhere(['jenis' => 6])->orWhere(['jenis' => 7])->asArray()->all();
                for($i = 0 ; $i < $count_posisi ; $i++){
                    $akt_posisi_keuangan = new AktLaporanPosisiKeuangan();
                    $akt_posisi_keuangan->id_laba_rugi = $model->id_laba_rugi;
                    $akt_posisi_keuangan->id_akun = $akt_akun_posisi[$i]['id_akun'];
                    $akt_posisi_keuangan->nominal = $akt_akun_posisi[$i]['saldo_akun'];
                    $akt_posisi_keuangan->save(false);
                }
                // end laporan posisi keuangan


                return $this->redirect(['view', 'id' => $model->id_laba_rugi]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
        
    }

    /**
     * Updates an existing AktLabaRugi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_laba_rugi]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing AktLabaRugi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model =  $this->findModel($id);
        $laba_detail = AktLabaRugiDetail::find()->where(['id_laba_rugi' => $id])->all();
        $posisi = AktLaporanPosisiKeuangan::find()->where(['id_laba_rugi' => $id])->all();
        $ekuitas = AKtLaporanEkuitas::find()->where(['id_laba_rugi' => $id])->one();
        $ekuitas->delete();
        foreach($laba_detail as $data) {
            $data->delete();
        }

        foreach($posisi as $p) {
            $p->delete();
        }
        $model->delete();
        return $this->redirect(['index']);
    }

    /**
     * Finds the AktLabaRugi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktLabaRugi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktLabaRugi::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCetak($id)
    {

        $akun_pendapatan = Yii::$app->db->createCommand("SELECT akt_laba_rugi_detail.*,akt_akun.nama_akun FROM akt_laba_rugi_detail LEFT JOIN akt_akun ON akt_akun.id_akun = akt_laba_rugi_detail.id_akun WHERE akt_akun.jenis = 4 AND id_laba_rugi = '$id'")->query();
        $akun_beban = Yii::$app->db->createCommand("SELECT akt_laba_rugi_detail.*,akt_akun.nama_akun FROM akt_laba_rugi_detail LEFT JOIN akt_akun ON akt_akun.id_akun = akt_laba_rugi_detail.id_akun WHERE akt_akun.jenis = 8 AND id_laba_rugi = '$id'")->query();
        $lap_ekuitas = AktLaporanEkuitas::find()->where(['id_laba_rugi' => $id])->all();
        $jenis = Yii::$app->db->createCommand("SELECT jenis from akt_akun WHERE jenis = 1 OR jenis = 2 OR jenis = 5 OR jenis = 6 OR jenis = 7 GROUP BY jenis")->query();


        $print =  $this->renderPartial('_cetak',[
            'akun_pendapatan' => $akun_pendapatan,
            'akun_beban' => $akun_beban,
            'ekuitas' => $lap_ekuitas,
            'jenis' => $jenis,
            'model' => $this->findModel($id)
        ]); 
        $mPDF = new mPDF(['orientation' => 'L']);
        $mPDF->showImageErrors = true;
        $mPDF->writeHTML($print);
        $mPDF->Output();
        exit();
    }
}
