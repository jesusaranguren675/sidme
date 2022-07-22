<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "presentaciones".
 *
 * @property int $id_presentacion
 * @property string $nombre_presentacion
 */
class Presentaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'presentaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_presentacion'], 'required'],
            [['nombre_presentacion'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_presentacion' => Yii::t('app', 'Presentación'),
            'nombre_presentacion' => Yii::t('app', 'Nombre Presentacion'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PresentacionesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PresentacionesQuery(get_called_class());
    }
}
