<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/29
 * Time: 14:33
 */

namespace app\admin\controller;


use think\Controller;

/**
 * Class AdminBase
 * @package app\admin\controller
 * 基础控制器
 */
class AdminBase extends Controller
{
    /**
     *初始化
     */
    public function initialize()
    {
        parent::initialize();
        $this->checkAdminLogin();
    }

    /**
     *检测登录
     */
    function checkAdminLogin()
    {
        if (\session('admin_auth')) {
            return \redirect('admin/Index/index');
        } else {
            $this->redirect('admin/Login/index');
        }
    }
}