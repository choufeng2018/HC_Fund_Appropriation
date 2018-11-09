<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

use app\admin\model\Admin;
use think\Db;

if (!function_exists('makeAdminPassword')) {
    /**
     * @param $input_password
     * @return bool|string
     * 用户密码加密
     */
    function makeAdminPassword($input_password)
    {
        //初始化散列器
        $hasher = new PasswordHash(8, FALSE);
        //将密码进行哈希，结果是一个长度为60个字符的字符串
        $hasher_password = $hasher->HashPassword($input_password);
        //返回密码
        return $hasher_password;
    }
}

if (!function_exists('checkAdminPassword')) {

    /**
     * @param $input_password
     * @param $correct_password
     * @return bool
     * 用户密码校验
     */
    function checkAdminPassword($input_password, $correct_password)
    {
        //初始化散列器
        $hasher = new PasswordHash(8, FALSE);
        //对比密码是否一致返回true或false
        $res = $hasher->CheckPassword($input_password, $correct_password);
        return $res;
    }
}

if (!function_exists('data_signature')) {
    /**
     * 数据签名
     *
     * @param array $data 被认证的数据
     *
     * @return string 签名
     */
    function data_signature($data = [])
    {
        if (!is_array($data)) {
            $data = (array)$data;
        }
        ksort($data);
        $code = http_build_query($data);
        $sign = sha1($code);
        return $sign;
    }
}

if (!function_exists('is_help_enterprise')) {
    /**
     * @param $enterprise_id
     * @return bool
     * 判断该企业是不是扶持企业
     */
    function is_help_enterprise($enterprise_id)
    {
        $res = Db::name('HelpEnterpriseList')
            ->where('enterprise_id', $enterprise_id)
            ->count();
        if ($res == 0) {
            return false;
        } else {
            return true;
        }
    }
}

if (!function_exists('get_adminName_by_id')) {
    /**
     * @param $admin_id
     * @return mixed
     * 根据管理员ID查找姓名
     */
    function get_adminName_by_id($admin_id)
    {
        $admin_name = Admin::where('id', $admin_id)->value('username');
        return $admin_name;
    }
}

if (!function_exists('num2Word')) {
    /**
     * @param $num
     * @return mixed|string
     * 数字转中文
     */
    function num2Word($num)
    {
        $chiNum = array('零', '一', '二', '三', '四', '五', '六', '七', '八', '九');
        $chiUni = array('','十', '百', '千', '万', '亿', '十', '百', '千');

        $num_str = (string)$num;

        $count = strlen($num_str);
        $last_flag = true; //上一个 是否为0
        $zero_flag = true; //是否第一个
        $temp_num = null; //临时数字

        $chiStr = '';//拼接结果
        if ($count == 2) {//两位数
            $temp_num = $num_str[0];
            $chiStr = $temp_num == 1 ? $chiUni[1] : $chiNum[$temp_num].$chiUni[1];
            $temp_num = $num_str[1];
            $chiStr .= $temp_num == 0 ? '' : $chiNum[$temp_num];
        }else if($count > 2){
            $index = 0;
            for ($i=$count-1; $i >= 0 ; $i--) {
                $temp_num = $num_str[$i];
                if ($temp_num == 0) {
                    if (!$zero_flag && !$last_flag ) {
                        $chiStr = $chiNum[$temp_num]. $chiStr;
                        $last_flag = true;
                    }
                }else{
                    $chiStr = $chiNum[$temp_num].$chiUni[$index%9] .$chiStr;

                    $zero_flag = false;
                    $last_flag = false;
                }
                $index ++;
            }
        }else{
            $chiStr = $chiNum[$num_str[0]];
        }
        return $chiStr;
    }
}