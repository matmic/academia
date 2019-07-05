<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aparelho".
 *
 * @property int $IdAparelho
 * @property int $IdGrupo
 * @property string $Nome
 *
 * @property Grupo $grupo
 * @property Exercicio[] $exercicios
 */
class Aparelho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aparelho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdAparelho', 'IdGrupo', 'Nome'], 'required'],
            [['IdAparelho', 'IdGrupo'], 'integer'],
            [['Nome'], 'string', 'max' => 45],
            [['IdAparelho'], 'unique'],
            [['IdGrupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupo::className(), 'targetAttribute' => ['IdGrupo' => 'IdGrupo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdAparelho' => 'Id Aparelho',
            'IdGrupo' => 'Id Grupo',
            'Nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(Grupo::className(), ['IdGrupo' => 'IdGrupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExercicios()
    {
        return $this->hasMany(Exercicio::className(), ['IdAparelho' => 'IdAparelho']);
    }
}
