<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "disponibilidade".
 *
 * @property int $IdDisponibilidade
 * @property string $Nome
 *
 * @property Alunodisponibilidade[] $alunodisponibilidades
 */
class Disponibilidade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'disponibilidade';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdDisponibilidade', 'Nome'], 'required'],
            [['IdDisponibilidade'], 'integer'],
            [['Nome'], 'string', 'max' => 7],
            [['IdDisponibilidade'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdDisponibilidade' => 'Id Disponibilidade',
            'Nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlunodisponibilidades()
    {
        return $this->hasMany(AlunoDisponibilidade::className(), ['IdDisponibilidade' => 'IdDisponibilidade']);
    }
}
