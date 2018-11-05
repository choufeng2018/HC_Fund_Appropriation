<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/11/5
 * Time: 9:15
 */

namespace app\admin\model;


use think\Model;

/**
 * Class HelpEnterpriseList
 * @package app\admin\model
 * 扶持企业模型
 */
class HelpEnterpriseList extends Model
{
    /**
     * @var bool
     */
    protected $autoWriteTimestamp = true;

    /**
     * @return \think\model\relation\BelongsTo
     * 关联企业模型
     */
    public function enterprise()
    {
        return $this->belongsTo('EnterpriseList', 'enterprise_id', 'id');
    }

    /**
     * @return array|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 返回扶持企业列表
     */
    public function helpEnterpriseList()
    {
        $list = self::with('enterprise')->select();
        return $list;
    }
}