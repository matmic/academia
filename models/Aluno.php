<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "aluno".
 *
 * @property int $IdAluno
 * @property int $IdPessoa
 * @property string $IndicadorDorPeitoAtividadesFisicas
 * @property string $IndicadorDorPeitoUltimoMes
 * @property string $IndicadorPerdaConscienciaTontura
 * @property string $IndicadorProblemaArticular
 * @property string $IndicadorTabagista
 * @property string $IndicadorDiabetico
 * @property string $IndicadorFamiliarAtaqueCardiaco
 * @property string $Lesoes
 * @property string $Observacoes
 * @property string $Objetivos
 * @property string $TreinoEspecifico
 * @property string $IndicadorAtivo
 *
 * @property Pessoa $pessoa
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
            [['IdAluno', 'IdPessoa', 'IndicadorDorPeitoAtividadesFisicas', 'IndicadorDorPeitoUltimoMes', 'IndicadorPerdaConscienciaTontura', 'IndicadorProblemaArticular', 'IndicadorTabagista', 'IndicadorDiabetico', 'IndicadorFamiliarAtaqueCardiaco', 'Lesoes', 'Observacoes', 'Objetivos', 'TreinoEspecifico', 'IndicadorAtivo'], 'required'],
            [['IdAluno', 'IdPessoa'], 'integer'],
            [['IndicadorDorPeitoAtividadesFisicas', 'IndicadorDorPeitoUltimoMes', 'IndicadorPerdaConscienciaTontura', 'IndicadorProblemaArticular', 'IndicadorTabagista', 'IndicadorDiabetico', 'IndicadorFamiliarAtaqueCardiaco', 'IndicadorAtivo'], 'string', 'max' => 1],
            [['Lesoes', 'Observacoes', 'Objetivos', 'TreinoEspecifico'], 'string', 'max' => 200],
            [['IdAluno'], 'unique'],
            [['IdPessoa'], 'exist', 'skipOnError' => true, 'targetClass' => Pessoa::className(), 'targetAttribute' => ['IdPessoa' => 'IdPessoa']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdAluno' => 'Id Aluno',
            'IdPessoa' => 'Id Pessoa',
            'IndicadorDorPeitoAtividadesFisicas' => 'Indicador Dor Peito Atividades Fisicas',
            'IndicadorDorPeitoUltimoMes' => 'Indicador Dor Peito Ultimo Mes',
            'IndicadorPerdaConscienciaTontura' => 'Indicador Perda Consciencia Tontura',
            'IndicadorProblemaArticular' => 'Indicador Problema Articular',
            'IndicadorTabagista' => 'Indicador Tabagista',
            'IndicadorDiabetico' => 'Indicador Diabetico',
            'IndicadorFamiliarAtaqueCardiaco' => 'Indicador Familiar Ataque Cardiaco',
            'Lesoes' => 'Lesoes',
            'Observacoes' => 'Observacoes',
            'Objetivos' => 'Objetivos',
            'TreinoEspecifico' => 'Treino Especifico',
            'IndicadorAtivo' => 'Indicador Ativo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPessoa()
    {
        return $this->hasOne(Pessoa::className(), ['IdPessoa' => 'IdPessoa']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreinos()
    {
        return $this->hasMany(Treino::className(), ['IdAluno' => 'IdAluno']);
    }
}
