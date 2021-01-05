<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;

/**
 * This is the model class for table "foto".
 *
 * @property int $id_foto
 * @property string $nama_tabel
 * @property int $id_tabel
 * @property string $foto
 */
class Foto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'foto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama_tabel', 'id_tabel', 'foto'], 'required'],
            [['id_tabel'], 'integer'],
            [['nama_tabel'], 'string', 'max' => 1000],
            [['foto'], 'string', 'max' => 1000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_foto' => 'Id Foto',
            'nama_tabel' => 'Nama Tabel',
            'id_tabel' => 'Id Tabel',
            'foto' => 'Foto',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            
            $path = \Yii::getAlias("@backend/web/upload/");
            
            $data = Foto::findOne($this->id_foto);
            $currentFile1 = "";
            if ($data)
            {
                $currentFile1 = $data->foto;
            }
            
            $image1 = UploadedFile::getInstance($this, 'foto');

            //echo var_dump($_FILES['foto']); exit;
            
            if (file_exists($_FILES['foto']['tmp_name']))
            {
                $strFile = str_replace(" ","_",$_FILES['foto']['name']);
                $strFile = explode(".",$strFile);               
                $filename1 = time()."_".$strFile[0].".".strtolower($strFile[1]);
                move_uploaded_file($_FILES['foto']['tmp_name'], $path . $filename1);
                $this->foto = $filename1;   

				
                
                //echo $filename1." xxxx"; exit;
            }
            else
            {
                $this->foto = $currentFile1;
                ///echo $filename1." yyyy"; exit;
            }
			

            return true;
        } else {
            return false;
        }
    }
}
