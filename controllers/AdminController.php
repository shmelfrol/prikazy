<?php


namespace app\controllers;


use app\models\CreateRoleForm;
use app\models\Index;
use app\models\IndexCreateForm;
use app\models\Ldap;
use app\models\LdapForm;
use app\models\Phone;
use app\models\Prikaz;
use app\models\RoleBase;
use app\models\UpdatePermissionForm;
use app\models\UpdateRoleForm;
use app\models\User;
use app\models\UserBase;
use app\models\UserCreateForm;
use app\models\UserUpdateForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use function Codeception\Lib\all;


class AdminUrl
{
    public $url;
    public $name;
    public $img;
}


class AdminController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {

        $roles = new AdminUrl();
        $roles->url = 'roles';
        $roles->name = "Роли";
        $roles->img = '/images/roles.png';

        $permissions = new AdminUrl();
        $permissions->url = 'permissions';
        $permissions->name = "Разрешения";
        $permissions->img = '/images/perms.png';

        $users = new AdminUrl();
        $users->url = 'users';
        $users->name = "Пользователи";
        $users->img = '/images/users.png';


        $ldap = new AdminUrl();
        $ldap->url = 'ldap';
        $ldap->name = "LDAP";
        $ldap->img = '/images/users.png';


//        $indexes = new AdminUrl();
//        $indexes->url = 'indexes';
//        $indexes->name = "Индексы Приказов";
//        $indexes->img = '/images/users.png';
        $urls = [$roles, $permissions, $users, $ldap];

        //$urls = ["roles" => "Роли", "permissions" => "Разрешения", "users" => "Пользователи"];

