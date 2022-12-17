<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entradas_medicamentos".
 *
 * @property int $identrada
 * @property string $descripcion
 * @property int $idusu
 */
class Entradasmedicamentos extends \yii\db\ActiveRecord
{
    public $idmedi;
    public $idtipo;
    public $idsede;
    public $cantidad;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entradas_medicamentos';
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
            //'identrada'             => 'Identrada',
            'descripcion'           => 'Descripción',
            //'idusu'                 => 'Idusu',
            'idmedi'                => 'Medicamento',
            'idtipo'                => 'Presentación',
            'idsede'                => 'Procedencia',

        ];
    }
}
