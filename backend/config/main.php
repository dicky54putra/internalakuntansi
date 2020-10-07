<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

function ribuan($string)
{
    if ($string > 0) {
        return number_format($string, 0, ",", ".");
    } else {
        return number_format($string, 0, ",", ".");
    }
}

function pretty_money($n)
{
    // first strip any formatting;
    $n = (0 + str_replace(",", "", $n));

    // is this a number?
    if (!is_numeric($n)) return false;

    // now filter it;
    if ($n >= 1000000000000) return round(($n / 1000000000000), 1) . ' T';
    else if ($n >= 1000000000) return round(($n / 1000000000), 1) . ' M';
    else if ($n >= 1000000) return round(($n / 1000000), 1) . ' Jt';
    else if ($n >= 1000) return round(($n / 1000), 1) . ' Rb';

    return number_format($n);
}

function pretty_money_minus($nilai)
{
    if ($nilai < 0) {
        $hasil = "- " . pretty_money($nilai);
    } else {
        $hasil =  pretty_money($nilai);
    }

    return $hasil;
}

function bulan($bln)
{
    $bulan = array(
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    );
    // $str = substr($bln, 1);
    return $bulan[$bln];
}

function tanggal_indo($tanggal, $cetak_hari = false)
{
    $hari = array(
        1 =>    'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu',
        'Minggu'
    );

    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    $split    = explode('-', $tanggal);
    $tgl_indo = $split[2] . ' ' . $bulan[(int) $split[1]] . ' ' . $split[0];

    if ($cetak_hari) {
        $num = date('N', strtotime($tanggal));
        return $hari[$num] . ', ' . $tgl_indo;
    }
    return $tgl_indo;
}

function tanggal_indo2($str)
{
    $tr = trim($str);
    $str = str_replace(
        array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
        array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'),
        $tr
    );
    return $str;
}

function mysql2phpdatelong($date)
{
    $mysqldate = strtotime($date);
    $phpdate = date('d F Y', $mysqldate);
    if ($phpdate != "01-01-1970") {
        return $phpdate;
    } else {
        return " - ";
    }
}

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($nilai < 12) {
        $temp = " " . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . " belas";
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . " puluh" . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = " seratus" . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . " ratus" . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = " seribu" . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . " ribu" . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . " juta" . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . " milyar" . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . " trilyun" . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = "minus " . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil . ' rupiah';
}

return [
    'id' => 'app-backend',
    'name' => 'ACCOUNTING',
    'timeZone' => 'Asia/Jakarta',
    'language' => 'id',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    //'bootstrap' => ['gii'],
    'bootstrap' => ['debug'],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.*', '209.58.180.2', '36.80.174.127']
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module'

        ],
        'debug' => [
            'class' => 'yii\debug\Module',
            'allowedIPs' => ['127.0.0.1', '::1']
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=internalakuntansi',
            // 'dsn' => 'mysql:host=localhost;dbname=akuntansi_datacoba',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'user' => [
            'identityClass' => 'backend\models\Login',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                //if logs need to save in files                
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning', 'info'],
                    'categories' => ['application'],
                    'logVars' => ['_POST', '_GET'],
                ],

                // if logs need to save in database. You need to create a db table as well.
                [
                    'class' => 'yii\log\DbTarget',
                    'prefix' => function ($message) {
                        $user = Yii::$app->user->identity->nama;
                        return $user;
                    },
                    'levels' => ['info'],
                    'categories' => ['yii\db\Command::execute'], // all database queries
                    'except' => ['application'], // appilcation buang
                    'logVars' => [],

                ],

                //if logs need to send email
                [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error'],
                    'categories' => ['yii\db\*'], // all database queries
                    'message' => [
                        'from' => ['log@example.com'],
                        'to' => ['admin@example.com', 'developer@example.com'],
                        'subject' => 'Database errors at example.com',
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            // use 'site/error' action to display errors
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    //'skin' => 'skin-red',
                ],
            ],
        ],
        'formatter' => [

            'dateFormat' => 'dd-MM-yyyy',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'Rp',
            'class'           => 'yii\i18n\Formatter',
            'defaultTimeZone' => 'Asia/Jakarta',
        ],


        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
    ],
    'as beforeRequest' => [
        'class' => 'yii\filters\AccessControl',
        'rules' => [
            [
                'allow' => true,
                'actions' => ['login'],
            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
        'denyCallback' => function () {
            return Yii::$app->response->redirect(['site/login']);
        },
    ],
    'params' => $params,
];
