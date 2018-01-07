<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use yii\console\Controller;
use app\models\User;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class InitAdminController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        $username = 'admin';
        $user = User::findOne(['username' => $username]);
        if (!$user) {
            $user = new User([
                'username' => $username,
                'password' => 'password',
            ]);
            $user->generateAuthKey();
            $user->generatePasswordResetToken();
            if (!$user->save()) {
                echo "Cannot create user\n";
                print_r($user->getErrors());
            }
        }
    }
}
