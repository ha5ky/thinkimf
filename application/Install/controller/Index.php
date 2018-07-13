<?php

namespace app\Install\controller;

use function date;
use think\Db;
use const SOURCE_ROOT;

class Index extends Base
{
	public function index($step = 0)
	{
		switch ($step) {
			case 2:
				session('install_error', false);
				return self::step2();
				break;
			case 3:
				if (session('install_error')) {
					return $this->error('环境检测未通过，不能进行下一步操作！');
				}
				return self::step3();
				break;
			case 4:
				if (session('install_error')) {
					return $this->error('环境检测未通过，不能进行下一步操作！');
				}
				return self::step4();
				break;
			case 5:
				if (session('install_error')) {
					return $this->error('安装失败,请到论坛反馈或者联系管理员！');
				}
				return self::step5();
				break;

			default:
				session('install_error', false);

				return $this->fetch('index/index');
				break;
		}
	}

	/**
	 * 第二步：环境检测
	 * @return mixed
	 */
	private function step2()
	{
		$data = [];
		$data['env'] = self::checkNnv();
		$data['dir'] = self::checkDir();
		$data['func'] = self::checkFunc();
		$this->assign('data', $data);
		return $this->fetch('index/step2');
	}

	/**
	 * 第三步：初始化配置
	 * @return mixed
	 */
	private function step3()
	{
		$install_dir = $_SERVER["SCRIPT_NAME"];
		$install_dir = imf_substring($install_dir, strripos($install_dir, "/") + 1);
		$this->assign('install_dir', $install_dir);
		return $this->fetch('index/step3');
	}

	/**
	 * 第四步：执行安装
	 * @return mixed
	 */
	private function step4()
	{
		if ($this->request->isPost()) {
			if (!is_writable($_SERVER['DOCUMENT_ROOT'] . '/../config/' . 'database.php')) {
				return $this->error('[config/database.php]无读写权限！');
			}
			$data = input('post.');
			$data['type'] = 'mysql';
			$rule = [
				'hostname|服务器地址' => 'require',
				'hostport|数据库端口' => 'require|number',
				'database|数据库名称' => 'require',
				'username|数据库账号' => 'require',
				'prefix|数据库前缀' => 'require|regex:^[a-z0-9]{1,20}[_]{1}',
				'cover|覆盖数据库' => 'require|in:0,1',
			];
			$validate = $this->validate($data, $rule);
			if (true !== $validate) {
				return $this->error($validate);
			}
			$cover = $data['cover'];
			unset($data['cover']);
			$config = include SOURCE_ROOT . '/config/database.php';
			foreach ($data as $k => $v) {
				if (array_key_exists($k, $config) === false) {
					return $this->error('参数' . $k . '不存在！');
				}
			}
			// 不存在的数据库会导致连接失败
			$database = $data['database'];
			unset($data['database']);
			// 创建数据库连接
			$db_connect = Db::connect($data);
			// 检测数据库连接
			try {
				$db_connect->execute('select version()');
			} catch (\Exception $e) {
				$this->error('数据库连接失败，请检查数据库配置！');
			}

			// 生成数据库配置文件
			$data['database'] = $database;
			self::mkDatabase($data);


			// 不覆盖检测是否已存在数据库
			if (!$cover) {
				$check = $db_connect->execute('SELECT * FROM information_schema.schemata WHERE schema_name="' . $database . '"');
				if ($check) {
					$this->success('该数据库已存在，可直接安装。如需覆盖，请选择覆盖数据库！', '');
				}
			}
			// 创建数据库
			if (!$db_connect->execute("CREATE DATABASE IF NOT EXISTS `{$database}` DEFAULT CHARACTER SET utf8")) {
				return $this->error($db_connect->getError());
			}


			return $this->success('数据库连接成功', '');
		} else {
			return $this->error('非法访问');
		}
	}

