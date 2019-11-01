<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "resetpassword".
 *
 * @property int $IdResetPassword
 * @property string $Email
 * @property string $Hash
 * @property string $DataExpiracao
 */
class ResetPassword extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'resetpassword';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['IdResetPassword', 'Email', 'Hash', 'DataExpiracao'], 'required'],
            [['IdResetPassword'], 'integer'],
            [['DataExpiracao'], 'safe'],
            [['Email'], 'string', 'max' => 45],
            [['Hash'], 'string', 'max' => 256],
            [['IdResetPassword'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'IdResetPassword' => 'Id Reset Password',
            'Email' => 'Email',
            'Hash' => 'Hash',
            'DataExpiracao' => 'Data Expiracao',
        ];
    }

    public function beforeValidate()
    {
        if (!parent::beforeValidate()) {
            return false;
        }

        if ($this->isNewRecord) {
            $connection = Yii::$app->getDb();
            $command = $connection->createCommand("SELECT IFNULL(MAX(IdResetPassword), 0)+1 AS IdResetPassword FROM resetpassword");
            $result = $command->queryOne();

            $this->IdResetPassword = $result['IdResetPassword'];
        }

        return parent::beforeValidate();
    }

    public static function DeletarHashsDoEmail($Email) {
        $hashs = ResetPassword::find()->where(['Email' => $Email])->all();

        foreach ($hashs as $hash) {
            $hash->delete();
        }
    }
}
