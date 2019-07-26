<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "frequencia".
 *
 * @property int $IdFrequencia
 * @property int $IdTreino
 * @property string $DataFrequencia
 *
 * @property Treino $treino
 */
class Frequencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'frequencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdFrequencia', 'IdTreino', 'DataFrequencia'], 'required'],
            [['IdFrequencia', 'IdTreino'], 'integer'],
            [['DataFrequencia'], 'safe'],
            [['IdFrequencia'], 'unique'],
            [['IdTreino'], 'exist', 'skipOnError' => true, 'targetClass' => Treino::className(), 'targetAttribute' => ['IdTreino' => 'IdTreino']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdFrequencia' => 'Id Frequencia',
            'IdTreino' => 'Id Treino',
            'DataFrequencia' => 'Data Frequencia',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreino()
    {
        return $this->hasOne(Treino::className(), ['IdTreino' => 'IdTreino']);
    }
}
