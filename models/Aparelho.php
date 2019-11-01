<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aparelho".
 *
 * @property int $IdAparelho
 * @property int $IdGrupo
 * @property string $Nome
 *
 * @property Grupo $grupo
 * @property Exercicio[] $exercicios
 */
class Aparelho extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aparelho';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdGrupo', 'Nome'], 'required'],
            [['IdAparelho', 'IdGrupo'], 'integer'],
            [['Nome'], 'string', 'max' => 45],
            [['IdAparelho'], 'unique'],
            [['IdGrupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupo::className(), 'targetAttribute' => ['IdGrupo' => 'IdGrupo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdAparelho' => '#',
            'IdGrupo' => 'Grupo',
            'Nome' => 'Exercício',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(Grupo::className(), ['IdGrupo' => 'IdGrupo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExercicios()
    {
        return $this->hasMany(Exercicio::className(), ['IdAparelho' => 'IdAparelho']);
    }
	
	public function beforeSave($insert)
	{
		if (!parent::beforeSave($insert)) {
			return false;
		}
		
		if ($this->isNewRecord) {
			$connection = Yii::$app->getDb();
			$command = $connection->createCommand("SELECT IFNULL(MAX(IdAparelho), 0)+1 AS IdAparelho FROM aparelho");
			$result = $command->queryOne();
			
			$this->IdAparelho = $result['IdAparelho'];
		}
		
		return parent::beforeSave($insert);
	}
	
	public function isSet($IdTreino) {
		return 10;
	}
}
