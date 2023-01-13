<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_dis".
 *
 * @property int $iddet_dis
 * @property int $idmedi
 * @property int $iddis
 * @property int $idtipo
 * @property int $destino
 * @property float $cantidad
 */
class Detalledis extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalle_dis';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idmedi', 'iddis', 'idtipo', 'destino', 'cantidad'], 'required'],
            [['idmedi', 'iddis', 'idtipo', 'destino'], 'default', 'value' => null],
            [['idmedi', 'iddis', 'idtipo', 'destino'], 'integer'],
            [['cantidad'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iddet_dis' => 'Iddet Dis',
            'idmedi' => 'Idmedi',
            'iddis' => 'Iddis',
            'idtipo' => 'Idtipo',
            'destino' => 'Destino',
            'cantidad' => 'Cantidad',
        ];
    }
}
