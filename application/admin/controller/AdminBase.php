<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/29
 * Time: 14:33
 */

namespace app\admin\controller;


use think\Controller;

class AdminBase extends Controller
{
    public function initialize()
    {
        parent::initialize();
        //$this->checkAdminLogin();
    }

    function checkAdminLogin()
    {
        if (!\session('admin_id')) ;
        $this->error('请先登录', \url('admin/login/index'));
    }
}