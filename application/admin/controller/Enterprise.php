<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/10/29
 * Time: 17:29
 */

namespace app\admin\controller;

use app\admin\model\EnterpriseList;

class Enterprise extends AdminBase
{
    /**
     *企业列表
     */
    public function enterpriseList()
    {
        $model = new EnterpriseList();
        $list = $model->enterpriseList();
        $this->assign('list', $list);
        return $this->fetch();
    }
}