	/**
	 * 第五步：数据库安装
	 * @return mixed
	 */
	private function step5()
	{
		$account = input('post.account');
		$password = input('post.password');
		$install_dir = input('post.install_dir');

		$config = include SOURCE_ROOT . '/config/database.php';
		if (empty($config['hostname']) || empty($config['database']) || empty($config['username'])) {
			return $this->error('请先点击测试数据库连接！');
		}
		if (empty($account) || empty($password)) {
			return $this->error('请填写管理账号和密码！');
		}

		$rule = [
			'account|管理员账号' => 'require|email',
			'password|管理员密码' => 'require|length:6,20',
		];
		$validate = $this->validate(['account' => $account, 'password' => $password], $rule);
		if (true !== $validate) {
			return $this->error($validate);
		}
		if (empty($install_dir)) {
			$install_dir = '/';
		}

		// 导入系统初始数据库结构
		// 导入SQL
		$sql_file = SOURCE_ROOT . '/data/install/install.sql';
		if (file_exists($sql_file)) {
			$sql = file_get_contents($sql_file);
			$sql_list = imf_parse_sql($sql, 0, ['imf_' => $config['prefix']]);
			if ($sql_list) {
				$sql_list = array_filter($sql_list);
				foreach ($sql_list as $v) {
					try {
						Db::execute($v);
					} catch (\Exception $e) {
						return $this->error('导入SQL失败，请检查install.sql的语句是否正确。' . $e);
					}
				}
			}
		}
		// 注册管理员账号
		$data = [
			'admin_name' => $account,
			'admin_pwd' => $password,
			'admin_status' => 1,
		];
		$passwordSalt = strtoupper(imf_rand_str(6));
		$userid = \app\Admin\Model\UserModel::insert([
			'email' => $account,
			'phone' => 0,
			'name' => '超级管理员',
			'nickname' => '超级管理员',
			'status' => 1,
			'verify' => 1,
			'id_card' => '888',
			'user_type' => 1,
			'password_salt' => $passwordSalt,
			'password' => md5($passwordSalt . $password),
		]);
		if (!$userid) {
			return $this->error('管理员账号设置失败!');
		}
		file_put_contents(SOURCE_ROOT . '/data/install/install.lock', date('Y-m-d H:i:s'));

		return $this->success(date('Y 年 m 月 d 日').'系统安装成功，欢迎您使用~','/Admin/index/index');
	}

	/**
	 * 环境检测
	 * @return array
	 */
	private function checkNnv()
	{
		$items = [
			'os' => ['操作系统', '不限制', 'Linux/Ubuntu/Center OS/Windows/Unix/Mac', PHP_OS, 'ok'],
			'php' => ['PHP版本', '7.0.0', '7.0.0及以上', PHP_VERSION, 'ok'],
			'gd' => ['GD库', '2.0', '2.0及以上', '未知', 'ok'],
			'swoole' => ['Swoole', '2.0', '2.0及以上', (extension_loaded('swoole') ? '已安装' : '未安装'), 'ok'],

		];
		if ($items['php'][3] < $items['php'][1]) {
			$items['php'][4] = 'no';
			session('install_error', true);
		}
		$tmp = function_exists('gd_info') ? gd_info() : [];
		if (empty($tmp['GD Version'])) {
			$items['gd'][3] = '未安装';
			$items['gd'][4] = 'no';
			session('install_error', true);
		} else {
			$items['gd'][3] = $tmp['GD Version'];
		}

		return $items;
	}

	/**
	 * 目录权限检查
	 * @return array
	 */
	private function checkDir()
	{
		$items = [
			['dir', './application', '读写', '读写', 'ok'],
			['dir', './application/Admin/', '读写', '读写', 'ok'],
			['dir', './application/Api/', '读写', '读写', 'ok'],
			['dir', './application/Auth', '读写', '读写', 'ok'],
			['dir', './application/Common', '读写', '读写', 'ok'],
			['dir', './application/Install', '读写', '读写', 'ok'],
			['dir', './application/Portal', '读写', '读写', 'ok'],
			['dir', './application/Portal', '读写', '读写', 'ok'],
			['dir', './CloudServer', '读写', '读写', 'ok'],
			['dir', './config', '读写', '读写', 'ok'],
			['dir', './data', '读写', '读写', 'ok'],
			['dir', './imf', '读写', '读写', 'ok'],
			['dir', './public', '读写', '读写', 'ok'],
			['dir', './route', '读写', '读写', 'ok'],
			['dir', './vendor', '读写', '读写', 'ok'],
			['file', './config/database.php', '读写', '读写', 'ok'],

		];
		foreach ($items as &$v) {
			if ($v[0] == 'dir') {// 文件夹
				if (!is_writable($_SERVER['DOCUMENT_ROOT'] . '/../' . $v[1])) {
					if (is_dir($v[1])) {
						$v[3] = '不可写';
						$v[4] = 'no';
					} else {
						$v[3] = '不存在';
						$v[4] = 'no';
					}
					session('install_error', true);
				}
			} else {// 文件
				if (!is_writable($_SERVER['DOCUMENT_ROOT'] . '/../' . $v[1])) {
					$v[3] = '不可写';
					$v[4] = 'no';
					session('install_error', true);
				}
			}
		}
		return $items;
	}

