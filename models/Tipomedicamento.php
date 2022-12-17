<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_medicamento".
 *
 * @property int $idtipo
 * @property string $descripcion
 */
class Tipomedicamento extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_medicamento';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'required'],
            [['descripcion'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idtipo' => 'Idtipo',
            'descripcion' => 'Descripcion',
        ];
    }
}
