<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "professor".
 *
 * @property int $IdProfessor
 * @property string $Nome
 * @property string $Email
 * @property string $Senha
 * @property string $DataInclusao
 * @property string $IndicadorAtivo
 * @property string $TentativasLogin
 *
 * @property Aluno[] $alunos
 * @property Treino[] $treinos
 */
class Professor extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'professor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdProfessor', 'Nome', 'Email', 'Senha', 'DataInclusao', 'IndicadorAtivo', 'DataHoraUltimaAtu'], 'required'],
            [['IdProfessor', 'TentativasLogin'], 'integer'],
            [['DataInclusao', 'DataHoraUltimaAtu'], 'safe'],
            [['Nome'], 'string', 'max' => 100],
            [['Email'], 'string', 'max' => 45],
            [['Senha'], 'string', 'max' => 255],
            [['IndicadorAtivo'], 'string', 'max' => 1],
            [['IdProfessor'], 'unique'],
			[['Email'], 'unique']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdProfessor' => '#',
            'Nome' => 'Nome',
            'Email' => 'Email',
            'Senha' => 'Senha',
            'DataInclusao' => 'Data de Inclusão',
            'IndicadorAtivo' => 'Ativo?',
			'DataHoraUltimaAtu' => 'Data da Última Alteração',
            'TentativasLogin' => 'Tentativas de Login',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResetpasswords()
    {
        return $this->hasMany(Resetpassword::className(), ['IdProfessor' => 'IdProfessor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlunos()
    {
        return $this->hasMany(Aluno::className(), ['IdProf' => 'IdProfessor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreinos()
    {
        return $this->hasMany(Treino::className(), ['IdProfessor' => 'IdProfessor']);
    }
	
	public function beforeValidate()
	{
		if (!parent::beforeValidate()) {
			return false;
		}
		
		$dataAtual = new Expression('NOW()');
		
		if ($this->isNewRecord) {
			$connection = Yii::$app->getDb();
			$command = $connection->createCommand("SELECT IFNULL(MAX(IdProfessor), 0)+1 AS IdProfessor FROM professor");
			$result = $command->queryOne();
			
			$this->IdProfessor = $result['IdProfessor'];
			$this->IndicadorAtivo = '1';
			$this->DataInclusao = $dataAtual;
		}
		
		$this->DataHoraUltimaAtu = $dataAtual;
		
		return parent::beforeValidate();
	}
	
	public function afterFind() 
	{
		if ($this->IndicadorAtivo == '1') {
			$this->IndicadorAtivo = 'Sim';
		} else {
			$this->IndicadorAtivo = 'Não';
		}
		
		//$this->DataInclusao = (\DateTime::createFromFormat('Y-m-d', $this->DataInclusao))->format('d/m/Y');

		return parent::afterFind();
	}
	
	/**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->IdProfessor;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        //return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        //return $this->getAuthKey() === $authKey;
    }
	
	public static function getProfessores() {
		return ArrayHelper::map(Professor::find()->where(['IndicadorAtivo' => '1'])->orderBy('Nome ASC')->all(), 'IdProfessor', 'Nome');
	}
}
