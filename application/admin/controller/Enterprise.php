<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/29
 * Time: 17:29
 */

namespace app\admin\controller;

use app\admin\model\EnterpriseList;
use app\admin\model\GiveMoneyLog;
use app\admin\model\HelpEnterpriseList;
use think\Db;
use think\facade\Request;

/**
 * Class Enterprise
 * @package app\admin\controller
 */
class Enterprise extends AdminBase
{

    /**
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 所有企业列表
     */
    public function enterpriseList()
    {
        $key = \input('key', '');
        $model = new EnterpriseList();
        $list = $model->allEnterpriseList($key);
        $this->assign('list', $list);
        return $this->fetch();
    }


    /**
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 扶持企业列表
     */
    public function helpEnterpriseList()
    {
        $year = \input('year', '');
        $status = \input('status', '');
        $key = \input('key', '');
        $model = new HelpEnterpriseList();
        $list = $model->helpEnterpriseList($year, $status, $key);
//        \halt($list);
        //年份的数组
        $min_year = Db::name('HelpEnterpriseList')->min('create_time');
        $min_year = \date('Y', $min_year);
        $now_year = \date('Y');
        for ($i = $min_year; $i <= $now_year; $i++) {
            $years[] = \intval($i);
        }
        $this->assign('years', $years);
        $this->assign('list', $list);
        return $this->fetch();
    }

    /**
     * @throws \Exception
     * 添加扶持企业
     */
    public function addHelpEnterprise()
    {
        if (Request::isPost()) {
            //因为涉及到批量操作,所以强制转为数组
            $ids = \input('checkArr');
            foreach ($ids as $v) {
                $enterpriseModel = new EnterpriseList();
                $enterprise_name = $enterpriseModel->where('id', $v)->value('enterprise_list_name');
                $data[] = [
                    'enterprise_id' => $v,
                    'enterprise_name' => $enterprise_name,
                    'status' => 3,
                ];
            }
            $model = new HelpEnterpriseList();
            $res = $model->saveAll($data);
            if ($res) {
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }
        } else {
            $this->error('提交方式不正确');
        }
    }


    /**
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 扶持企业详情
     */
    public function helpDetail()
    {
        $enterprise_id = Db::name('HelpEnterpriseList')
            ->where('id', \input('id'))
            ->value('enterprise_id');
        $enterprise_info1 = EnterpriseList::get($enterprise_id)->toArray();
//        \halt($enterprise_info);
        $enterprise_info2 = Db::name('HelpEnterpriseList')->where('id', \input('id'))->find();
        $enterprise_info = $enterprise_info1 + $enterprise_info2;
        $this->assign('info', $enterprise_info);
        return $this->fetch();
    }

    /**
     *编辑扶持企业的信息
     */
    public function HelpEnterpriseEdit()
    {
        $data = \input();
        $model = new HelpEnterpriseList();
        $res = $model->allowField(true)->save($data, ['enterprise_id' => $data['e_id']]);
        if ($res) {
            $this->success('保存成功');
        } else {
            $this->error('保存失败');
        }
    }

    /**
     *上传发票
     */
    public function uploadInvoice()
    {
        \halt(\input());
    }

    /**
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * 从扶持列表中删除企业
     */
    public function helpEnterpriseDel()
    {
        $id = \input('id');
        $res = Db::name('HelpEnterpriseList')->where('id', $id)->delete();
        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }


    /**
     * @return mixed
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 拨款页面
     */
    public function giveMoney()
    {
        $enterprise_info = Db::name('HelpEnterpriseList')
            ->where('id', \input('id'))
            ->find();
        $model = new HelpEnterpriseList();
        $data = $model->helpEnterpriseDetail($enterprise_info['enterprise_id']);
        $this->assign('data', $data);
        return $this->fetch();
    }

    /**
     *执行拨款操作;
     * 这里需要写入拨款记录表,
     * 对应的数据也要更新在扶持企业基本信息表中,包括:已拨款批次数,已拨款总额
     */
    public function doGiveMoney()
    {
        $data = [
            'enterprise_id' => \input('enterprise_id'),
            'give_money_time' => \input('addTime'),
            'give_money' => \input('addMoney'),
            'handler' => \session('admin_auth.admin_id'),
        ];
        $model = new GiveMoneyLog();
        $res = $model->save($data);
        if ($res) {
            //拨款成功后将相关数据写入企业扶持表
            $id = Db::name('HelpEnterpriseList')
                ->where('enterprise_id', \input('enterprise_id'))
                ->value('id');
            $helpEnterprise = HelpEnterpriseList::get($id);
            $helpEnterprise->paid_batch = ['inc', 1];   //已拨款次数+1
            $helpEnterprise->paid_money = ['inc', \input('addMoney')];    //增加已拨款金额
            $helpEnterprise->status = 1;    //修改拨款状态
            $helpEnterprise->save();
            return \redirect('admin/Enterprise/giveMoney',['id'=>$id]);
        } else {
            $this->error('添加失败');
        }
    }

    /**
     *删除拨款记录
     */
    public function delGiveMoney()
    {
        $id = \input('id');
        $help_info = GiveMoneyLog::get($id);
        $res = GiveMoneyLog::destroy($id);
        if ($res) {
            //同时更新扶持列表基本信息的内容

            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }
}