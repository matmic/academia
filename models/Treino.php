<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "treino".
 *
 * @property int $IdTreino
 * @property int $IdAluno
 * @property string $Nome
 * @property int $IdProfessor
 * @property string $DataInclusao
 * @property string $IndicadorAtivo
 *
 * @property Exercicio[] $exercicios
 * @property Aluno $aluno
 * @property Pessoa $professor
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
            [['IdTreino', 'IdAluno', 'Nome', 'IdProfessor', 'DataInclusao', 'IndicadorAtivo'], 'required'],
            [['IdTreino', 'IdAluno', 'IdProfessor'], 'integer'],
            [['DataInclusao'], 'safe'],
            [['Nome'], 'string', 'max' => 45],
            [['IndicadorAtivo'], 'string', 'max' => 1],
            [['IdTreino'], 'unique'],
            [['IdAluno'], 'exist', 'skipOnError' => true, 'targetClass' => Aluno::className(), 'targetAttribute' => ['IdAluno' => 'IdAluno']],
            [['IdProfessor'], 'exist', 'skipOnError' => true, 'targetClass' => Pessoa::className(), 'targetAttribute' => ['IdProfessor' => 'IdPessoa']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdTreino' => 'Id Treino',
            'IdAluno' => 'Id Aluno',
            'Nome' => 'Nome',
            'IdProfessor' => 'Id Professor',
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
        return $this->hasOne(Pessoa::className(), ['IdPessoa' => 'IdProfessor']);
    }
}
