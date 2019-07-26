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
}
