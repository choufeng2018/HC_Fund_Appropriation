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

    public function makepwd()
    {
        $pwd = \makeAdminPassword(123456);
        \halt($pwd);
    }

    public function checkpwd()
    {
        $res = \checkAdminPassword('123456', '$2a$08$8h1megB0F3k4DWFOgDVcU.F4ioa9/yu6a6pBFyIIYv/eGKuRkxdvK');
        \halt($res);
    }

    public function time()
    {

        $year = 2018;
        dump(\mktime(0, 0, 0, 1, 1, $year + 1));

    }

    public function upload()
    {
        return $this->fetch();
    }

    public function doUpLoad()
    {
// 获取表单上传文件
        $files = \request()->file('files');
        if ($files) {
            foreach ($files as $file) {

                // 移动到框架应用根目录/uploads/ 目录下
                $info = $file->move('../uploads');
                if ($info) {
                    // 成功上传后 获取上传信息

                    // 输出 42a79759f284b767dfcb2a0197904287.jpg
                    echo $info->getFilename();
                } else {
                    // 上传失败获取错误信息
                    echo $file->getError();
                }
            }
        } else {
            echo "nothing";
        }
    }
}