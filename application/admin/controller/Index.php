<?php

namespace app\admin\controller;

use app\admin\model\Admin;

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
        echo 1;
    }

    /**
     *退出登录
     */
    public function logout()
    {
        $admin = new Admin();
        $admin->logout();
    }
}
