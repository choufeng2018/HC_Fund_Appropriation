<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/29
 * Time: 17:18
 */

namespace app\admin\model;


use think\Model;

/**
 * Class EnterpriseList
 * @package app\admin\model
 */
class EnterpriseList extends Model
{
    /**
     * @var array
     */
    protected $connection = [
        // 数据库类型
        'type' => 'mysql',
        // 服务器地址
        'hostname' => '47.101.167.237',
        // 数据库名
        'database' => 'hckj',
        // 数据库用户名
        'username' => 'hckj',
        // 数据库密码
        'password' => 'fwegerhgergzsgzsga',
        // 数据库编码默认采用utf8
        'charset' => 'utf8',
        // 数据库表前缀
        'prefix' => 'yk_',
    ];

    /**
     * @return \think\Paginator
     * @throws \think\exception\DbException
     * 返回所有企业列表
     */
    public function allEnterpriseList($key)
    {
        $list = self::whereLike('enterprise_list_name', '%' . $key . '%')->paginate(10);
        return $list;
    }
}