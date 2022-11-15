<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pedidos".
 *
 * @property int $idpedi
 * @property string $descripcion
 * @property int $idusu
 */
class Pedidos extends \yii\db\ActiveRecord
{
    public $idsede;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pedidos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'idusu'], 'required'],
            [['idusu'], 'default', 'value' => null],
            [['idusu'], 'integer'],
            [['descripcion'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idpedi' => 'Idpedi',
            'descripcion' => 'Descripcion',
            'idusu' => 'Idusu',
        ];
    }
}
