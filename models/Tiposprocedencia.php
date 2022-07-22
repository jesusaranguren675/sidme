<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipos_procedencia".
 *
 * @property int $id_tipo_procedencia
 * @property string $nombre_tipo_procedencia
 */
class Tiposprocedencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipos_procedencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_tipo_procedencia'], 'required'],
            [['nombre_tipo_procedencia'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo_procedencia' => Yii::t('app', 'Id Tipo Procedencia'),
            'nombre_tipo_procedencia' => Yii::t('app', 'Nombre Tipo Procedencia'),
        ];
    }
}
