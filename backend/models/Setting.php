<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property int $id_setting
 * @property string $nama
 * @property string $email
 * @property string $alamat
 * @property string $telepon
 * @property string $npwp
 * @property string $direktur
 */
class Setting extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nama', 'email', 'alamat', 'telepon', 'npwp', 'direktur', 'id_kota'], 'required'],
            [['alamat'], 'string'],
            [['nama', 'email', 'npwp', 'direktur', 'nama_usaha', 'fax'], 'string', 'max' => 200],
            [['telepon'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_setting' => 'Id Setting',
            'nama' => 'Nama',
            'email' => 'Email',
            'alamat' => 'Alamat',
            'telepon' => 'Telepon',
            'npwp' => 'Npwp',
            'direktur' => 'Direktur',
            'nama_usaha' => 'Nama Usaha',
            'fax' => 'Fax',
            'id_kota' => 'Kota',
        ];
    }

    public function getkota()
    {
        return $this->hasOne(AktKota::className(), ['id_kota' => 'id_kota']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //if ($this->password != "") {
            //    $this->password = md5($this->password);
            //	//exit;
            //}


            if ($this->foto) {
                $filename = time() . "_" . str_replace(" ", "_", $this->foto->baseName) . '.' . $this->foto->extension;
                $this->foto->saveAs('upload/' . $filename);
                $this->foto = $filename;
            } else {
                $this->foto = "1598935038_GSS.png";
            }
            return true;
        }
    }
}
