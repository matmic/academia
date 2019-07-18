<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\data\SqlDataProvider;

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
            'Nome' => 'Grupo',
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
	
	public static function getGrupos()
	{
		$grupos = Grupo::find()->orderBy('Nome ASC')->all();
		return ArrayHelper::map($grupos, 'IdGrupo', 'Nome');
	}
	
	public static function getDataProvidersGrupos() {
		$providerPeito = new SqlDataProvider([
			'id' => 'Peito',
			'sql' => 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho FROM aparelho AP INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 1',
			'pagination' => [
				'pageSize' => 100,
			],
		]);
		
		$providerCostas = new SqlDataProvider([
			'id' => 'Costas',
			'sql' => 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho FROM aparelho AP INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 2',
			'pagination' => [
				'pageSize' => 100,
			],
		]);
		
		$providerOmbros = new SqlDataProvider([
			'id' => 'Ombros',
			'sql' => 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho FROM aparelho AP INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 3',
			'pagination' => [
				'pageSize' => 100,
			],
		]);
		
		$providerABS = new SqlDataProvider([
			'id' => 'ABS',
			'sql' => 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho FROM aparelho AP INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 4',
			'pagination' => [
				'pageSize' => 100,
			],
		]);
		
		$providerTriceps = new SqlDataProvider([
			'id' => 'Tríceps',
			'sql' => 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho FROM aparelho AP INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 5',
			'pagination' => [
				'pageSize' => 100,
			],
		]);
		
		$providerBiceps = new SqlDataProvider([
			'id' => 'Bíceps',
			'sql' => 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho FROM aparelho AP INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 6',
			'pagination' => [
				'pageSize' => 100,
			],
		]);
		
		$providerMembrosInferiores = new SqlDataProvider([
			'id' => 'Membros Inferiores',
			'sql' => 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho FROM aparelho AP INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 7',
			'pagination' => [
				'pageSize' => 100,
			],
		]);
		
		return [$providerPeito, $providerCostas, $providerOmbros, $providerABS, $providerTriceps, $providerBiceps, $providerMembrosInferiores];
	}
}
