<?php

namespace app\admin\controller;

/**
 * Class Index
 * @package app\admin\controller
 */
class Index extends AdminBase
{
    /**
     *后台首页
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     *退出登录
     */
    public function logout()
    {
        \session('admin_auth', null);
        \session('admin_auth_sign', null);
        \cookie('admin_id', null);
        \cookie('signin_token', null);
        $this->redirect('admin/login/index');
    }
}
