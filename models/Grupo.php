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
	const GRUPOS = ['1' => 'Peito', '2' => 'Costas', '3' => 'Ombros', '4' => 'ABS', '5' => 'Tríceps', '6' => 'Bíceps', '7' => 'Membros Inferiores'];
	
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
	
	public static function getDataProviders($IdTreino = null) {
		if (!empty($IdTreino)) {
			$adicionarParams = true;
			$sqlPeito = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, EXE.Series, EXE.Repeticoes, EXE.Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho AND EXE.IdTreino = :IdTreino INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 1 ORDER BY NomeAparelho';
			$sqlCostas = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, EXE.Series, EXE.Repeticoes, EXE.Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho AND EXE.IdTreino = :IdTreino INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 2 ORDER BY NomeAparelho';
			$sqlOmbros = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, EXE.Series, EXE.Repeticoes, EXE.Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho AND EXE.IdTreino = :IdTreino INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 3 ORDER BY NomeAparelho';
			$sqlABS = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, EXE.Series, EXE.Repeticoes, EXE.Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho AND EXE.IdTreino = :IdTreino INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 4 ORDER BY NomeAparelho';
			$sqlTriceps = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, EXE.Series, EXE.Repeticoes, EXE.Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho AND EXE.IdTreino = :IdTreino INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 5 ORDER BY NomeAparelho';
			$sqlBiceps = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, EXE.Series, EXE.Repeticoes, EXE.Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho AND EXE.IdTreino = :IdTreino INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 6 ORDER BY NomeAparelho';
			$sqlMembrosInferiores = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, EXE.Series, EXE.Repeticoes, EXE.Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho AND EXE.IdTreino = :IdTreino INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 7 ORDER BY NomeAparelho';			
		} else {
			$adicionarParams = false;
			$sqlPeito = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, NULL AS Series, NULL AS Repeticoes, NULL AS Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 1 ORDER BY NomeAparelho';
			$sqlCostas = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, NULL AS Series, NULL AS Repeticoes, NULL AS Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 2 ORDER BY NomeAparelho';
			$sqlOmbros = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, NULL AS Series, NULL AS Repeticoes, NULL AS Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 3 ORDER BY NomeAparelho';
			$sqlABS = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, NULL AS Series, NULL AS Repeticoes, NULL AS Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 4 ORDER BY NomeAparelho';
			$sqlTriceps = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, NULL AS Series, NULL AS Repeticoes, NULL AS Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 5 ORDER BY NomeAparelho';
			$sqlBiceps = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, NULL AS Series, NULL AS Repeticoes, NULL AS Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 6 ORDER BY NomeAparelho';
			$sqlMembrosInferiores = 'SELECT GPO.Nome AS NomeGrupo, AP.Nome as NomeAparelho, AP.IdAparelho, NULL AS Series, NULL AS Repeticoes, NULL AS Peso FROM aparelho AP LEFT JOIN exercicio EXE ON AP.IdAparelho = EXE.IdAparelho INNER JOIN grupo GPO ON AP.IdGrupo = GPO.IdGrupo WHERE GPO.IdGrupo = 7 ORDER BY NomeAparelho';			
		}
			
		$providerPeito = new SqlDataProvider([
			'id' => 'peito',
			'sql' => $sqlPeito,
			'params' => $adicionarParams ? [':IdTreino' => $IdTreino] : [],
			'pagination' => [
				'pageSize' => 100,
			],
			// 'sort' => [
				// 'attributes' => [
					// 'NomeGrupo',
					// 'NomeAparelho',
				// ],
			// ],
		]);
		
		$providerCostas = new SqlDataProvider([
			'id' => 'costas',
			'sql' => $sqlCostas,
			'params' => $adicionarParams ? [':IdTreino' => $IdTreino] : [],
			'pagination' => [
				'pageSize' => 100,
			],
		]);
		
		$providerOmbros = new SqlDataProvider([
			'id' => 'ombros',
			'sql' => $sqlOmbros,
			'params' => $adicionarParams ? [':IdTreino' => $IdTreino] : [],
			'pagination' => [
				'pageSize' => 100,
			],
		]);
		
		$providerABS = new SqlDataProvider([
			'id' => 'abs',
			'sql' => $sqlABS,
			'params' => $adicionarParams ? [':IdTreino' => $IdTreino] : [],
			'pagination' => [
				'pageSize' => 100,
			],
		]);
		
		$providerTriceps = new SqlDataProvider([
			'id' => 'triceps',
			'sql' => $sqlTriceps,
			'params' => $adicionarParams ? [':IdTreino' => $IdTreino] : [],
			'pagination' => [
				'pageSize' => 100,
			],
		]);
		
		$providerBiceps = new SqlDataProvider([
			'id' => 'biceps',
			'sql' => $sqlBiceps,
			'params' => $adicionarParams ? [':IdTreino' => $IdTreino] : [],
			'pagination' => [
				'pageSize' => 100,
			],
		]);
		
		$providerMembrosInferiores = new SqlDataProvider([
			'id' => 'membrosInferiores',
			'sql' => $sqlMembrosInferiores,
			'params' => $adicionarParams ? [':IdTreino' => $IdTreino] : [],
			'pagination' => [
				'pageSize' => 100,
			],
		]);
		
		return [
			[
				'provider' => $providerPeito, 
				'titulo' => 'Peito'
			], 
			[
				'provider' => $providerCostas, 
				'titulo' => 'Costas'
			], 
			[
				'provider' => $providerOmbros, 
				'titulo' => 'Ombros'
			], 
			[
				'provider' => $providerABS, 
				'titulo' => 'ABS'
			], 
			[
				'provider' => $providerTriceps, 
				'titulo' => 'Tríceps'
			], 
			[
				'provider' => $providerBiceps, 
				'titulo' => 'Bíceps'
			], 
			[
				'provider' => $providerMembrosInferiores, 
				'titulo' => 'Membros Inferiores'
			]
		];
	}
}
