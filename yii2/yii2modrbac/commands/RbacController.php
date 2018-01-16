<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
       //Create permissions
        //$permission = $auth->createPermission("permission_name");
        //$permission->description = "Description"; //option
        //$auth->add($permission);

        //Create roles
        //$role = $auth->createRole("role_name");
        //$auth->add($role);
        //$auth->addChild($role, $permission); //add permission to roles
        //$auth->addChild($role, $role1); //add all permision from role1 to role
        $this->actionUserRole();
        $this->actionPMRole();
        $this->actionManagerRole();
        $this->actionAdminRole();
        $this->assignRole("admin",1);
    }
    public function actionUserRole(){
        // add role "user"
        $this->createRole("user");
    }
    public function actionManagerRole(){
        $user = $this->createRole("user");
         // add role manager
        $manager = $this->createRole('manager');
        $this->addChild($manager,$user);
    }
    public function actionAdminRole(){
        $this->createRole("admin");
    }
    public function actionPMRole(){
        $this->createRole("pm");
    }
    function createRole($roleName){
         $auth = Yii::$app->authManager;
         $role = $auth->getRole($roleName);
         if(!$role){
             $role = $auth->createRole($roleName);
             $auth->add($role);
         }
         return $role;
    }
    function addChild($role, $child){
         $auth = Yii::$app->authManager;
         $auth->addChild($role, $child);
    }
    function assignRole($roleName, $id){
        $auth = Yii::$app->authManager;
        $role = $this->createRole($roleName);
        $auth->assign($role,$id);
    }
}
