<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pessoa".
 *
 * @property int $IdPessoa
 * @property int $IdEndereco
 * @property string $Nome
 * @property int $CPF
 * @property string $DataNascimento
 * @property string $Email
 * @property string $Senha
 * @property string $DataInclusao
 * @property string $IndicadorAtivo
 *
 * @property Aluno[] $alunos
 * @property Endereco $endereco
 * @property Treino[] $treinos
 */
class Pessoa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pessoa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdPessoa', 'IdEndereco', 'Nome', 'CPF', 'DataNascimento', 'Email', 'Senha', 'DataInclusao', 'IndicadorAtivo'], 'required'],
            [['IdPessoa', 'IdEndereco'], 'integer'],
            [['DataNascimento', 'DataInclusao'], 'safe'],
            [['Nome'], 'string', 'max' => 100],
			[['CPF'], 'string', 'max' => 14],
			[['DataNascimento'], 'string', 'max' => 10],
            [['Email'], 'string', 'max' => 45],
            [['Senha'], 'string', 'max' => 255],
            [['IndicadorAtivo'], 'string', 'max' => 1],
            [['IdPessoa'], 'unique'],
            [['IdEndereco'], 'exist', 'skipOnError' => true, 'targetClass' => Endereco::className(), 'targetAttribute' => ['IdEndereco' => 'IdEndereco']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdPessoa' => '#',
            'IdEndereco' => 'Endereço',
            'Nome' => 'Nome',
            'CPF' => 'CPF',
            'DataNascimento' => 'Data de Nascimento',
            'Email' => 'Email',
            'Senha' => 'Senha',
            'DataInclusao' => 'Data de Inclusão',
            'IndicadorAtivo' => 'Ativo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAluno()
    {
        return $this->hasOne(Aluno::className(), ['IdPessoa' => 'IdPessoa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEndereco()
    {
        return $this->hasOne(Endereco::className(), ['IdEndereco' => 'IdEndereco']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreinos()
    {
        return $this->hasMany(Treino::className(), ['IdProfessor' => 'IdPessoa']);
    }
}
