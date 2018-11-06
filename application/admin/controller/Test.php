<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/29
 * Time: 17:49
 */

namespace app\admin\controller;


use think\Controller;

/**
 * Class Test
 * @package app\admin\controller
 * 测试用控制器,上线删除
 */
class Test extends Controller
{
    public function index()
    {
        \halt(\session(''));
    }
    public function makepwd(){
        $pwd = \makeAdminPassword(123456);
        \halt($pwd);
    }

    public function checkpwd(){
        $res = \checkAdminPassword('123456', '$2a$08$8h1megB0F3k4DWFOgDVcU.F4ioa9/yu6a6pBFyIIYv/eGKuRkxdvK');
        \halt($res);
    }

    public function time(){

        dump(\mktime(0,0,0,1,1,2017));

    }
}