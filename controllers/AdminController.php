<?php


namespace app\controllers;


use app\models\CreateRoleForm;
use app\models\Phone;
use app\models\RoleBase;
use app\models\UpdatePermissionForm;
use app\models\UpdateRoleForm;
use app\models\User;
use app\models\UserBase;
use app\models\UserCreateForm;
use Yii;
use yii\web\Controller;
use function Symfony\Component\Finder\name;

class AdminController extends Controller
{
    public function actionIndex(){

        $urls=["roles"=>"Роли", "permissions"=>"Разрешения", "users"=>"Пользователи"];

        return $this->render('index', compact('urls'));

}

    public function actionRoles(){


        $auth = Yii::$app->authManager;
       $roles = $auth->getRoles();
       $rolesBased=[];
       foreach ($roles as $r){
           $permissions=$auth->getPermissionsByRole($r->name);
           $rBase= new RoleBase();
           $rBase->name=$r->name;
           $rBase->description=$r->description;
           $rBase->permissions=$permissions;
           $rolesBased[]=$rBase;
       }

       $assignmentTable=$auth->assignmentTable;
        return $this->render('roles', compact('roles', 'assignmentTable', 'rolesBased'));

    }

    public function actionRole(){
        $name = Yii::$app->request->get('name');
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        $oldpermissions=$auth->getPermissionsByRole($name);
        $oldPermis=[];
        foreach ($oldpermissions as $key=>$val){
            $oldPermis[$key]=$key;
        }



        if(Yii::$app->request->post()){
          $post=Yii::$app->request->post();
          $newPerms = $post["UpdateRoleForm"]["permissions"];
          $newDesc= $post["UpdateRoleForm"]["description"];
          if($newDesc){
              $role->description=$newDesc;
              $auth->update($name, $role);

          }
          if($newPerms){
              foreach ($newPerms as $p){
                  $newPerm = $auth->getPermission($p);
                  if(!in_array($p, $oldPermis)){
                      $auth->addChild($role, $newPerm);
                  }
              }
              foreach ($oldPermis as $p){
                  if(!in_array($p, $newPerms)){
                      $permForDel = $auth->getPermission($p);
                      $auth->removeChild($role, $permForDel);
                  }
              }
          } else{
              foreach ($oldPermis as $p){
                  $permForDel = $auth->getPermission($p);
                      $auth->removeChild($role, $permForDel);
              }
          }

          $this->redirect(['roles']);
        }

        $rolePermissions=$auth->getPermissionsByRole($name);
        $rolePerms=[];
        foreach ($rolePermissions as $key=>$val){
            $rolePerms[$key]=$key;
        }
        //модель для вьюшки
        $model = new UpdateRoleForm();
        //установка параметров модели
        $model->name=$name;
        $model->permissions=$rolePerms;
        //получение всех доступных разрешений
        $permissions = $auth->getPermissions();
        $perms=[];
        foreach($permissions as $key=>$val){
            $perms[$key]=$key;
        }


        if($name){
            return $this->render('role', compact('name', 'perms', 'model', 'oldpermissions'));
        }



    }

    public function actionPermission(){

        $name = Yii::$app->request->get('name');
        $auth = Yii::$app->authManager;
        $perm = $auth->getPermission($name);
        $model = new UpdatePermissionForm();
        $model->name=$name;
        $model->description=$perm->description;
        $post=Yii::$app->request->post();

        if($post){
            print_r( $post["UpdatePermissionForm"]["description"]);
            $perm->description=$post["UpdatePermissionForm"]["description"];
            $auth->update($name, $perm);
            $this->redirect(['permissions']);

        }

        return $this->render('permission', compact('name', 'model'));
    }

    public function actionPermissions(){


        $auth = Yii::$app->authManager;
        $perms = $auth->getPermissions();
        return $this->render('permissions', compact('perms'));

    }


    public function actionAddRole(){

        $model = new CreateRoleForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($model->name);

            if(!$role){
                try{
                    $newRole = $auth->createRole($model->name);
                    $newRole->description = $model->description;
                    $auth->add($newRole);
                    return "Роль успешно добавлена";
                }catch(\Throwable $e) {
                    throw $e;
                }
            }else{
                return "Такая роль уже существует";
            }
        }

