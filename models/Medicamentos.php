<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "medicamentos".
 *
 * @property int $idmedi
 * @property string $nombre
 */
class Medicamentos extends \yii\db\ActiveRecord
{
    public $id_detalle_medi;
    public $descripcion;
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
            [['nombre'], 'string', 'max' => 200],
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
}
