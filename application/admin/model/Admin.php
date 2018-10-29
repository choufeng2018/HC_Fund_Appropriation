<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/29
 * Time: 16:27
 */

namespace app\admin\model;


use think\Model;

/**
 * Class Admin
 * @package app\admin\model
 */
class Admin extends Model
{
    /**
     * @param string $username
     * @param string $password
     * @param string $rememberme
     * @return bool|mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 管理员登录
     */
    public function login($username = '', $password = '', $rememberme = '')
    {
        $user = self::where('username', $username)->find();
        if (!$user) {
            $this->error('管理员不存在');
        } else {
            $pwd_res = \checkAdminPassword($password, $user['password']);
            if ($pwd_res) {
                $this->error = '密码错误';
            } else {
                $admin_id = $user['id'];
                // 更新登录信息
                $user['last_ip'] = request()->ip();
                $user['last_time'] = time();
                $user['logtimes'] = $user['logtimes'] + 1;
                if ($user->save()) {
                    // 自动登录
                    $this->autoLogin($user, $rememberme);
                }
                return $admin_id;
            }
        }
        return false;
    }

    /**
     * @param $user
     * @param bool $rememberme
     * 执行登录
     */
    private function autoLogin($user, $rememberme = false)
    {
        $auth = [
            'admin_id' => $user->id,
            'username' => $user->username,
            'last_ip' => $user->last_ip,
            'last_time' => $user->last_time
        ];
        \session('admin_auth', $auth);
        \session('admin_auth_sign', \data_signature($auth));

        if ($rememberme) {
            $signin_token = $user->username . $user->id . $user->last_time;
            \cookie('admin_id', $user->id, 7 * 24 * 3600);
            \cookie('singin_token', \data_signature($signin_token), 7 * 24 * 3600);
        }
    }

    /**
     *登出
     */
    public function logout()
    {
        \session('admin_auth', null);
        \session('admin_auth_sign', null);
        \cookie('admin_id', null);
        \cookie('signin_token', null);
        \redirect('admin/login/index');
    }
}