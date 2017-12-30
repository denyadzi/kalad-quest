<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\models\User;
use yii\helpers\Url;

/**
 * User administration commands
 */
class UserController extends Controller
{
    /**
     * Стварыць новага карыстальніка
     *
     * @param string $username унікальны username карыстальніка
     * @param string|null $password пароль; калі пусты, то аўтазгенераваць
     * @param int $role роля карыстальніка
     */
    public function actionCreate($username, $password = null, $role = User::ROLE_USER)
    {
        if ( ! $password) {
            $password = Yii::$app->security->generateRandomString();
        }
        $user = new User([
            'username' => $username,
            'password' => $password,
            'role' => $role,
        ]);

        if ( ! $user->save()) {
            echo "Карыстальнік ня створаны. Памылкі ва ўваходных звестках\n";
            foreach ($user->errors as $attr => $errors) {
                echo "Атрыбут $attr:\n";
                foreach ($errors as $error) {
                    echo "\t- $error;\n";
                }
            }
            echo "Паўтарыце, калі ласка, яшчэ раз з выпраўленымі звесткамі.\n";
        } else {
            echo "Створаны карыстальнік з id: {$user->id}, username: {$user->username}\n";
        }
    }

    /**
     * Згенераваць токен і спасылку для скіду пароля
     *
     * @param int $id ідэнтыфікатар карыстальніка
     */
    public function actionGenResetToken($id)
    {
        $user = User::findOne([
            'id' => $id,
            'status' => User::STATUS_ACTIVE,
        ]);
        if ( ! $user) {
            echo "Карыстальнік з id=$id ня знойдзены.\n";
            return;
        }

        $user->generatePasswordResetToken();
        if ($user->save()) {
            $encodedToken = base64_encode ($user->password_reset_token);
            echo "Карыстальнік абноўлены. Спасылка на скід бягучага пароля: ". Url::to(['/site/reset-password', 'token' => $encodedToken], true) . "\n";
        } else {
            echo "Памылка абнаўлення карыстальніка id=$id.\n";
            return;
        }
    }

    /**
     * Паказаць усіх карыстальнікаў
     */
    public function actionList()
    {
        $users = User::find()->all();
        if (empty ($users)) {
            echo "Няма карыстальнікаў.\n";
            return;
        }

        echo "Карыстальнікі сістэмы:\n\n";
        foreach ($users as $user) {
            printf ("%d\t%s\t%d\t%d\n",
                $user->id,
                $user->username,
                $user->status,
                $user->role
            );
        }
        echo "\n\n";
    }

    /**
     * Выдаліць карыстальніка
     *
     * @param int $id ідэнтыфікатар
     * @param bool $permanently выдаліць з базы
     */
    public function actionDelete($id, $permanently = false)
    {
        $user = User::findOne([
            'id' => $id,
            'status' => User::STATUS_ACTIVE,
        ]);
        if ( ! $user) {
            echo "Карыстальнік з id=$id ня знойдзены.\n";
            return;
        }
        if ($permanently) {
            $affected = $user->delete();
            echo "Выдалены $affected карыстальнік з базы\n";
            return;
        }
        $user->status = User::STATUS_DELETED;
        if ($user->save()) {
            echo "Статус карыстальніка id=$id абноўлены.\n";
        } else {
            echo "Адбылася памылка абнаўлення статуса карыстальніка id=$id.\n";
        }
    }

    /**
     * Актываваць карыстальніка
     *
     * @param int $id ідэнтыфікатар
     */
    public function actionActivate($id)
    {
        $user = User::findOne([
            'id' => $id,
            'status' => User::STATUS_DELETED,
        ]);
        if ( ! $user) {
            echo "Карыстальнік з id=$id ня знойдзены.\n";
            return;
        }
        $user->status = User::STATUS_ACTIVE;
        if ($user->save()) {
            echo "Статус карыстальніка id=$id абноўлены.\n";
        } else {
            echo "Адбылася памылка абнаўлення статуса карыстальніка id=$id.\n";
        }
    }
}