        return $this->render('index', compact('urls'));

    }

    public function actionRoles()
    {


        $auth = Yii::$app->authManager;
        $roles = $auth->getRoles();
        $rolesBased = [];
        foreach ($roles as $r) {
            $permissions = $auth->getPermissionsByRole($r->name);
            $rBase = new RoleBase();
            $rBase->name = $r->name;
            $rBase->description = $r->description;
            $rBase->permissions = $permissions;
            $rolesBased[] = $rBase;
        }

        $assignmentTable = $auth->assignmentTable;
        return $this->render('roles', compact('roles', 'assignmentTable', 'rolesBased'));

    }

    public function actionRole()
    {
        $name = Yii::$app->request->get('name');
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($name);
        $oldpermissions = $auth->getPermissionsByRole($name);
        $oldPermis = [];
        foreach ($oldpermissions as $key => $val) {
            $oldPermis[$key] = $key;
        }


        if (Yii::$app->request->post()) {
            $post = Yii::$app->request->post();
            $newPerms = $post["UpdateRoleForm"]["permissions"];
            $newDesc = $post["UpdateRoleForm"]["description"];
            if ($newDesc) {
                $role->description = $newDesc;
                $auth->update($name, $role);
            }
            if ($newPerms) {
                foreach ($newPerms as $p) {
                    $newPerm = $auth->getPermission($p);
                    if (!in_array($p, $oldPermis)) {
                        $auth->addChild($role, $newPerm);
                    }
                }
                foreach ($oldPermis as $p) {
                    if (!in_array($p, $newPerms)) {
                        $permForDel = $auth->getPermission($p);
                        $auth->removeChild($role, $permForDel);
                    }
                }
            } else {
                foreach ($oldPermis as $p) {
                    $permForDel = $auth->getPermission($p);
                    $auth->removeChild($role, $permForDel);
                }
            }

            $this->redirect(['roles']);
        }

        $rolePermissions = $auth->getPermissionsByRole($name);
        $rolePerms = [];
        foreach ($rolePermissions as $key => $val) {
            $rolePerms[$key] = $key;
        }
        //модель для вьюшки
        $model = new UpdateRoleForm();
        //установка параметров модели
        $model->name = $name;
        $model->permissions = $rolePerms;
        //получение всех доступных разрешений
        $permissions = $auth->getPermissions();
        $perms = [];
        foreach ($permissions as $key => $val) {
            $perms[$key] = $key;
        }


        if ($name) {
            return $this->render('role', compact('name', 'perms', 'model', 'oldpermissions'));
        }


    }

    public function actionAddRole()
    {
        $model = new CreateRoleForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($model->name);
            if (!$role) {
                try {
                    $newRole = $auth->createRole($model->name);
                    $newRole->description = $model->description;
                    $auth->add($newRole);
                    return "Роль успешно добавлена";
                } catch (\Throwable $e) {
                    throw $e;
                }
            } else {
                return "Такая роль уже существует";
            }
        }

        return $this->render('createRolePermission', compact('model',));

    }

    public function actionDelRole()
    {
        $name = Yii::$app->request->get('name');
        //роль admin нельзя удалять
        if ($name !== 'admin') {
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($name);
            //return print_r($role);

            if ($role) {
                //сначала удалеям разрешения, которые прикреплены к роли
                $perms = $auth->getPermissionsByRole($name);
                foreach ($perms as $p) {
                    $auth->removeChild($role, $p);
                }
                // затем находим пользователей с этой ролью и удаляем эту роль у пользователй
                $users = $auth->getUserIdsByRole($name);
                foreach ($users as $key => $userId) {
                    $auth->revoke($role, $userId);
                }

            }
            // теперь можно удалить роль
            $auth->remove($role);
        }else{ return "Роль администратора системы нельзя удалять";}
        $this->redirect(['roles']);

    }

    public function actionPermission()
    {

        $name = Yii::$app->request->get('name');
        $auth = Yii::$app->authManager;
        $perm = $auth->getPermission($name);
        $model = new UpdatePermissionForm();
        $model->name = $name;
        $model->description = $perm->description;
        $post = Yii::$app->request->post();

        if ($post) {
            print_r($post["UpdatePermissionForm"]["description"]);
            $perm->description = $post["UpdatePermissionForm"]["description"];
            $auth->update($name, $perm);
            $this->redirect(['permissions']);

        }

        return $this->render('permission', compact('name', 'model'));
    }

    public function actionPermissions()
    {


        $auth = Yii::$app->authManager;
        $perms = $auth->getPermissions();
        return $this->render('permissions', compact('perms'));

    }


    public function actionAddPermission()
    {
        $model = new CreateRoleForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $auth = Yii::$app->authManager;
            $permission = $auth->getPermission($model->name);
            if (!$permission) {
                try {
                    $newPermission = $auth->createPermission($model->name);
                    $newPermission->description = $model->description;
                    $auth->add($newPermission);
                    $this->redirect(['permissions']);
                } catch (\Throwable $e) {
                    throw $e;
                }
            } else {
                return "Такое разрешение уже существует";
            }

        }
        return $this->render('createRolePermission', compact('model'));

    }

    public function actionDelPermission(){
        $name = Yii::$app->request->get('name');
        $auth = Yii::$app->authManager;
        $perm = $auth->getPermission($name);
        if($perm){
            $allRoles=$auth->getRoles();
            //сначала во всех ролях убираем связь с разрешением
            foreach ($allRoles as $r){
                $permsByRole= $auth->getPermissionsByRole($r->name);
                foreach ($permsByRole as $p){
                    if($p->name === $name){
                        $auth->removeChild($r, $p);
                        return "ok";
                    }
                }

            }
            $auth->remove($perm);
            $this->redirect(['permissions']);

        }
    }

    public function actionUsers()
    {

        $auth = Yii::$app->authManager;

        $allUsers = User::find()->orderBy(['id' => SORT_ASC])->all();
        $users = [];
        foreach ($allUsers as $u) {
            $user = new UserBase();
            $user->id = $u->id;
            $user->username = $u->username;
            $userRoles = $auth->getAssignments($u->id);
            $uroles = [];
            foreach ($userRoles as $key => $val) {
                $uroles[$key] = $key;
            }
            $user->roles = $uroles;
            $users[] = $user;
        }

        return $this->render('users', compact('users'));
    }


    public function actionUserUpdate()
    {
        $message = null;
        $userId = Yii::$app->request->get('id');
        $auth = Yii::$app->authManager;
        $userRoles = $auth->getAssignments($userId);
        $uroles = [];
        foreach ($userRoles as $key => $val) {
            $uroles[$key] = $key;
        }
        $allRoles = $auth->getRoles();
        $roles = [];
        foreach ($allRoles as $r) {
            $roles[$r->name] = $r->name;
        }
        $model = new UserUpdateForm();
        $user = User::findOne(['id' => $userId]);
        $model->id = $user->id;
        $model->username = $user->username;
        $model->roles = $uroles;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->roles || $model->password || $model->repassword)
                if ($model->roles) {
                    foreach ($model->roles as $r) {
                        if (!in_array($r, $uroles)) {
                            $role = $auth->getRole($r);
                            $auth->assign($role, $userId);
                        };
                        foreach ($uroles as $oldrole) {
                            if (!in_array($oldrole, $model->roles)) {
                                $role = $auth->getRole($oldrole);
                                $auth->revoke($role, $userId);
                            };
                        }
                    }
                } else {
                    foreach ($uroles as $oldrole) {
                        $role = $auth->getRole($oldrole);
                        $auth->revoke($role, $userId);
                    }
                }

            if ($model->password === $model->repassword) {
                $user->password = $model->password;
                $user->save();
            }

            $this->redirect(['users']);


            if (isset($post['UserCreateForm']['phone'])) {
                $newPhonePost = $post['UserCreateForm']['phone'];
                $userPhone = Phone::findOne(['userid' => $userId, 'phone' => $newPhonePost]);
                if ($userPhone) {
                    if ($newPhonePost != $userPhone->phone) {
                        $newPhone = new Phone();
                        $newPhone->phone = $post['UserCreateForm']['phone'];
                        $newPhone->userid = $userId;
                        $newPhone->save();
                    } else {
                        $message = "такой номер уже есть";
                    }
                } else {
                    $newPhone = new Phone();
                    $newPhone->phone = $post['UserCreateForm']['phone'];
                    $newPhone->userid = $userId;
                    $newPhone->save();
                }


            }

        }
        $userPhones = Phone::find(['userid' => $userId])->all();


        return $this->render('userUpdate', compact('userId', 'model', 'user', 'roles', 'userRoles', 'userPhones', 'message'));
    }


    public function actionAddUser()
    {
        $model = new UserCreateForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            Yii::$app->session->setFlash('success', 'User registered!');
            $this->redirect(['users']);
        }

        return $this->render('userCreate', compact('model'));
    }

    public function actionDelUser()
    {
        $userId = Yii::$app->request->get('id');
        if ($userId) {
            $user = User::findOne(['id' => $userId]);
            if ($user) {
                if($user->username !== 'admin'){
                    $auth = Yii::$app->authManager;
                    $userRoles = $auth->getAssignments($userId);
                    foreach ($userRoles as $r) {
                        // return print_r( $role);
                        $role = $auth->getRole($r->roleName);
                        $auth->revoke($role, $userId);
                    }
                    $user->delete();
                }else{return "Учетную запись администратора системы удалять нельзя";}

            }


        }
        $this->redirect(['users']);
    }

    public function actionDelPhone()
    {
        if (Yii::$app->request->get('id')) {
            $phoneId = Yii::$app->request->get('id');

            $phone = Phone::findOne(['id' => $phoneId]);
            if ($phone) {
                $userId = $phone->userid;
                $phone->delete();
                $this->redirect(['user-update', 'id' => $userId]);
            }


        }


    }

    public function  actionLdap(){

        $model = new LdapForm();

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $ldap= new Ldap();
            $ldap->account_suffix=$model->account_suffix;
            $ldap->hosts= $model->hosts;
            $ldap->base_dn= $model->base_dn;
            $ldap->username= $model->username;
            $ldap->password= $model->password;
            $ldap->turnon= $model->turnon;
            $ldap->save();
        }



        return $this->render('ldap', compact('model',));
    }



    public function actionIndexes(){

        $indexes=Index::find()->all();
        return $this->render('indexes', compact('indexes'));
    }


    public function actionAddIndex(){
        $model = new IndexCreateForm();


        if(Yii::$app->request->isPost){
            $post=Yii::$app->request->post();
            $model->load($post);
            if (!$model->validate()) {
                var_dump($model->getErrors());
                die();
            }

            if(!$model->isold){
                $model->isold=false;
            }
            $indx= new Index();
            $indx->symbol=$model->symbol;
            $indx->description=$model->description;
            $indx->isold=$model->isold;
            $indx->created_at= $time=time();
            $currentUser=Yii::$app->user->id;
            $indx->created_by=$currentUser;
            $indx->isold=$model->isold;
            $indx->save();

            $this->redirect(['indexes']);
        }

        return $this->render('addIndex', compact('model'));
    }

    public function actionDelIndex($id){

        if($id){
          $index=Index::findOne($id);
          if($index){
              $prikazez=Prikaz::find()->where(['index_id'=>$id])->all();
              if(!$prikazez){
                  $index->delete();

              }
          }

        }

        $this->redirect(['indexes']);

    }


}