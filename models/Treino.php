<?php

namespace app\models;

use Yii;

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
            [['IdTreino', 'IdProfessor', 'IdAluno', 'DataInclusao', 'IndicadorAtivo'], 'required'],
            [['IdTreino', 'IdProfessor', 'IdAluno'], 'integer'],
            [['DataInclusao'], 'safe'],
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
            'IdTreino' => 'Id Treino',
            'IdProfessor' => 'Id Professor',
            'IdAluno' => 'Id Aluno',
            'Nome' => 'Nome',
            'Objetivos' => 'Objetivos',
            'DataInclusao' => 'Data Inclusao',
            'IndicadorAtivo' => 'Indicador Ativo',
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
}
