<?php
namespace app\commands;

use app\models\User;
use yii\console\Controller;

class CreateUserController extends Controller
{
	/**
	 * Syntax:
	 * ./yii create-user
	 */
    public function actionIndex()
    {
        $names = [
            'admin',
            'user',
        ];
        foreach ($names as $name) {
            $user = User::findOneCreateNew([
                'username' => $name,
				'email' => "$name@example.com",
            ]);
            $user->password = $name;
            $user->save();
        }
    }
}