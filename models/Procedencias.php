<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procedencias".
 *
 * @property int $id_procedencia
 * @property string $nombre_procedencia
 * @property int $id_tipo_procedencia
 */
class Procedencias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'procedencias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_procedencia', 'id_tipo_procedencia'], 'required'],
            [['id_tipo_procedencia'], 'default', 'value' => null],
            [['id_tipo_procedencia'], 'integer'],
            [['nombre_procedencia'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_procedencia' => Yii::t('app', 'Id Procedencia'),
            'nombre_procedencia' => Yii::t('app', 'Nombre Procedencia'),
            'id_tipo_procedencia' => Yii::t('app', 'Id Tipo Procedencia'),
        ];
    }
}
