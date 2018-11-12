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
     * @return \think\model\relation\HasMany
     * 关联拨款记录模型
     */
    public function moneyLog()
    {
        return $this->hasMany('GiveMoneyLog', 'enterprise_id', 'enterprise_id');
    }

    /**
     * @return \think\model\relation\HasMany
     * 关联附件模型
     */
    public function files(){
        return $this->hasMany('Files', 'enterprise_id', 'enterprise_id');
    }


    /**
     * @return \think\Paginator
     * @throws \think\exception\DbException
     * 返回扶持企业列表
     */
    public function helpEnterpriseList($year, $status, $key)
    {
        $map = [];
        //不设置时间则默认显示当年列表
        if (empty($year)) {
            $year = \date('Y');
        }
        if (!empty($status)) {
            $map['status'] = $status;
        }
        $list = self::with('enterprise')
            ->where($map)
            ->whereLike('enterprise_name', '%' . $key . '%')
            ->whereBetweenTime('create_time', $year . '-' . '01' . '-' . '01', ($year + 1) . '-' . '01' . '-' . '01')
            ->paginate(10);
        return $list;
    }

    /**
     * @param $id
     * @return array|null|\PDOStatement|string|Model
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 返回企业的拨款基本信息和拨款记录
     */
    public function helpEnterpriseDetail($id)
    {
        $list = self::with('moneyLog,files')
            ->where('enterprise_id',$id)
            ->find();
        return $list;
    }
}