        return $this->render('createRolePermission', compact('model', ));

    }

    public function actionAddPermission(){

        $model = new CreateRoleForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $auth = Yii::$app->authManager;
            $permission = $auth->getPermission($model->name);
            if(!$permission){
                try{
                    $newPermission = $auth->createPermission($model->name);
                    $newPermission->description = $model->description;
                    $auth->add($newPermission);
                    $this->redirect(['permissions']);
                }catch(\Throwable $e) {
                    throw $e;
                }
            }else{
                return "Такое разрешение уже существует";
            }

        }
        return $this->render('createRolePermission', compact('model'));

    }

    public function actionUsers(){

        $auth = Yii::$app->authManager;

        $allUsers = User::find()->orderBy(['id' => SORT_ASC])->all();
        $users = [];
        foreach ($allUsers as $u){
            $user = new UserBase();
            $user->id=$u->id;
            $user->username=$u->username;
            $userRoles=$auth->getAssignments($u->id);
            $uroles=[];
            foreach ($userRoles as $key=>$val){
                $uroles[$key]=$key;
            }
            $user->roles=$uroles;
            $users[]=$user;
        }

        return $this->render('users', compact('users'));
    }


    public function actionUserUpdate(){
        $message=null;
        $userId = Yii::$app->request->get('id');
        $auth = Yii::$app->authManager;
        $userRoles=$auth->getAssignments($userId);
        $uroles=[];
        foreach ($userRoles as $key=>$val){
            $uroles[$key]=$key;
        }
        $allRoles=$auth->getRoles();
        $roles=[];
        foreach ($allRoles as $r){
            $roles[$r->name]=$r->name;
        }
        $model = new UserCreateForm();
        $user = User::findOne(['id'=>$userId]);
        $model->id=$user->id;
        $model->username=$user->username;
        $model->roles=$uroles;

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $post = Yii::$app->request->post();
            if(isset($post['UserCreateForm']['roles']) && isset($post['UserCreateForm']['password'])  && isset($post['UserCreateForm']['repassword'])){
                $newUserRoles= $post['UserCreateForm']['roles'];
                $password = $post['UserCreateForm']['password'];
                $repassword = $post['UserCreateForm']['repassword'];

                if($newUserRoles){
                    foreach ($newUserRoles as $r){
                        if(!in_array($r, $uroles)){
                            $role=$auth->getRole($r);
                            $auth->assign($role, $userId);
                        };
                        foreach ($uroles as $oldrole){
                            if(!in_array($oldrole, $newUserRoles)){
                                $role=$auth->getRole($oldrole);
                                $auth->revoke($role, $userId);
                            };
                        }
                    }
                }else{
                    foreach ($uroles as $oldrole){
                        $role=$auth->getRole($oldrole);
                        $auth->revoke($role, $userId);
                    }
                }
                if($password and $repassword){
                    if($password = $repassword){
                        $user->password=$password;
                        $user->save();

                    }
                }

                $this->redirect(['users']);

            }
            if(isset($post['UserCreateForm']['phone'])){
                $newPhonePost=$post['UserCreateForm']['phone'];
                $userPhone= Phone::findOne(['userid'=>$userId, 'phone'=>$newPhonePost]);
                if($userPhone){
                    if($newPhonePost != $userPhone->phone){
                        $newPhone = new Phone();
                        $newPhone->phone = $post['UserCreateForm']['phone'];
                        $newPhone->userid = $userId;
                        $newPhone->save();
                    }else {
                        $message = "такой номер уже есть";
                    }
                }else{
                    $newPhone = new Phone();
                    $newPhone->phone = $post['UserCreateForm']['phone'];
                    $newPhone->userid = $userId;
                    $newPhone->save();
                }


            }

        }
        $userPhones= Phone::find(['userid'=>$userId])->all();



        return $this->render('userUpdate', compact('userId', 'model', 'user', 'roles', 'userRoles', 'userPhones', 'message'));
    }


    public function actionAddUser(){
        $model = new UserCreateForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
           $username = Yii::$app->request->post()['UserCreateForm']['username'];
           $password = Yii::$app->request->post()['UserCreateForm']['password'];
          $newUser = new User();
          $newUser->username=$username;
            $newUser->password=$password;
            $newUser->save();
        }

        return $this->render('userCreate', compact('model'));
    }

    public function actionDelPhone(){
        if(Yii::$app->request->get('id')){
            $phoneId = Yii::$app->request->get('id');

            $phone = Phone::findOne(['id'=> $phoneId]);
            if($phone){
                $userId=$phone->userid;
                $phone->delete();
                $this->redirect(['user-update', 'id'=>$userId]);
            }


        }


    }



}