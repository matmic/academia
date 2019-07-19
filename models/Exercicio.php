<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exercicio".
 *
 * @property int $IdExercicio
 * @property int $IdTreino
 * @property int $IdAparelho
 * @property int $Series
 * @property int $Repeticoes
 * @property string $Peso
 * @property string $IndicadorAtivo
 *
 * @property Treino $treino
 * @property Aparelho $aparelho
 */
class Exercicio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exercicio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdExercicio', 'IdTreino', 'IdAparelho', 'Series', 'Repeticoes', 'Peso', 'IndicadorAtivo'], 'required'],
            [['IdExercicio', 'IdTreino', 'IdAparelho', 'Series', 'Repeticoes'], 'integer'],
            [['Peso'], 'string', 'max' => 3],
            [['IndicadorAtivo'], 'string', 'max' => 1],
            [['IdExercicio'], 'unique'],
            [['IdTreino'], 'exist', 'skipOnError' => true, 'targetClass' => Treino::className(), 'targetAttribute' => ['IdTreino' => 'IdTreino']],
            [['IdAparelho'], 'exist', 'skipOnError' => true, 'targetClass' => Aparelho::className(), 'targetAttribute' => ['IdAparelho' => 'IdAparelho']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdExercicio' => 'Id Exercicio',
            'IdTreino' => 'Id Treino',
            'IdAparelho' => 'Id Aparelho',
            'Series' => 'Séries',
            'Repeticoes' => 'Repetições',
            'Peso' => 'Peso',
            'IndicadorAtivo' => 'Ativo?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreino()
    {
        return $this->hasOne(Treino::className(), ['IdTreino' => 'IdTreino']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAparelho()
    {
        return $this->hasOne(Aparelho::className(), ['IdAparelho' => 'IdAparelho']);
    }
	
	public function beforeValidate()
	{
		if (!parent::beforeValidate()) {
			return false;
		}
		
		if ($this->isNewRecord) {
			$connection = Yii::$app->getDb();
			$command = $connection->createCommand("SELECT IFNULL(MAX(IdExercicio), 0)+1 AS IdExercicio FROM exercicio");
			$result = $command->queryOne();
			
			$this->IdExercicio = $result['IdExercicio'];
			$this->IndicadorAtivo = '1';
		}
		
		if (trim($this->Series) == '') {
			$this->Series = '0';
		}
		
		if (trim($this->Repeticoes) == '') {
			$this->Repeticoes = '0';
		}
		
		if (trim($this->Peso) == '') {
			$this->Peso = '0';
		}
		
		return parent::beforeValidate();
	}
	
	public static function DeletarExerciciosDoTreino($IdTreino) {
		return Exercicio::deleteAll('IdTreino = ' . $IdTreino);
	}
}
