<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medicamentos".
 *
 * @property int $idmedi
 * @property string $nombre
 *
 * @property AlmacenGeneral[] $almacenGenerals
 * @property DetalleMedi[] $detalleMedis
 */
class Medicamentos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medicamentos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idmedi' => 'Idmedi',
            'nombre' => 'Nombre',
        ];
    }

    /**
     * Gets query for [[AlmacenGenerals]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlmacenGenerals()
    {
        return $this->hasMany(AlmacenGeneral::className(), ['idmedi' => 'idmedi']);
    }

    /**
     * Gets query for [[DetalleMedis]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDetalleMedis()
    {
        return $this->hasMany(DetalleMedi::className(), ['idmedi' => 'idmedi']);
    }
}
