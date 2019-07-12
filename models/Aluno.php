<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aluno".
 *
 * @property int $IdAluno
 * @property string $Nome
 * @property string $DataNascimento
 * @property string $IndicadorDorPeitoAtividadesFisicas
 * @property string $IndicadorDorPeitoUltimoMes
 * @property string $IndicadorPerdaConscienciaTontura
 * @property string $IndicadorProblemaArticular
 * @property string $IndicadorTabagista
 * @property string $IndicadorDiabetico
 * @property string $IndicadorFamiliarAtaqueCardiaco
 * @property string $Lesoes
 * @property string $Observacoes
 * @property string $TreinoEspecifico
 * @property string $IndicadorAtivo
 * @property int $IdUsuarioInclusao
 * @property string $DataInclusao
 *
 * @property Professor $usuarioInclusao
 * @property Treino[] $treinos
 */
class Aluno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'aluno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdAluno', 'Nome', 'DataNascimento', 'IndicadorDorPeitoAtividadesFisicas', 'IndicadorDorPeitoUltimoMes', 'IndicadorPerdaConscienciaTontura', 'IndicadorProblemaArticular', 'IndicadorTabagista', 'IndicadorDiabetico', 'IndicadorFamiliarAtaqueCardiaco', 'IndicadorAtivo', 'IdUsuarioInclusao', 'DataInclusao'], 'required'],
            [['IdAluno', 'IdUsuarioInclusao'], 'integer'],
            [['DataNascimento', 'DataInclusao'], 'safe'],
            [['Nome'], 'string', 'max' => 100],
            [['IndicadorDorPeitoAtividadesFisicas', 'IndicadorDorPeitoUltimoMes', 'IndicadorPerdaConscienciaTontura', 'IndicadorProblemaArticular', 'IndicadorTabagista', 'IndicadorDiabetico', 'IndicadorFamiliarAtaqueCardiaco', 'IndicadorAtivo'], 'string', 'max' => 1],
            [['Lesoes', 'Observacoes', 'TreinoEspecifico'], 'string', 'max' => 200],
            [['IdAluno'], 'unique'],
            [['IdUsuarioInclusao'], 'exist', 'skipOnError' => true, 'targetClass' => Professor::className(), 'targetAttribute' => ['IdUsuarioInclusao' => 'IdProfessor']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdAluno' => '#',
            'Nome' => 'Nome',
            'DataNascimento' => 'Data de Nascimento',
            'IndicadorDorPeitoAtividadesFisicas' => 'Indicador Dor Peito Atividades Fisicas',
            'IndicadorDorPeitoUltimoMes' => 'Indicador Dor Peito Ultimo Mes',
            'IndicadorPerdaConscienciaTontura' => 'Indicador Perda Consciencia Tontura',
            'IndicadorProblemaArticular' => 'Indicador Problema Articular',
            'IndicadorTabagista' => 'Indicador Tabagista',
            'IndicadorDiabetico' => 'Indicador Diabetico',
            'IndicadorFamiliarAtaqueCardiaco' => 'Indicador Familiar Ataque Cardiaco',
            'Lesoes' => 'Lesoes',
            'Observacoes' => 'Observacoes',
            'TreinoEspecifico' => 'Treino Especifico',
            'IndicadorAtivo' => 'Indicador Ativo',
            'IdUsuarioInclusao' => 'Id Usuario Inclusao',
            'DataInclusao' => 'Data Inclusao',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarioInclusao()
    {
        return $this->hasOne(Professor::className(), ['IdProfessor' => 'IdUsuarioInclusao']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreinos()
    {
        return $this->hasMany(Treino::className(), ['IdAluno' => 'IdAluno']);
    }
}
