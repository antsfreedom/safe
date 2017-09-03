<?php
/**
 * @ controller Index.class.php
 * @ zmouse@vip.qq.com
 */

defined('IN_APP') or exit('Denied Access!');

class IndexController extends Controller {

	public function index() {
		echo '<p>欢迎</p>';
		//$result = $this->db->get("select * from users", 1);
		//dump($result);
	}

	/**
	 * @ interface 用户名验证
	 */
	public function verifyUserName() {
		
		$username = trim(isset($_REQUEST['username']) ? $_REQUEST['username'] : '');
		
		switch ($this->_verifyUserName($username)) {
			case 0:
				$this->sendByAjax(array('message'=>'恭喜你，该用户名可以注册！'));
				break;
			case 1:
				$this->sendByAjax(array('code'=>1,'message'=>'用户名长度不能小于3个或大于16个字符！'));
				break;
			case 2:
				$this->sendByAjax(array('code'=>2,'message'=>'对不起，该用户名已经被注册了！'));
				break;
			default:
				break;
		}
		
	}

	/**
	 * @ interface 用户注册
	 */
	public function reg() {
		$username = trim(isset($_REQUEST['username']) ? $_REQUEST['username'] : '');
		$password = trim(isset($_REQUEST['password']) ? $_REQUEST['password'] : '');
		$avatar = trim(isset($_REQUEST['avatar']) && in_array($_REQUEST['avatar'], array(1,2,3,4,5,6,7,8,9)) ? intval($_REQUEST['avatar']) : 1);

		if ($this->_verifyUserName($username) !== 0 || strlen($password)<3 || strlen($password) > 20) {
			$this->sendByAjax(array('code'=>1,'message'=>'注册失败！'));
		}
		$password = md5($password);
		if (false === $this->db->query("INSERT INTO `users` (`username`, `password`, `avatar`) VALUES ('{$username}', '{$password}', {$avatar})")) {
			$this->sendByAjax(array('code'=>1,'message'=>'注册失败！'));
		} else {
			$this->sendByAjax(array('message'=>'注册成功！'));
		}
	}


	/**
	 * @ 用户登陆
	 */
	public function login() {
		$username = trim(isset($_REQUEST['username']) ? $_REQUEST['username'] : '');
		$password = trim(isset($_REQUEST['password']) ? $_REQUEST['password'] : '');

		if (isset($_COOKIE['uid'])) {
			$this->sendByAjax(array('code'=>1,'message'=>'你已经登陆过了！'));
		}

		if ($rs = $this->db->get("SELECT * FROM `users` WHERE `username`='{$username}'")) {
			if ($rs['password'] != md5($password)) {
				$this->sendByAjax(array('code'=>1,'message'=>'登陆失败！'));
			} else {
				setcookie('uid', $rs['uid'], time() + 3600*60, '/');
				setcookie('username', $rs['username'], time() + 3600*60, '/');
				$this->sendByAjax(array('code'=>0,'message'=>'登陆成功！'));
			}
		} else {
			$this->sendByAjax(array('code'=>1,'message'=>'登陆失败！'));
		}
	}

