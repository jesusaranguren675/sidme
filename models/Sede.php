<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sede".
 *
 * @property int $idsede
 * @property string $nombre
 * @property string $ubicacion
 * @property string $telefono
 * @property string $correo
 */
class Sede extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sede';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'ubicacion', 'telefono', 'correo'], 'required'],
            [['nombre', 'ubicacion', 'telefono', 'correo'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idsede' => 'Idsede',
            'nombre' => 'Nombre',
            'ubicacion' => 'Ubicacion',
            'telefono' => 'Telefono',
            'correo' => 'Correo',
        ];
    }
}
