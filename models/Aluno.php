<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "aluno".
 *
 * @property int $IdAluno
 * @property string $Nome
 * @property string $DataNascimento
 * @property string $IndicadorDorPeitoAtividadesFisicas
 * @property string $IndicadorDorPeitoUltimoMes
 * @property string $IndicadorPerdaConscienciaTontura
 * @property string $IndicadorProblemaArticular
 * @property string $IndicadorTabagista
 * @property string $IndicadorDiabetico
 * @property string $IndicadorFamiliarAtaqueCardiaco
 * @property string $Lesoes
 * @property string $Observacoes
 * @property string $TreinoEspecifico
 * @property string $IndicadorAtivo
 * @property int $IdUsuarioInclusao
 * @property string $DataInclusao
 *
 * @property Professor $usuarioInclusao
 * @property Treino[] $treinos
 */
class Aluno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aluno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdAluno', 'Nome', 'DataNascimento', 'IndicadorDorPeitoAtividadesFisicas', 'IndicadorDorPeitoUltimoMes', 'IndicadorPerdaConscienciaTontura', 'IndicadorProblemaArticular', 'IndicadorTabagista', 'IndicadorDiabetico', 'IndicadorFamiliarAtaqueCardiaco', 'IndicadorAtivo', 'IdUsuarioInclusao', 'DataInclusao'], 'required'],
            [['IdAluno', 'IdUsuarioInclusao'], 'integer'],
            [['DataNascimento', 'DataInclusao'], 'safe'],
            [['Nome'], 'string', 'max' => 100],
            [['IndicadorDorPeitoAtividadesFisicas', 'IndicadorDorPeitoUltimoMes', 'IndicadorPerdaConscienciaTontura', 'IndicadorProblemaArticular', 'IndicadorTabagista', 'IndicadorDiabetico', 'IndicadorFamiliarAtaqueCardiaco', 'IndicadorAtivo'], 'string', 'max' => 1],
            [['Lesoes', 'Observacoes', 'TreinoEspecifico'], 'string', 'max' => 200],
            [['IdAluno'], 'unique'],
            [['IdUsuarioInclusao'], 'exist', 'skipOnError' => true, 'targetClass' => Professor::className(), 'targetAttribute' => ['IdUsuarioInclusao' => 'IdProfessor']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdAluno' => '#',
            'Nome' => 'Nome',
            'DataNascimento' => 'Data de Nascimento',
            'IndicadorDorPeitoAtividadesFisicas' => 'Aluno tem dor no peito provocada por atividades físicas?',
            'IndicadorDorPeitoUltimoMes' => 'Aluno sentiu dor no peito no último mês?',
            'IndicadorPerdaConscienciaTontura' => 'Aluno perdeu a consciência em alguma ocasião ou soreu alguma queda em virtude de tontura?',
            'IndicadorProblemaArticular' => 'Aluno tem algum problema ósseo ou articular que poderia agravar-se com a prática de atividades físicas?',
            'IndicadorTabagista' => 'Aluno é tabagista?',
            'IndicadorDiabetico' => 'Aluno é diabético?',
            'IndicadorFamiliarAtaqueCardiaco' => 'Histórico familiar de ataque cardíaco? (pai ou irmão de 55 anos ou mãe ou irmã antes dos 65 anos)',
            'Lesoes' => 'Lesões',
            'Observacoes' => 'Observações',
            'TreinoEspecifico' => 'Treino Específico',
            'IndicadorAtivo' => 'Ativo?',
            'IdUsuarioInclusao' => 'Usuário Inclusão',
            'DataInclusao' => 'Data de Inclusão',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioInclusao()
    {
        return $this->hasOne(Professor::className(), ['IdProfessor' => 'IdUsuarioInclusao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreinos()
    {
        return $this->hasMany(Treino::className(), ['IdAluno' => 'IdAluno']);
    }
	
	public function beforeValidate() {
		if (!parent::beforeValidate()) {
			return false;
		}
		
		if ($this->isNewRecord) {
			$connection = Yii::$app->getDb();
			$command = $connection->createCommand("SELECT IFNULL(MAX(IdAluno), 0)+1 AS IdAluno FROM aluno");
			$result = $command->queryOne();
			
			$this->IdAluno = $result['IdAluno'];
			$this->IndicadorAtivo = '1';
			$this->DataInclusao = new Expression('NOW()');
			$this->IdUsuarioInclusao = Yii::$app->user->getId();
		}
		
		if (trim($this->Lesoes) == '') {
			$this->Lesoes = null;
		}
		
		if (trim($this->Observacoes) == '') {
			$this->Observacoes = null;
		}
		
		if (trim($this->TreinoEspecifico) == '') {
			$this->TreinoEspecifico = null;
		}
		
		if ($this->IndicadorAtivo == 'Sim') {
			$this->IndicadorAtivo = '1';
		} else {
			$this->IndicadorAtivo = '0';
		}
		
		return parent::beforeValidate();
	}
	
	public function afterFind() {
		if ($this->IndicadorAtivo == '1') {
			$this->IndicadorAtivo = 'Sim';
		} else {
			$this->IndicadorAtivo = 'Não';
		}
		
		//$this->DataInclusao = (\DateTime::createFromFormat('Y-m-d', $this->DataInclusao))->format('d/m/Y');
		//$this->DataNascimento = (\DateTime::createFromFormat('Y-m-d', $this->DataNascimento))->format('d/m/Y');

		return parent::afterFind();
	}
}
