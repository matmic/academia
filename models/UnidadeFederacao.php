<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "unidade_federacao".
 *
 * @property int $IdUnidadeFederacao
 * @property string $Nome
 * @property string $Sigla
 *
 * @property Endereco[] $enderecos
 */
class UnidadeFederacao extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'unidade_federacao';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdUnidadeFederacao', 'Nome', 'Sigla'], 'required'],
            [['IdUnidadeFederacao'], 'integer'],
            [['Nome'], 'string', 'max' => 30],
            [['Sigla'], 'string', 'max' => 2],
            [['IdUnidadeFederacao'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdUnidadeFederacao' => 'Código do IBGE',
            'Nome' => 'Nome',
            'Sigla' => 'Sigla',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnderecos()
    {
        return $this->hasMany(Endereco::className(), ['IdUnidadeFederacao' => 'IdUnidadeFederacao']);
    }
}
