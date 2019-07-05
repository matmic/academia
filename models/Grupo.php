<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupo".
 *
 * @property int $IdGrupo
 * @property string $Nome
 *
 * @property Aparelho[] $aparelhos
 */
class Grupo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdGrupo', 'Nome'], 'required'],
            [['IdGrupo'], 'integer'],
            [['Nome'], 'string', 'max' => 20],
            [['IdGrupo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdGrupo' => 'Id Grupo',
            'Nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAparelhos()
    {
        return $this->hasMany(Aparelho::className(), ['IdGrupo' => 'IdGrupo']);
    }
}
