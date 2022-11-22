<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property int $id_rol
 * @property string $nombre_rol
 * @property string|null $create_at
 * @property string|null $update_at
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_rol'], 'required'],
            [['create_at', 'update_at'], 'safe'],
            [['nombre_rol'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_rol' => 'Id Rol',
            'nombre_rol' => 'Nombre Rol',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
        ];
    }
}
