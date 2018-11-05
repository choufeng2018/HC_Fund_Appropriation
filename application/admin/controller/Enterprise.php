<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/29
 * Time: 17:29
 */

namespace app\admin\controller;

use app\admin\model\EnterpriseList;
use app\admin\model\HelpEnterpriseList;
use think\Controller;
use think\facade\Request;

/**
 * Class Enterprise
 * @package app\admin\controller
 */
class Enterprise extends Controller
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
        $model = new EnterpriseList();
        $list = $model->allEnterpriseList();
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
        $model = new HelpEnterpriseList();
        $list = $model->helpEnterpriseList();
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
            $ids = \input('enterprise_id/a');
            foreach ($ids as $v) {
                $data[] = [
                    'enterprise_id' => $v,
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
}