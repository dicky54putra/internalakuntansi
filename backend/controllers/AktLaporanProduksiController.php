<?php

namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;
/**
 * DaftarMisiController implements the CRUD actions for DaftarMisi model.
 */
class AktLaporanProduksiController extends Controller
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

    public function actionIndex()
    {

        return $this->render('index');
    }

    public function actionIndexDetail()
    {

        return $this->render('indexdetail');
    }

    public function actionIndexItem()
    {

        return $this->render('indexitem');
    }

    public function actionIndexBahan()
    {

        return $this->render('indexbahan');
    }
    public function actionIndexBom()
    {

        return $this->render('indexbom');
    }
    public function actionIndexProduksi()
    {

        return $this->render('indexproduksi');
    }


    public function actionLap()
    {
        $type = Yii::$app->request->post('type');
        $tanggal_awal = Yii::$app->request->post('tanggal_awal');
        $tanggal_akhir = Yii::$app->request->post('tanggal_akhir');

        if($type == 1) {
            $print =  $this->renderPartial('lapproduksidetail',[
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir,
            ]);    
        } else if ($type == 2) {
            $print =  $this->renderPartial('lappemakaianbahan',[
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir,
            ]);  
        } else if ($type == 3) {
            $print =  $this->renderPartial('lapproduksiperitem',[
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir,
            ]);  
        } else if ($type == 4) {
            $print =  $this->renderPartial('lapdaftarbom');  
        } else if ($type == 5) {
            $print =  $this->renderPartial('laphasilproduksi',[
                'tanggal_awal' => $tanggal_awal,
                'tanggal_akhir' => $tanggal_akhir,
            ]);
        }
        
        

        
        $mPDF = new mPDF(['orientation' => 'L']);
        $mPDF->showImageErrors = true;
        $mPDF->writeHTML($print);
        $mPDF->Output();
        exit();
    }
}
