<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignacion_roles".
 *
 * @property int $id_asig_rol
 * @property int $id_rol
 * @property int $id_usu
 * @property string $fecha
 */
class Asignacionroles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asignacion_roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_rol', 'id_usu', 'fecha'], 'required'],
            [['id_rol', 'id_usu'], 'default', 'value' => null],
            [['id_rol', 'id_usu'], 'integer'],
            [['fecha'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_asig_rol' => 'Id Asig Rol',
            'id_rol' => 'Id Rol',
            'id_usu' => 'Id Usu',
            'fecha' => 'Fecha',
        ];
    }
}
