<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "treino".
 *
 * @property int $IdTreino
 * @property int $IdProfessor
 * @property int $IdAluno
 * @property string $Nome
 * @property string $Objetivos
 * @property string $DataInclusao
 * @property string $IndicadorAtivo
 *
 * @property Exercicio[] $exercicios
 * @property Aluno $aluno
 * @property Professor $professor
 */
class Treino extends \yii\db\ActiveRecord
{
	/**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'treino';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdTreino', 'IdProfessor', 'IdAluno', 'DataInclusao', 'IndicadorAtivo', 'DataHoraUltimaAtu'], 'required'],
            [['IdTreino', 'IdProfessor', 'IdAluno'], 'integer'],
            [['DataInclusao', 'DataHoraUltimaAtu'], 'safe'],
            [['Nome'], 'string', 'max' => 45],
            [['Objetivos'], 'string', 'max' => 200],
            [['IndicadorAtivo'], 'string', 'max' => 1],
            [['IdTreino'], 'unique'],
            [['IdAluno'], 'exist', 'skipOnError' => true, 'targetClass' => Aluno::className(), 'targetAttribute' => ['IdAluno' => 'IdAluno']],
            [['IdProfessor'], 'exist', 'skipOnError' => true, 'targetClass' => Professor::className(), 'targetAttribute' => ['IdProfessor' => 'IdProfessor']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdTreino' => '#',
            'IdProfessor' => 'Professor',
            'IdAluno' => 'Aluno',
            'Nome' => 'Treino',
            'Objetivos' => 'Objetivos',
            'DataInclusao' => 'Data de Inclusão',
            'IndicadorAtivo' => 'Ativo?',
			'DataHoraUltimaAtu' => 'Data da Última Alteração',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExercicios()
    {
        return $this->hasMany(Exercicio::className(), ['IdTreino' => 'IdTreino']);
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
    public function getProfessor()
    {
        return $this->hasOne(Professor::className(), ['IdProfessor' => 'IdProfessor']);
    }
	
	/** 
    * @return \yii\db\ActiveQuery 
    */ 
	public function getFrequencia() 
	{ 
		return $this->hasMany(Frequencia::className(), ['IdTreino' => 'IdTreino']); 
	}
	
	public function beforeValidate() {
		if (!parent::beforeValidate()) {
			return false;
		}
		
		$dataAtual = new Expression('NOW()');
		
		if ($this->isNewRecord) {
			$connection = Yii::$app->getDb();
			$command = $connection->createCommand("SELECT IFNULL(MAX(IdTreino), 0)+1 AS IdTreino FROM treino");
			$result = $command->queryOne();
			
			$this->IdTreino = $result['IdTreino'];
			$this->IndicadorAtivo = '1';
			$this->DataInclusao = $dataAtual;
		}
		
		$this->DataHoraUltimaAtu = $dataAtual;
		
		if (trim($this->Objetivos) == '') {
			$this->Objetivos = null;
		}
		
		if (trim($this->Nome) == '') {
			$this->Nome = null;
		}
		
		return parent::beforeValidate();
	}
	
	public function afterFind() {
		if ($this->IndicadorAtivo == '1') {
			$this->IndicadorAtivo = 'Sim';
		} else {
			$this->IndicadorAtivo = 'Não';
		}

        if ($this->Nome == null) {
            $this->Nome = '';
        }

        if ($this->Objetivos == null) {
            $this->Objetivos = '';
        }
		
		$this->DataInclusao = isset($this->DataInclusao) ? (\DateTime::createFromFormat('Y-m-d', $this->DataInclusao))->format('d/m/Y') : '';

		return parent::afterFind();
	}
}
