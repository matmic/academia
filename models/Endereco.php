<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "endereco".
 *
 * @property int $IdEndereco
 * @property int $IdUnidadeFederacao
 * @property string $Logradouro
 * @property string $Numero
 * @property string $Complemento
 * @property string $Bairro
 * @property string $Cidade
 *
 * @property UnidadeFederacao $unidadeFederacao
 * @property Pessoa[] $pessoas
 */
class Endereco extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'endereco';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdEndereco', 'IdUnidadeFederacao', 'Logradouro', 'Numero', 'Bairro', 'Cidade'], 'required'],
            [['IdEndereco', 'IdUnidadeFederacao'], 'integer'],
            [['Logradouro', 'Cidade'], 'string', 'max' => 45],
            [['Numero', 'Complemento'], 'string', 'max' => 10],
            [['Bairro'], 'string', 'max' => 20],
            [['IdEndereco'], 'unique'],
            [['IdUnidadeFederacao'], 'exist', 'skipOnError' => true, 'targetClass' => UnidadeFederacao::className(), 'targetAttribute' => ['IdUnidadeFederacao' => 'IdUnidadeFederacao']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdEndereco' => '#',
            'IdUnidadeFederacao' => 'Unidade da Federação',
            'Logradouro' => 'Logradouro',
            'Numero' => 'Número',
            'Complemento' => 'Complemento',
            'Bairro' => 'Bairro',
            'Cidade' => 'Cidade',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUnidadeFederacao()
    {
        return $this->hasOne(UnidadeFederacao::className(), ['IdUnidadeFederacao' => 'IdUnidadeFederacao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPessoas()
    {
        return $this->hasMany(Pessoa::className(), ['IdEndereco' => 'IdEndereco']);
    }
}
