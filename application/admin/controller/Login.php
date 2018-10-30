<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/29
 * Time: 14:38
 */

namespace app\admin\controller;


use think\captcha\Captcha;
use think\Controller;
use think\Db;
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
            $admin = Db::name('Admin')->where('username', $username)->find();
            if (empty($admin)) {
                $this->error('该管理员不存在');
            } else {
                $pwd_res = \checkAdminPassword($password, $admin['password']);
                if ($pwd_res) {
                    //更新登录信息
                    $data['last_ip'] = request()->ip();
                    $data['last_time'] = time();
                    $data['logtimes'] = $data['logtimes'] + 1;
                    Db::name('Admin')->where('id', $admin['id'])->setField($data);
                    if ($rememberme == 'on') {
                        \cookie('admin_id', $admin['id'], 7 * 24 * 3600);
                    }
                    \session('admin_id', $admin['id']);
                    return \redirect('admin/Index/index');
                } else {
                    $this->error('密码不正确');
                }
            }
        }
    }
}