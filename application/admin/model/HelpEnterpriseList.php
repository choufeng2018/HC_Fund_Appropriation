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
     * @return \think\Paginator
     * @throws \think\exception\DbException
     * 返回扶持企业列表
     */
    public function helpEnterpriseList($year, $status, $key)
    {
        $map = [];
        if (!empty($year)) {
            $map['create_time'] = ['between time', \mktime(0, 0, 0, 1, 1, $year), \mktime(0, 0, 0, 1, 1, $year + 1)];
        }
        if (!empty($status)) {
            $map['status'] = $status;
        }
        $list = self::with('enterprise')
            ->where($map)
            ->whereLike('enterprise_name', '%' . $key . '%')
            ->paginate(10);
        return $list;
    }
}