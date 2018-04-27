<?php
namespace app\Admin\controller;
use app\Admin\model\UserModel;
use function imf_admin_login;
use function imf_get_user_menu;
use think\Controller;

/**
 *
 * ============================================================================
 * [UD DataMap BigData System] Copyright (c) 1995-2028 www.unnnnn.com
 * 版权所有 1995-2028 UD数据信息有限公司【中国】，并保留所有权利。
 * This is not  free soft ware, use is subject to license.txt
 * 网站地址: http://www.unnnnn.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: 陈建华 $
 * $Create Time: 2018/2/9 0009 $
 * email:unnnnn@foxmail.com
 * function:AdminBase.php
 */
use app\Admin\model\MenuModel;

use think\Request;
class AuthAdminBase extends Controller
{
    public static $Menus;
    public function __construct(Request $request)
    {
        imf_admin_login();

        parent::__construct();
        if ($request->isMobile()) {
            $this->view->config('view_path','themes/default/mobile/' . $request->module() . "/");
        } else {
            $this->view->config('view_path','themes/default/web/' . $request->module() . "/");
        }

        imf_admin_login();

        self::$Menus = imf_get_user_menu(session('user_type'));
    }
}