<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dat_device".
 *
 * @property string $id
 * @property integer $id_user
 * @property string $code
 * @property string $registration
 * @property string $brand
 * @property string $model
 * @property string $active
 * @property string $lat
 * @property string $lon
 * @property string $created_at
 * @property string $updated_at
 * @property string $time
 *
 * @property DatUser $idUser
 */
class DatDevice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dat_device';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'code'], 'required'],
            [['id_user'], 'integer'],
            [['code', 'registration', 'brand', 'model', 'lat', 'lon'], 'string', 'max' => 256],
            [['active', 'created_at', 'updated_at', 'time'], 'string', 'max' => 45],
            [['code'], 'unique'],
            [['id_user'], 'exist', 'skipOnError' => true, 'targetClass' => DatUser::className(), 'targetAttribute' => ['id_user' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_user' => 'Id User',
            'code' => 'Code',
            'registration' => 'Registration',
            'brand' => 'Brand',
            'model' => 'Model',
            'active' => 'Active',
            'lat' => 'Lat',
            'lon' => 'Lon',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'time' => 'Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(DatUser::className(), ['id' => 'id_user']);
    }
}