	/**
	 * @ 用户退出
	 */
	public function logout() {
		if (!isset($_COOKIE['uid'])) {
			$this->sendByAjax(array('code'=>1,'message'=>'你还没有登陆！'));
		} else {
			setcookie('uid', 0, time() - 3600*60, '/');
			$this->sendByAjax(array('code'=>0,'message'=>'退出成功！'));
		}
	}
	// banner 轮播
	public function indexData() {

		$test =  [
			'tel' => 400-889-1251,
			'code' => 'https://www.51safety.com.cn/images/dwy/%E4%BA%8C%E7%BB%B4%E7%A0%81%E5%B0%8F90X90_03.png',
			'links' => [
				['name' => '首页','path' => './index.html'],
				['name' => '行业资讯','path' => './index.html'],
				['name' => '专家智库','path' => './index.html'],
				['name' => '在线教育','path' => './index.html'],
				['name' => '工具软件','path' => './index.html'],
				['name' => '安全之星','path' => './index.html'],
				['name' => '招聘信息','path' => './index.html'],
			],
			'banner' => [
				'http://i2.bvimg.com/609122/ee2bb203401f0f64.png',
				'http://i2.bvimg.com/609122/9ed862bf77058772.png'
			],
			'hotNews' => [
				[
					"title" => '雷军vs周鸿祎，20年的"天地对决"',
					"pic" =>'http://i2.bvimg.com/609122/ad5bc3bf259f5a94.png',
					"content" => '如今几乎所有互联网巨头都在做手机，连外来者都跨界凑热闹，中国智机市场的热潮正以前所未有之姿激烈翻涌。2015年,“战士”周鸿祎也次突击进场。前辈有小米，我们有步枪”。周鸿祎拿起“AK47奋起力击，究竟结果如何？让我们拭目以待！'
				],
				[
					"title" => "​IT领袖峰会，李彦宏、马化腾、杨元庆同台PK说了啥？",
					"pic" =>'http://i2.bvimg.com/609122/ad5bc3bf259f5a94.png',
					"content" => "网易科技讯 3月27日消息，2016 IT领袖峰会今日在深圳召开，网易科技和网易创业Club全程直播和专题报道，欢迎关注网易科技全程现场直播。全程现场直播峰会首场高端对话主题为IT创新与共享经济，主持人是数字中国联合会主席吴鹰，对话嘉宾有：百度公司创始人、董事长兼首席执行官李彦宏，腾讯公司董事会主席兼首席执行官马化腾，联想集团董事长兼首席执行官杨元庆，乐视创始人、董事长、乐视控股首席执行官贾跃亭。"
				],
				[
					"title" => "家居O2O的15个流量入口",
					"pic" =>'http://i2.bvimg.com/609122/ad5bc3bf259f5a94.png',
					"content" => "建材家居O2O目前盛行于国内，越多越多的建材家居企业推行O2O模式，试图借助移动互联网的迅速发展，推动企业的跨越式成长；而无论是建设PC商城，还是开设移动微商城、独立B2C商城等，都需要我们全方位引流，有庞大的流量建材家居O2O电商平台建设才有盼头，才有存活的动力。我们试着从产业消费方面、生活服务方面、商业运作方面、SNS社交方面和技术支持方面探索建材家居O2O的流量来源，多方开流，扩大潜在用户基数，提升用户的购买积极性。"
				],
				[
					"title" => "国美在线牟贵先：2015年从上到下立了军令状",
					"content" => "(中国电子商务研究中心讯)传统电商的大时代正在过去，而移动电商的潮流正在涌动。当移动互联网弥合了线上和线下的界线，对于那些传统零售企业或者更多带着传统基因的企业来说，或许是一种利好。"
				]
			],
			'postArticel' => [
				[
					"avatar" => 'http://i2.bvimg.com/609122/4e1cec218cd0af5c.jpg',
					"name" => "安全生产",
					"hornor" => '10'
				],
				[
					"avatar" => 'http://i2.bvimg.com/609122/bb5835e6c0fbcbd6.jpg',
					"name" => "安全生产",
					"hornor" => '10'
				],
				[
					"avatar" => 'http://i2.bvimg.com/609122/b9c054c92d7abdd6.jpg',
					"name" => "安全生产",
					"hornor" => '10'
				]
			],
			'ask' => [
				"total" => 1419864,
				"news" => [
					[
						"title" => '[公积金贷款]公积金贷款首付下调了几成"',
						"content" => '导热垫是高性能间隙填充导热材料，主要用于电子设备与散热片或产品外壳间的传递界面.',
						"num" => 1030,
						"comment" => 9,
						"focus" => 24,
						"time" => 1503886210000
					],
					[
						"title" => '[公积金贷款]公积金贷款首付下调了几成"',
						"content" => '导热垫是高性能间隙填充导热材料，主要用于电子设备与散热片或产品外壳间的传递界面.',
						"num" => 1030,
						"comment" => 9,
						"focus" => 24,
						"time" => 1503886210000
					],
					[
						"title" => '[公积金贷款]公积金贷款首付下调了几成"',
						"content" => '导热垫是高性能间隙填充导热材料，主要用于电子设备与散热片或产品外壳间的传递界面.',
						"num" => 1030,
						"comment" => 9,
						"focus" => 24,
						"time" => 1503886210000
					]
				],
				"question" => [
					"name" => '王三明',
					"pic" =>'http://i2.bvimg.com/609122/ad5bc3bf259f5a94.png',
					"intro" => [
						"南京安元科技有限公司","董事长兼总经理","南京工业大学教授"
					],
					"title" => "安全生产存在问题及对策",
					"short" => "我们知道，安全生产工作直接关系到人命财产安全，关系到国家",
					"good" => 1228,
					"answer" => 6989,
					"share" => 38600000
				]
			]
		];
		$this->sendByAjax(array('code'=>0,'message'=>'ok','date' => $test));
		// $this->sendByAjax(array());
	}

