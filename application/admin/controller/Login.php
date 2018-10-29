<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/29
 * Time: 14:38
 */

namespace app\admin\controller;


use app\admin\model\Admin;
use think\Controller;

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
        $captcha = \input('captcha');
        $rememberme = \input('remmeberme');
        if (!captcha_check($captcha)) {
            $this->error('验证码错误');
        }
        $admin = new Admin();
        if ($admin->login(\trim($username, \trim($password, \trim($rememberme))))) {
            \redirect('admin/index/index');
        } else {
            $this->error('密码错误');
        }
    }
}