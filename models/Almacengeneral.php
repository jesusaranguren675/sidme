<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "almacen_general".
 *
 * @property int $idal_gral
 * @property int $idmedi
 * @property string $descripcion
 * @property int $cantidad
 *
 * @property Medicamentos $idmedi0
 */
class Almacengeneral extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $descripcion;

    public static function tableName()
    {
        return 'almacen_general';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idmedi', 'descripcion', 'cantidad'], 'required'],
            [['idmedi', 'cantidad'], 'default', 'value' => null],
            [['idmedi', 'cantidad'], 'integer'],
            [['descripcion'], 'string', 'max' => 500],
            [['idmedi'], 'exist', 'skipOnError' => true, 'targetClass' => Medicamentos::className(), 'targetAttribute' => ['idmedi' => 'idmedi']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idal_gral' => 'Idal Gral',
            'idmedi' => 'Idmedi',
            'descripcion' => 'Descripcion',
            'cantidad' => 'Cantidad',
        ];
    }

    /**
     * Gets query for [[Idmedi0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getIdmedi0()
    {
        return $this->hasOne(Medicamentos::className(), ['idmedi' => 'idmedi']);
    }
}
