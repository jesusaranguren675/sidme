<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distribucion".
 *
 * @property int $iddis
 * @property int $idusu
 * @property string $descripcion
 */
class Distribucion extends \yii\db\ActiveRecord
{
    public $idsede;
    public $cantidad;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'distribucion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['idusu', 'descripcion'], 'required'],
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
            'iddis' => 'Iddis',
            'idusu' => 'Idusu',
            'descripcion' => 'Descripción',
        ];
    }
}
