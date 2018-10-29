<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/29
 * Time: 14:38
 */

namespace app\admin\controller;


use think\Controller;
use think\Db;

/**
 * Class Login
 * @package app\admin\controller
 * 后台登录控制器
 */
class Login extends Controller
{
    /**
     * @return string
     * 登陆页面
     */
    public function index()
    {
        return \view();
    }

    /**
     *执行登录
     */
    public function doLogin()
    {
        $username = \input('username');
        $password = \input('password');
        $correct_password = Db::name('Admin')
            ->where('username', $username)
            ->value('password');
        $res = \checkAdminPassword($password, $correct_password);
        if ($res) {
            \redirect('admin/index/index');
        } else {
            $this->error('密码错误');
        }
    }
}