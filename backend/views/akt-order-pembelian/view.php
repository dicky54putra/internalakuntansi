<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use backend\models\Foto;
use backend\models\AktMitraBisnis;
use backend\models\AktCabang;
use backend\models\AktMataUang;

use backend\models\AktOrderPembelian;

use backend\models\AktPegawai;
use backend\models\AktProyek;
use backend\models\AktDepartement;
use backend\models\AktSatuan;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\jui\AutoComplete;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\AktOrderPembelian */

$this->title = 'Detail Order Pembelian : ' . $model->no_order;
\yii\web\YiiAsset::register($this);
?>
<div class="akt-order-pembelian-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li><?= Html::a('Order Pembelian', ['index']) ?></li>
        <li class="active"><?= $model->no_order ?></li>
    </ul>

    <p>
        <?= Html::a('<span class="glyphicon glyphicon-circle-arrow-left"></span> Kembali', ['index'], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-edit"></span> Ubah', ['update', 'id' => $model->id_order_pembelian], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('<span class="glyphicon glyphicon-trash"></span> Hapus', ['delete', 'id' => $model->id_order_pembelian], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <div class="box">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="fa fa-barcode"></span> Order Pembelian</div>
            <div class="panel-body">
                <div class="col-md-12" style="padding: 0;">
                    <div class="box-body">
                        <?= DetailView::widget([
                            'model' => $model,
                            'attributes' => [
                                // 'id_order_pembelian',
                                'no_order',
                                'tanggal_order',
                                'status_order',
                                [
                                    'attribute' => 'id_supplier',
                                    'label' => 'Supplier',
                                    'value' => function ($model) {

                                        if (!empty($model->akt_supplier->nama_mitra_bisnis)) {
                                            # code...
                                            return $model->akt_supplier->nama_mitra_bisnis;
                                        } else {
                                            # code...
                                        }
                                    }
                                ],
                                [
                                    'attribute' => 'id_mata_uang',
                                    'label' => 'Mata Uang',
                                    'value' => function ($model) {

                                        if (!empty($model->akt_mata_uang->mata_uang)) {
                                            # code...
                                            return $model->akt_mata_uang->mata_uang;
                                        } else {
                                            # code...
                                        }
                                    }
                                ],
                                // 'id_mata_uang',
                                'keterangan:ntext',
                                [
                                    'attribute' => 'id_cabang',
                                    'label' => 'Cabang',
                                    'value' => function ($model) {
                                        if (!empty($model->akt_cabang->nama_cabang)) {
                                            return $model->akt_cabang->nama_cabang;
                                            # code...
                                        } else {
                                            # code...
                                        }
                                    }
                                ],
                                // 'draft',
                                // 'alamat_bayar:ntext',
                                // 'alamat_kirim:ntext',
                            ],
                        ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box">
    <div class="panel panel-primary">
        <div class="panel-heading"></div>
        <div class="panel-body">
            <div class="col-md-12" style="padding: 0;">
                <div class="box-body">
                    <div class="" style="margin-top:20px;">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#pendaftaran-item">Pendaftaran Barang</a></li>
                            <li><a data-toggle="tab" href="#unggah-dokumen">Unggah Dokumen</a></li>
                            <li><a data-toggle="tab" href="#isi-alamat" class="hidden">Isi Alamat</a></li>
                        </ul>

                        <div class="tab-content">
                            <div id="pendaftaran-item" class="tab-pane fade in active" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12">
                                        <div class="box box-success">
                                            <div class="box-header with-border">
                                                <div class="box-title">Pendaftaran Barang</div>
                                            </div>
                                            <div class="box-body">
                                                <div class="test">
                                                    <div class="row">
                                                        <?= Html::beginForm(['akt-order-pembelian/view', 'aksi' => 'save',  'id' => Yii::$app->request->get('id')], 'post') ?>
                                                        <div class="col-md-5">
                                                            <?php
                                                            echo Select2::widget([
                                                                'name' => 'id_item_stok',
                                                                'data' => $array_item,
                                                                'language' => 'en',
                                                                'options' => ['placeholder' => 'Pilih Barang', "class" => "form-control", 'id' => 'id_item_stok',],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true
                                                                ]
                                                            ]);
                                                            ?>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <?= Html::input("text", "quantity", "", ["class" => "form-control", "placeholder" => "Qty", "id" => "qty"]) ?>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <?= Html::input("text", "harga", "", ["class" => "form-control", "placeholder" => "Harga", "id" => "harga"]) ?>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?= Html::input("text", "diskon", "", ["class" => "form-control", "placeholder" => "Diskon", "id" => "diskon"]) ?>
                                                        </div>

                                                        <div class="" hidden>
                                                            <?php echo Select2::widget([
                                                                // 'model' => $model,
                                                                'name' => 'proyek',
                                                                'data' => ArrayHelper::map(AktProyek::find()->all(), 'id_proyek', 'nama_proyek'),
                                                                'options' => ['placeholder' => 'Pilih Proyek'],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true
                                                                ],
                                                            ]); ?>
                                                        </div>
                                                        <div class="" hidden>
                                                            <?php echo Select2::widget([
                                                                // 'model' => $model,
                                                                'name' => 'departement',
                                                                'data' => ArrayHelper::map(AktDepartement::find()->all(), 'id_departement', 'nama_departement'),
                                                                'options' => ['placeholder' => 'Pilih Departement'],
                                                                'pluginOptions' => [
                                                                    'allowClear' => true
                                                                ],
                                                            ]); ?>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            <?= Html::input("text", "keterangan", "", ["class" => "form-control", "placeholder" => "Keterangan", "id" => "keterangan"]) ?>
                                                        </div>

                                                        <div class="" hidden>
                                                            <?php echo DatePicker::widget([
                                                                'name' => 'req_date',
                                                                'options' => ['placeholder' => 'Req. Date'],
                                                                'pluginOptions' => [
                                                                    'todayHighlight' => true,
                                                                    'todayBtn' => true,
                                                                    'format' => 'yyyy-mm-dd',
                                                                    'autoclose' => true,
                                                                ]
                                                            ]);
                                                            ?>

                                                        </div>
                                                        <div class="col-md-2">
                                                            <div class="form-group">
                                                                <button class="btn btn-success pull-right"><span class="glyphicon glyphicon-plus"></span> Tambahkan</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?= Html::endForm() ?>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <br>
                                                    <table class="table">
                                                        <tr>
                                                            <th>No.</th>
                                                            <th>Nama Barang</th>
                                                            <th>Quantity</th>
                                                            <th>Harga</th>
                                                            <th>Diskon %</th>
                                                            <!-- <th>Satuan</th> -->
                                                            <!-- <th>Proyek</th> -->
                                                            <!-- <th>Departement</th> -->
                                                            <th>Keterangan</th>
                                                            <!-- <th align="right">Req. Date</th> -->
                                                            <th align="center">Subtotal</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        <?php
                                                        $i = 0;
                                                        $grandtotal = 0;
                                                        $subtotal = 0;
                                                        foreach ($daftar_item as $data) {

                                                            $i++;
                                                            echo "<tr>";
                                                            echo "<td align='center'>$i.</td>";
                                                            echo "<td>" . $data->item_stok->item['nama_item'] . "</td>";
                                                            echo "<td>" . $data->quantity . "</td>";
                                                            echo "<td>" . $data->harga . "</td>";
                                                            echo "<td>" . $data->diskon . "%</td>";
                                                            // echo "<td>" . $data->satuan['nama_satuan'] . "</td>";
                                                            // echo "<td align='right'>" . $data->proyek["nama_proyek"]  . "</td>";
                                                            // echo "<td align='right'>" . $data->departement["nama_departement"]  . "</td>";
                                                            echo "<td align='right'>" . $data->keterangan . "</td>";
                                                            // echo "<td align='right'>" . tanggal_indo($data->req_date, true)  . "</td>";

                                                            $total = $data->harga * $data->quantity;
                                                            $diskon = $total * ($data->diskon / 100);
                                                            $subtotal = $total - $diskon;

                                                            echo "<td align='right'>" . $subtotal . "</td>";

                                                            echo "<td><a href=\"index.php?r=item-order-pembelian/update&id=" . Yii::$app->request->get('id') . "&id_item_order_pembelian=$data->id_item_order_pembelian\"> <i class=\"glyphicon glyphicon-edit\"></i>  </a>  &nbsp;  <a href=\"index.php?r=akt-order-pembelian/view&id=" . Yii::$app->request->get('id') . "&action=delete_item&id_item_order_pembelian=$data->id_item_order_pembelian\"> <i class=\"glyphicon glyphicon-trash text-danger\"></i>  </a> </td>";

                                                            echo "</tr>";

                                                            $grandtotal += $subtotal;
                                                        }



                                                        ?>

                                                        <tr>
                                                            <td colspan="6" align="right"><b><i>SUBTOTAL</i></b></td>
                                                            <td align="right"><b id="subtotal"><?php echo $grandtotal ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" align="right"><b><i>DISKON</i></b></td>
                                                            <td align="right">
                                                                <input type="number" id="diskon_total" placeholder="Diskon %" />
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" align="right"><b><i>PAJAK</i></b></td>
                                                            <td align="right"><input type="checkbox" value="" id="pajak" /></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="6" align="right"><b><i>GRANDTOTAL</i></b></td>
                                                            <td align="right" id="grandtotal"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="unggah-dokumen" class="tab-pane fade" style="margin-top:20px;">
                                <?= Html::beginForm(['akt-order-pembelian/upload'], 'post', ['enctype' => 'multipart/form-data']) ?>
                                <?= Html::hiddenInput("id_tabel", $model->id_order_pembelian) ?>
                                <?= Html::hiddenInput("nama_tabel", "order-pembelian") ?>
                                <div class="box">
                                    <div class="box-header">
                                        <div class="col-md-12" style="padding: 0;">
                                            <div class="box-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>UPLOAD FOTO ATAU DOKUMEN</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <input class='btn btn-warning' type="file" name="foto" id="exampleInputFile"><br>
                                                                <b style="color: red;">Catatan:<br>- File harus bertype jpg, png, jpeg, excel, work, pdf<br>- Ukuran maksimal 2 MB.</b>
                                                            </td>
                                                            <td>
                                                                <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?= Html::endForm() ?>

                                <div class="box">
                                    <div class="box-header">
                                        <div class="col-md-12" style="padding: 0;">
                                            <div class="box-body">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>DOKUMEN :</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                                <?php foreach ($foto as $data) { ?>
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th width="80%">
                                                                    <a target="_BLANK" href="/backend/web/upload/<?php echo $data->foto; ?>"><?php echo $data->foto; ?></a>
                                                                </th>
                                                                <th width="20%">
                                                                    <a href="index.php?r=akt-order-pembelian/view&id=<?php echo $model->id_order_pembelian; ?>&id_hapus=<?php echo $data->id_foto; ?>" onclick="return confirm('Anda yakin ingin menghapus?')"><img src='images/hapus.png' width='20'></a>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div id="isi-alamat" class="tab-pane fade hidden" style="margin-top:20px;">
                                <div class="row" style="margin-top:30px;">
                                    <div class="col-md-12">
                                        <div class="box box-success">
                                            <div class="box-header with-border">
                                                <div class="box-title">Pendaftaran Barang</div>
                                            </div>
                                            <div class="box-body">

                                                <div class="test">

                                                    <?php

                                                    $cek = AktOrderPembelian::find()->where(['id_order_pembelian' => $_GET['id']])->one();

                                                    if ($cek->alamat_kirim == '' || $cek->alamat_bayar == '') { ?>

                                                        <?= Html::beginForm(['akt-order-pembelian/view', 'aksi' => 'input_alamat', 'id' => $_GET['id']], 'post') ?>

                                                        <label for="fname">Masukan Alamat Kirim</label>
                                                        <input type="text" id="alamat_kirim" name="alamat_kirim" placeholder="Alamat...">

                                                        <label for="lname">Masukan Alamat Bayar</label>
                                                        <input type="text" id="alamat_bayar" name="alamat_bayar" placeholder="Alamat...">

                                                        <input type="submit" value="Save" style="background-color: green;">

                                                        <?= Html::endForm() ?>

                                                    <?php } else { ?>

                                                        <label for="fname">Alamat Kirim</label>
                                                        <input type="text" id="alamat_kirim" name="alamat_kirim" value="<?= $cek->alamat_kirim ?>">

                                                        <label for="lname">Alamat Bayar</label>
                                                        <input type="text" id="alamat_bayar" name="alamat_bayar" value="<?= $cek->alamat_bayar ?>">
                                                    <?php } ?>



                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>

<style>
    #diskon_total {
        width: 50%;
        padding: 8px 20px;
        margin: 3px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }



    fieldset {
        margin: 5px;
        border: 1px solid silver;
        padding: 8px;
        border-radius: 4px;
    }

    legend {
        padding: 2px;
    }

    input[type=number] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type=date] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type=submit] {
        width: 100%;
        /*background-color: #4CAF50;*/
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    button {
        width: 100%;
        /*background-color: #4CAF50;*/
        color: white;
        padding: 14px 20px;
        /* margin: 8px 0; */
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    div.test {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
    }
</style>

<?php
$script = <<< JS
$('#id_item_stok').change(function(){
    var id = $(this).val();
 
    $.get('index.php?r=akt-order-pembelian/get-harga-item',{ id : id },function(data){
        var data = $.parseJSON(data);
        $('#harga').attr('value',data.hpp);
    });
});
 
JS;
$this->registerJs($script);
?>

<script>
    let grandTotal = document.querySelector('#grandtotal');
    let subTotal = document.querySelector('#subtotal').innerHTML;
    let pajakHtml = document.querySelector('#pajak');
    let subTotalInt = parseInt(subTotal);
    let diskon = document.querySelector('#diskon_total');

    function disk(pajakVal = 0, diskonVal = 0) {
        let diskonPersen = diskonVal / 100 * subTotal;
        grandTotal.innerHTML = `${subTotal-diskonPersen+pajakVal}`;
    }

    function diskonCek(pajakVal = 0) {
        diskon.addEventListener("input", () => {
            if (diskon.value > 0) {
                pajakHtml.onchange = function() {
                    if (pajakHtml.checked === true) {
                        let diskonPersen = diskon.value / 100 * subTotal;
                        let total = subTotal - diskonPersen;
                        let pajak = total * 10 / 100;
                        grandTotal.innerHTML = `${subTotal-diskonPersen+pajak}`;

                    } else if (pajakHtml.checked === false) {
                        disk(0, diskon.value)
                    }
                }
            }
            disk(0, diskon.value)
        })
    }

    function pajakCek() {
        pajakHtml.onchange = function() {
            if (pajakHtml.checked === true) {
                let pajak = subTotal * 10 / 100;
                disk(pajak, 0);
                diskon.addEventListener("input", () => {
                    if (diskon.value > 0) {
                        let diskonPersen = diskon.value / 100 * subTotal;
                        let total = subTotal - diskonPersen;
                        let pajak = total * 10 / 100;
                        grandTotal.innerHTML = `${subTotal-diskonPersen+pajak}`;
                    }
                })
            } else if (pajakHtml.checked === false) {
                disk(0, 0);
            }
        };
    }


    function setup() {
        pajakCek();
        diskonCek();
    }

    setup();
</script>