<?php
/**
 * Created by PhpStorm.
 * User: xpwsgg
 * Date: 2018/11/10
 * Time: 17:31
 */

namespace app\admin\model;


use think\facade\Request;
use think\Model;

/**
 * Class Files
 * @package app\admin\model
 * 附件模型
 */
class Files extends Model
{
    /**
     * @var bool
     */
    protected $autoWriteTimestamp = true;
    protected $visible=['file_path'];

    /**
     * @param $path
     * @return string
     * 返回拼接好的图片地址
     */
    public function getFilePathAttr($path)
    {
        if (!empty($path)) {
            return Request::domain() . '/uploads/'.$path;
        } else {
            return '';
        }
    }
}