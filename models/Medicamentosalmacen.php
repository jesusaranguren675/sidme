<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medicamentos_almacen".
 *
 * @property int $id_medicamento_almacen
 * @property string $nombre_medicamento_almacen
 */
class Medicamentosalmacen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medicamentos_almacen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_medicamento_almacen'], 'required'],
            [['nombre_medicamento_almacen'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_medicamento_almacen' => Yii::t('app', 'Id Medicamento Almacen'),
            'nombre_medicamento_almacen' => Yii::t('app', 'Nombre Medicamento Almacen'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MedicamentosalmacenQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MedicamentosalmacenQuery(get_called_class());
    }
}