	/**
	 * 用户留言保存
	 */
	public function send() {
		if (!isset($_COOKIE['uid'])) {
			$this->sendByAjax(array('code'=>1,'message'=>'你还没有登陆！'));
		} else {
			$content = trim(isset($_POST['content']) ? $_POST['content'] : '');
			if (empty($content)) {
				$this->sendByAjax(array('code'=>1,'message'=>'留言内容不能为空！'));
			}
			$dateline = time();
			$this->db->query("INSERT INTO `contents` (`uid`, `content`, `dateline`) VALUES ({$_COOKIE['uid']}, '{$content}', {$dateline})");
			$returnData = array(
				'cid'		=>	$this->db->getInsertId(),
				'uid'		=>	$_COOKIE['uid'],
				'username'	=>	$_COOKIE['username'],
				'content'	=>	$content,
				'dateline'	=>	$dateline,
				'support'	=>	0,
				'oppose'	=>	0,
			);
			$this->sendByAjax(array('code'=>0,'message'=>'留言成功！','data'=>$returnData));
		}
	}

	/**
	 * @ 顶
	 */
	public function doSupport() {
		if (!isset($_COOKIE['uid'])) {
			$this->sendByAjax(array('code'=>1,'message'=>'你还没有登陆！'));
		} else {
			$cid = isset($_REQUEST['cid']) ? intval($_REQUEST['cid']) : 0;
			if (!$cid) $this->sendByAjax(array('code'=>1,'message'=>'无效留言cid！'));
			$content = $this->db->get("SELECT cid FROM `contents` WHERE `cid`={$cid}");
			if (!$content) $this->sendByAjax(array('code'=>1,'message'=>'不存在的留言cid！'));
			$this->db->query("UPDATE `contents` SET `support`=support+1 WHERE `cid`={$cid}");
			$this->sendByAjax(array('code'=>0,'message'=>'顶成功！'));
		}
	}

	/**
	 * @ 踩
	 */
	public function doOppose() {
		if (!isset($_COOKIE['uid'])) {
			$this->sendByAjax(array('code'=>1,'message'=>'你还没有登陆！'));
		} else {
			$cid = isset($_REQUEST['cid']) ? intval($_REQUEST['cid']) : 0;
			if (!$cid) $this->sendByAjax(array('code'=>1,'message'=>'无效留言cid！'));
			$content = $this->db->get("SELECT cid FROM `contents` WHERE `cid`={$cid}");
			if (!$content) $this->sendByAjax(array('code'=>1,'message'=>'不存在的留言cid！'));
			$this->db->query("UPDATE `contents` SET `oppose`=oppose+1 WHERE `cid`={$cid}");
			$this->sendByAjax(array('code'=>0,'message'=>'踩成功！'));
		}
	}

	/**
	 * @ 获取留言列表
	 */
	public function getList() {
		$page = isset($_REQUEST['page']) ? intval($_REQUEST['page']) : 1;	//当前页数
		$n = isset($_REQUEST['n']) ? intval($_REQUEST['n']) : 10;	//每页显示条数
		//获取总记录数
		$result_count = $this->db->get("SELECT count('cid') as count FROM `contents`");
		$count = $result_count['count'] ? (int) $result_count['count'] : 0;
		if (!$count) {
			$this->sendByAjax(array('code'=>1,'message'=>'还没有任何留言！'));
		}
		$pages = ceil($count / $n);
		if ($page > $pages) {
			$this->sendByAjax(array('code'=>2,'message'=>'没有数据了！'));
		}
		$start = ( $page - 1 ) * $n;
		$result = $this->db->select("SELECT c.cid,c.uid,u.username,c.content,c.dateline,c.support,c.oppose FROM `contents` as c, `users` as u WHERE u.uid=c.uid ORDER BY c.cid DESC LIMIT {$start},{$n}");
		$data = array(
			'count'	=>	$count,
			'pages'	=>	$pages,
			'page'	=>	$page,
			'n'		=>	$n,
			'list'	=>	$result
		);
		$this->sendByAjax(array('code'=>0,'message'=>'','data'=>$data));
	}

	/**
	 * @ 用户名验证
	 */
	private function _verifyUserName($username='') {
		if (strlen($username) < 3 || strlen($username) > 16) {
			return 1;
		}
		$rs = $this->db->get("SELECT `username` FROM `users` WHERE `username`='{$username}'");
		if ($rs) return 2;
		return 0;
	}
}