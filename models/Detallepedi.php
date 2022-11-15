<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_pedi".
 *
 * @property int $iddet_ped
 * @property int $idpedi
 * @property int $idmedi
 * @property int $idtipo
 * @property int $procedencia
 * @property float $cantidad
 */
class Detallepedi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'detalle_pedi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idpedi', 'idmedi', 'idtipo', 'procedencia', 'cantidad'], 'required'],
            [['idpedi', 'idmedi', 'idtipo', 'procedencia'], 'default', 'value' => null],
            [['idpedi', 'idmedi', 'idtipo', 'procedencia'], 'integer'],
            [['cantidad'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'iddet_ped' => 'Iddet Ped',
            'idpedi' => 'Idpedi',
            'idmedi' => 'Idmedi',
            'idtipo' => 'Idtipo',
            'procedencia' => 'Procedencia',
            'cantidad' => 'Cantidad',
        ];
    }
}
