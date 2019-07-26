<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alunodisponibilidade".
 *
 * @property int $IdAlunoDisponibilidade
 * @property int $IdAluno
 * @property int $IdDisponibilidade
 *
 * @property Aluno $aluno
 * @property Disponibilidade $disponibilidade
 */
class AlunoDisponibilidade extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alunodisponibilidade';
    }

    public static function excluirDisponibilidadesDoAluno($IdAluno) {
        return AlunoDisponibilidade::deleteAll('IdAluno = ' . $IdAluno);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdAlunoDisponibilidade', 'IdAluno', 'IdDisponibilidade'], 'required'],
            [['IdAlunoDisponibilidade', 'IdAluno', 'IdDisponibilidade'], 'integer'],
            [['IdAlunoDisponibilidade'], 'unique'],
            [['IdAluno'], 'exist', 'skipOnError' => true, 'targetClass' => Aluno::className(), 'targetAttribute' => ['IdAluno' => 'IdAluno']],
            [['IdDisponibilidade'], 'exist', 'skipOnError' => true, 'targetClass' => Disponibilidade::className(), 'targetAttribute' => ['IdDisponibilidade' => 'IdDisponibilidade']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdAlunoDisponibilidade' => 'Id Aluno Disponibilidade',
            'IdAluno' => 'Id Aluno',
            'IdDisponibilidade' => 'Id Disponibilidade',
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
    public function getDisponibilidade()
    {
        return $this->hasOne(Disponibilidade::className(), ['IdDisponibilidade' => 'IdDisponibilidade']);
    }
	
	public static function getDisponibilidadesDoAluno($IdAluno) {
		
		$alunoDisponibilidades = AlunoDisponibilidade::find()->where(['IdAluno' => $IdAluno])->all();
		$arrAlunoDisponibilidades = array();
		
		foreach ($alunoDisponibilidades as $alunoDisponibilidade) {
			$arrAlunoDisponibilidades[] = $alunoDisponibilidade->IdDisponibilidade;
		}
		
		return $arrAlunoDisponibilidades;
	}

    public function beforeValidate() {
        if (!parent::beforeValidate()) {
            return false;
        }

        if ($this->isNewRecord) {
            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("SELECT IFNULL(MAX(IdAlunoDisponibilidade), 0)+1 AS IdAlunoDisponibilidade FROM alunodisponibilidade");
            $result = $command->queryOne();

            $this->IdAlunoDisponibilidade = $result['IdAlunoDisponibilidade'];
        }

        return parent::beforeValidate();
    }
}
