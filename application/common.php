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