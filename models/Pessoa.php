<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "pessoa".
 *
 * @property int $IdPessoa
 * @property int $IdEndereco
 * @property int $IdAluno
 * @property string $Nome
 * @property int $CPF
 * @property string $DataNascimento
 * @property string $Email
 * @property string $Senha
 * @property string $DataInclusao
 * @property string $IndicadorAtivo
 *
 * @property Aluno $aluno
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
            [['IdEndereco', 'Nome', 'CPF', 'DataNascimento', 'Email', 'Senha'], 'required'],
            [['IdPessoa', 'IdEndereco', 'IdAluno'], 'integer'],
            [['DataNascimento', 'DataInclusao'], 'safe'],
            [['Nome'], 'string', 'max' => 100],
            [['Email'], 'string', 'max' => 45],
            [['Senha'], 'string', 'max' => 255],
            [['IndicadorAtivo'], 'string', 'max' => 1],
            [['IdPessoa'], 'unique'],
            [['IdAluno'], 'exist', 'skipOnError' => true, 'targetClass' => Aluno::className(), 'targetAttribute' => ['IdAluno' => 'IdAluno']],
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
            'IdEndereco' => 'Id Endereco',
            'IdAluno' => 'É aluno?',
            'Nome' => 'Nome',
            'CPF' => 'CPF',
            'DataNascimento' => 'Data de Nascimento',
            'Email' => 'Email',
            'Senha' => 'Senha',
            'DataInclusao' => 'Data Inclusao',
            'IndicadorAtivo' => 'Indicador Ativo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAluno()
    {
        return $this->hasOne(Aluno::className(), ['IdAluno' => 'IdAluno']);
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
	
	public function beforeSave($insert)
	{
		if (!parent::beforeSave($insert)) {
			return false;
		}
		
		if ($this->isNewRecord) {
			$connection = Yii::$app->getDb();
			$command = $connection->createCommand("SELECT IFNULL(MAX(IdPessoa), 0)+1 AS IdPessoa FROM pessoa");
			$result = $command->queryOne();
			
			$this->IdPessoa = $result['IdPessoa'];
			$this->DataInclusao = new Expression('NOW()');
			$this->IndicadorAtivo = 'S';
		}
		
		return parent::beforeSave($insert);
	}
}
