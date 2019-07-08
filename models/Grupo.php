<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "grupo".
 *
 * @property int $IdGrupo
 * @property string $Nome
 *
 * @property Aparelho[] $aparelhos
 */
class Grupo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['Nome'], 'required'],
            [['IdGrupo'], 'integer'],
            [['Nome'], 'string', 'max' => 20],
            [['IdGrupo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdGrupo' => '#',
            'Nome' => 'Nome',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAparelhos()
    {
        return $this->hasMany(Aparelho::className(), ['IdGrupo' => 'IdGrupo']);
    }
	
	public function beforeSave($insert)
	{
		if (!parent::beforeSave($insert)) {
			return false;
		}
		
		if ($this->isNewRecord) {
			$connection = Yii::$app->getDb();
			$command = $connection->createCommand("SELECT IFNULL(MAX(IdGrupo), 0)+1 AS IdGrupo FROM grupo");
			$result = $command->queryOne();
			
			$this->IdGrupo = $result['IdGrupo'];
		}
		
		return parent::beforeSave($insert);
	}
}
