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

    /**
     * @throws \think\Exception\DbException
     * 修改密码
     */
    public function resetPassword()
    {
        $new_password = \input('new_pwd');
        $renew_password = \input('renew_pwd');
        if ($new_password != $renew_password) {
            $this->error('两次密码不一致');
        }
        $admin_id = \session('admin_auth.admin_id');
        $admin = Admin::get($admin_id);
        $admin->password = \makeAdminPassword($new_password);
        $admin->changepwd = \time();
        $res = $admin->save();
        if ($res) {
            $this->success('修改成功');
        } else {
            $this->error('修改失败');
        }
    }
}
