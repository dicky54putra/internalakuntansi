<?php

namespace backend\controllers;

use Yii;
use backend\models\AktBom;
use backend\models\AktBomDetailBb;
use backend\models\AktItemStok;
use backend\models\AktBomSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AktBomDetailHp;

/**
 * AktBomController implements the CRUD actions for AktBom model.
 */
class AktBomController extends Controller
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
     * Lists all AktBom models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AktBomSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AktBom model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (Yii::$app->request->get('aksi') == "save") {
            $simpan = new AktBomDetailBb();
            $simpan->id_bom = $id;
            $simpan->id_item_stok = Yii::$app->request->post('id_item_stok');
            $simpan->qty = Yii::$app->request->post('qty');

            // $cek_qty = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '$simpan->id_item_stok'")->queryScalar();

            $cek_qty = AktItemStok::find()->where(['id_item_stok' => $simpan->id_item_stok])->one();
            $cek_item =  Yii::$app->db->createCommand("SELECT COUNT(*) FROM akt_bom WHERE id_bom = '$_GET[id]' AND id_item_stok = '$simpan->id_item_stok'")->queryScalar();

            // var_dump($simpan->qty);
            // var_dump($cek_qty->qty);
            // die;

            if ($simpan->qty > $cek_qty->qty) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Stok tidak mencukupi']]);
            } else if ($cek_item > 0) {
                Yii::$app->session->setFlash('danger', [['Perhatian!', 'Item yang diinputkan tidak boleh sama dengan, item yang diinputkan pada B.o.M!']]);
            } else {
                // $stok = $cek_qty - $simpan->qty;
                // $item_stok = Yii::$app->db->createCommand("UPDATE akt_item_stok SET qty = '$stok' WHERE id_item_stok = '$simpan->id_item'")->execute();
                $simpan->harga = Yii::$app->request->post("harga");
                $simpan->keterangan = Yii::$app->request->post("keterangan");
                $simpan->save();
                Yii::$app->session->setFlash("success", "Detail Item Ditambahkan");
                return $this->redirect(['akt-bom/view', 'id' => $id]);
            }

            // $simpan->save(false);

            // return $this->redirect(['view', 'id' => $id]);
        }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new AktBom model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionGetHarga($id)
    {
        $harta_tetap = AktItemStok::find()
            ->select(["hpp"])
            ->leftJoin("akt_item", "akt_item.id_item = akt_item_stok.id_item")
            ->leftJoin("akt_item_harga_jual", "akt_item.id_item = akt_item_harga_jual.id_item")
            ->where(['id_item_stok' => $id])
            ->asArray()
            ->one();
        return json_encode($harta_tetap);
    }

    public function actionCreate()
    {
        $model = new AktBom();
        $model_item = new AktItemStok;
        // $total = Yii::$app->db->createCommand("SELECT count(id_bom) from akt_bom where date_format(tanggal, '%Y-%m') = '" . date('Y-m') . "'")->queryScalar();
        // // $total = AktBom::find()->count();
        // $nomor = 'AB' . date('ym') . str_pad($total + 1, 3, "0", STR_PAD_LEFT);

        $id_bom_max = AktBom::find()->select(['max(id_bom) as id_bom'])->one();
        $nomor_sebelumnya = AktBom::find()->select(['SUBSTRING(no_bom, 3, 4) as no_bom'])->where(['id_bom' => $id_bom_max])->one();
        if (!empty($nomor_sebelumnya->no_bom)) {
            # code...
            if ($nomor_sebelumnya->no_bom == date('ym')) {
                # code...
                // $kode = 'oke' . $nomor_sebelumnya->no_bom . ' - ' . date('ym');
                $noUrut = (int) substr($nomor_sebelumnya->no_bom, 2, 4);
                $noUrut++;
                $noUrut_2 = sprintf("%03s", $noUrut);
                $no_bom = "AB" . date('ym') . $noUrut_2;
                $kode = $no_bom;
            } else {
                # code...

                $kode = 'AB' . date('ym') . '001';
            }

            // $noUrut = (int) substr($nomor_sebelumnya->no_bom, 2, 4);
            // $noUrut++;
            // $noUrut_2 = sprintf("%03s", $noUrut);
            // $no_bom = "AB" . date('ym') . $noUrut_2;
            // $kode = $no_bom;
        } else {
            # code...
            $kode = 'AB' . date('ym') . '001';
        }

        $nomor = $kode;

        if ($model->load(Yii::$app->request->post())) {
            $model->status_bom = 2;
            // $model->tanggal = date('Y-m-d');
            $model->save();
            $akt_bom_detail_hp = new AktBomDetailHp();
            $akt_bom_detail_hp->id_bom = $model->id_bom;
            $akt_bom_detail_hp->id_item_stok = $model->id_item_stok;
            $akt_bom_detail_hp->save(FALSE);
            return $this->redirect(['view', 'id' => $model->id_bom]);
        }

        return $this->render('create', [
            'model' => $model,
            'nomor' => $nomor,
            'model_item' => $model_item
        ]);
    }

    /**
     * Updates an existing AktBom model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $nomor = $model->no_bom;
        $id_item_stok = $model->id_item_stok;
        $model_item = new AktItemStok;
        if ($model->load(Yii::$app->request->post())) {
            $akt_bom_detail_hp = Yii::$app->db->createCommand("UPDATE akt_bom_detail_hp SET id_item_stok = '$id_item_stok' WHERE id_bom = '$id'")->execute();
            $model->save(false);
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('update', [
            'model' => $model,
            'nomor' => $nomor,
            'model_item' => $model_item
        ]);
    }

    /**
     * Deletes an existing AktBom model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $akt_bom_detail_hp = AktBomDetailHp::find()
            ->where(['id_bom' => $id])
            ->one();
        $akt_bom_detail_hp->delete();
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    public function actionApproved($id)
    {
        $model = $this->findModel($id);
        $query = AktBomDetailBb::find()->where(['id_bom' => $model->id_bom])->asArray()->all();
        foreach ($query as $key => $value) {
            $cek_qty = 0;
            $cek_qty_ = Yii::$app->db->createCommand("SELECT qty FROM akt_item_stok WHERE id_item_stok = '" . $value['id_item_stok'] . "'")->queryScalar();
            $qty = ($value['qty'] > $cek_qty_) ? 1 : 0;
            $cek_qty += $qty;
        }
        $cek_bom_bb = AktBomDetailBb::find()->where(['id_bom' => $model->id_bom])->count();

        if ($cek_bom_bb > 0) {
            if ($cek_qty == 0) {
                $model->tanggal_approve = date('Y-m-d');
                $model->id_login = Yii::$app->user->identity->id_login;
                $model->status_bom = 1;
                $model->save(false);
                Yii::$app->session->setFlash('success', [['Berhasil !', 'berhasil di approve!']]);
                return $this->redirect(['view', 'id' => $model->id_bom]);
            } else {
                Yii::$app->session->setFlash('danger', [['Gagal !', 'tidak bisa approve, karena stok bill of material detail kurang!']]);
                return $this->redirect(['view', 'id' => $model->id_bom]);
            }
        } else {
            Yii::$app->session->setFlash('danger', [['Gagal !', 'tidak bisa approve, karena bill of material detail masih kosong!']]);
            return $this->redirect(['view', 'id' => $model->id_bom]);
        }
        // $model->status_bom = 1;
        // $model->save(false);
        // Yii::$app->session->setFlash('success', [['Berhasil !', 'berhasil di approve!']]);
        // return $this->redirect(['view', 'id' => $model->id_bom]);
    }

    public function actionReject($id)
    {
        $model = $this->findModel($id);
        $model->tanggal_approve = date('Y-m-d');
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status_bom = 3;
        $model->save(false);
        Yii::$app->session->setFlash('success', [['Berhasil !', 'berhasil di reject!']]);
        return $this->redirect(['view', 'id' => $model->id_bom]);
    }

    public function actionPending($id)
    {
        $model = $this->findModel($id);
        $model->tanggal_approve = date('Y-m-d');
        $model->id_login = Yii::$app->user->identity->id_login;
        $model->status_bom = 2;
        $model->save(false);
        Yii::$app->session->setFlash('success', [['Berhasil !', 'berhasil di pending!']]);
        return $this->redirect(['view', 'id' => $model->id_bom]);
    }

    /**
     * Finds the AktBom model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AktBom the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AktBom::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