	/**
	 * 函数及扩展检查
	 * @return array
	 */
	private function checkFunc()
	{
		$items = [
			['pdo', '支持', 'yes', '类'],
			['pdo_mysql', '支持', 'yes', '模块'],
			['swoole', '支持', 'yes', '模块'],
			['zip', '支持', 'yes', '模块'],
			['fileinfo', '支持', 'yes', '模块'],
			['curl', '支持', 'yes', '模块'],
			['xml', '支持', 'yes', '函数'],
			['file_get_contents', '支持', 'yes', '函数'],
			['mb_strlen', '支持', 'yes', '函数'],
			['gzopen', '支持', 'yes', '函数'],
		];

		if (version_compare(PHP_VERSION, '7.0.0', 'ge') && version_compare(PHP_VERSION, '5.7.0', 'lt')) {
			$items[] = ['always_populate_raw_post_data', '支持', 'yes', '配置'];
		}

		foreach ($items as &$v) {
			if (('类' == $v[3] && !class_exists($v[0])) || ('模块' == $v[3] && !extension_loaded($v[0])) || ('函数' == $v[3] && !function_exists($v[0])) || ('配置' == $v[3] && ini_get('always_populate_raw_post_data') != -1)) {
				$v[1] = '不支持';
				$v[2] = 'no';
				session('install_error', true);
			}
		}

		return $items;
	}

	/**
	 * 生成数据库配置文件
	 * @return array
	 */
	private function mkDatabase(array $data)
	{
		$code = <<<INFO
<?php
/**
 *
 * ============================================================================
 * [Innovation Framework] Copyright (c) 1995-2028 www.thinkimf.com;
 * 版权所有 1995-2028 陈建华/陈炼/DyoungChen/Dyoung【中国】，并保留所有权利。
 * This is not  free soft ware, use is subject to license.txt
 * 网站地址: http://www.thinkimf.com;
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；作者是一个还要还房贷的码农,请尊重作者的劳动成果,商业用途和技术支持请联系QQ:1367784103。
 * ============================================================================
 * $ Author: 陈建华 $
 * $ Create Time: 2018/2/9 0009 $
 * email:dyoungchen@gmail.com
 * function:Database.php
 */

return [
    // 数据库类型
    'type'            => 'mysql',
    // 服务器地址
    'hostname'        => '{$data['hostname']}',
    // 数据库名
    'database'        => '{$data['database']}',
    // 用户名
    'username'        => '{$data['username']}',
    // 密码
    'password'        => '{$data['password']}',
    // 端口
    'hostport'        => '{$data['hostport']}',
    // 连接dsn
    'dsn'             => '',
    // 数据库连接参数
    'params'          => [],
    // 数据库编码默认采用utf8
    'charset'         => 'utf8',
    // 数据库表前缀
    'prefix'          => '{$data['prefix']}',
    // 数据库调试模式
    'debug'           => true,
    // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
    'deploy'          => 0,
    // 数据库读写是否分离 主从式有效
    'rw_separate'     => false,
    // 读写分离后 主服务器数量
    'master_num'      => 1,
    // 指定从服务器序号
    'slave_no'        => '',
    // 是否严格检查字段是否存在
    'fields_strict'   => true,
    // 数据集返回类型
    'resultset_type'  => 'array',
    // 自动写入时间戳字段
    'auto_timestamp'  => false,
    // 时间字段取出后的默认时间格式
    'datetime_format' => 'Y-m-d H:i:s',
    // 是否需要进行SQL性能分析
    'sql_explain'     => false,
    // Query类
    'query'           => '\\think\\db\\Query',
];
INFO;
		file_put_contents(SOURCE_ROOT . '/config/database.php', $code);
		// 判断写入是否成功
		$config = include SOURCE_ROOT . '/config/database.php';
		if (empty($config['database']) || $config['database'] != $data['database']) {
			return $this->error('[application/database.php]数据库配置写入失败！');
			exit;
		}
	}
}