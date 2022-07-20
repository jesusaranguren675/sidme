<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medi_alma_x_pre".
 *
 * @property int $id_medi_alma_x_pre
 * @property int $id_medicamento_almacen
 * @property int $id_presentacion
 * @property float $stock
 */
class Medialmaxpre extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'medi_alma_x_pre';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_medicamento_almacen', 'id_presentacion', 'stock'], 'required'],
            [['id_medicamento_almacen', 'id_presentacion'], 'default', 'value' => null],
            [['id_medicamento_almacen', 'id_presentacion'], 'integer'],
            [['stock'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_medi_alma_x_pre' => Yii::t('app', 'Id Medi Alma X Pre'),
            'id_medicamento_almacen' => Yii::t('app', 'Id Medicamento Almacen'),
            'id_presentacion' => Yii::t('app', 'Id Presentacion'),
            'stock' => Yii::t('app', 'Stock'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return MedialmaxpreQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MedialmaxpreQuery(get_called_class());
    }
}
