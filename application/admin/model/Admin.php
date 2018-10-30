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
        if (empty($user)) {
            $this->error = '管理员不存在';
        } else {
            $pwd_res = \checkAdminPassword($password, $user['password']);
            if ($pwd_res) {
                //更新登录信息
                $user['last_ip'] = request()->ip();
                $user['last_time'] = time();
                $user['logtimes'] = $user['logtimes'] + 1;
                if ($user->save()) {
                    return $this->autoLogin($user, $rememberme);
                }
            } else {
                $this->error = '登录失败!';
            }
        }
    }


    /**
     * @param $user
     * @param $rememberme
     * @return bool
     * 执行登录
     */
    private function autoLogin($user, $rememberme)
    {
        $auth = [
            'admin_id' => $user->id,
            'username' => $user->username,
            'last_ip' => $user->last_ip,
            'last_time' => $user->last_time
        ];
        \session('admin_auth', $auth);
        \session('admin_auth_sign', \data_signature($auth));

        if ($rememberme == 'on') {
            $signin_token = $user->username . $user->id . $user->last_time;
            \cookie('admin_id', $user->id, 7 * 24 * 3600);
            \cookie('singin_token', \data_signature($signin_token), 7 * 24 * 3600);
        }
        return true;
    }
}