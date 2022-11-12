<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "detalle_medi".
 *
 * @property int $id_detalle_medi
 * @property int $idmedi
 * @property int $idtipo
 */
class Detallemedi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'detalle_medi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idmedi', 'idtipo'], 'required'],
            [['idmedi', 'idtipo'], 'default', 'value' => null],
            [['idmedi', 'idtipo'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_detalle_medi' => 'Id Detalle Medi',
            'idmedi' => 'Idmedi',
            'idtipo' => 'Idtipo',
        ];
    }
}
