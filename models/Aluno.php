<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aluno".
 *
 * @property int $IdAluno
 * @property string $IndicadorDorPeitoAtividadesFisicas
 * @property string $IndicadorDorPeitoUltimoMes
 * @property string $IndicadorPerdaConscienciaTontura
 * @property string $IndicadorProblemaArticular
 * @property string $IndicadorTabagista
 * @property string $IndicadorDiabetico
 * @property string $IndicadorFamiliarAtaqueCardiaco
 * @property string $Lesoes
 * @property string $Observacoes
 * @property string $Objetivos
 * @property string $TreinoEspecifico
 * @property string $IndicadorAtivo
 *
 * @property Pessoa[] $pessoas
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
            [['IndicadorDorPeitoAtividadesFisicas', 'IndicadorDorPeitoUltimoMes', 'IndicadorPerdaConscienciaTontura', 'IndicadorProblemaArticular', 'IndicadorTabagista', 'IndicadorDiabetico', 'IndicadorFamiliarAtaqueCardiaco', 'Lesoes', 'Observacoes', 'Objetivos', 'TreinoEspecifico'], 'required'],
            [['IdAluno'], 'integer'],
            [['IndicadorDorPeitoAtividadesFisicas', 'IndicadorDorPeitoUltimoMes', 'IndicadorPerdaConscienciaTontura', 'IndicadorProblemaArticular', 'IndicadorTabagista', 'IndicadorDiabetico', 'IndicadorFamiliarAtaqueCardiaco', 'IndicadorAtivo'], 'string', 'max' => 1],
            [['Lesoes', 'Observacoes', 'Objetivos', 'TreinoEspecifico'], 'string', 'max' => 200],
            [['IdAluno'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdAluno' => '#',
            'IndicadorDorPeitoAtividadesFisicas' => 'Aluno tem dor no peito provocada por atividades físicas?',
            'IndicadorDorPeitoUltimoMes' => 'Aluno sentiu dor no peito no último mês?',
            'IndicadorPerdaConscienciaTontura' => 'Aluno já perdeu a consciência em alguma ocasião ou sofreu alguma queda em virtude de tontura?',
            'IndicadorProblemaArticular' => 'Aluno tem algum problema ósseo ou articular que poderia agravar-se com a prática de atividades físicas?',
            'IndicadorTabagista' => 'Aluno é tabagista?',
            'IndicadorDiabetico' => 'Aluno é diabético',
            'IndicadorFamiliarAtaqueCardiaco' => 'Aluno possui histórico familiar de ataque cardíaco? (Pai ou irmão de 55 anos ou mãe ou irmã antes dos 65 anos)',
            'Lesoes' => 'Lesões',
            'Observacoes' => 'Observações',
            'Objetivos' => 'Objetivos',
            'TreinoEspecifico' => 'Treino Específico',
            'IndicadorAtivo' => 'Indicador Ativo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPessoas()
    {
        return $this->hasMany(Pessoa::className(), ['IdAluno' => 'IdAluno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreinos()
    {
        return $this->hasMany(Treino::className(), ['IdAluno' => 'IdAluno']);
    }
	
	public function beforeSave($insert)
	{
		if (!parent::beforeSave($insert)) {
			return false;
		}
		
		if ($this->isNewRecord) {
			$connection = Yii::$app->getDb();
			$command = $connection->createCommand("SELECT IFNULL(MAX(IdAluno), 0)+1 AS IdAluno FROM aluno");
			$result = $command->queryOne();
			
			$this->IdAluno = $result['IdAluno'];
			$this->IndicadorAtivo = 'S';
		}
		
		return parent::beforeSave($insert);
	}
}
