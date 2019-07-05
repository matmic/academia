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
            'Series' => 'Series',
            'Repeticoes' => 'Repeticoes',
            'Peso' => 'Peso',
            'IndicadorAtivo' => 'Indicador Ativo',
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
}
