<?php
namespace app\commands;

use app\models\User;
use yii\console\Controller;

class CreateUserController extends Controller
{
    public function actionIndex()
    {
        $names = [
            'admin',
            'user',
        ];
        foreach ($names as $name) {
            $user = User::findOneCreateNew([
                'username' => $name,
            ]);
            $user->save();
        }
    }
}