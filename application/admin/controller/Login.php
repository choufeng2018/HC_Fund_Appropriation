<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/29
 * Time: 14:38
 */

namespace app\admin\controller;


use app\admin\model\Admin;
use think\captcha\Captcha;
use think\Controller;
use think\facade\Request;

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
     * @return \think\Response
     * 生成验证码
     */
    public function verify()
    {
        ob_end_clean();
        $captcha = new Captcha();
        return $captcha->entry();
    }

    /**
     *执行登录
     */
    public function doLogin()
    {
        if (Request::isPost()) {
//            \halt(\input());
            $username = \input('username');
            $password = \input('password');
            $captcha = \input('captcha');
            $rememberme = \input('remmeberme');
            if (!captcha_check($captcha)) {
                $this->error('验证码错误');
            }
            $adminModel = new Admin();
            $res = $adminModel->login($username, $password, $rememberme);
            if ($res) {
                $this->redirect('admin/Index/index');
            } else {
                $this->error('登录失败');
            }
        }
    }
}