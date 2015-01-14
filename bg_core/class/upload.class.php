<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/*-------------上传类-------------*/
class CLASS_UPLOAD {

	private $obj_ftp;
	private $obj_dir;
	private $uploadMime; //允许上传类型
	private $uploadThumb; //缩略图
	private $uploadSize; //允许上传大小
	private $attachExt; //扩展名
	private $attachPath; //路径
	private $attachUrl; //URL
	private $attachName; //文件名
	private $fileTmp;
	private $mime;
	public $config;

	function __construct() { //构造函数
		$this->obj_base           = $GLOBALS["obj_base"]; //获取界面类型
		$this->config             = $this->obj_base->config;
		$this->config["img_ext"]  = $GLOBALS["img_ext"];
		$this->obj_dir            = new CLASS_DIR();
		$this->mime               = include_once(BG_PATH_LANG . $this->config["lang"] . "/mime.php");
		if (BG_MODULE_FTP == true && defined("BG_UPLOAD_FTPHOST") && strlen(BG_UPLOAD_FTPHOST) > 1) {
			$this->obj_ftp = new CLASS_FTP(); //设置 FTP 对象
		}
	}


	/** 上传初始化
	 * upload_init function.
	 *
	 * @access public
	 * @param mixed $arr_mime 允许上传类型数组
	 * @param mixed $arr_thumb 缩略图数组
	 * @return void
	 */
	function upload_init($arr_mime, $arr_thumb) {
		switch (BG_UPLOAD_UNIT) { //初始化单位
			case "B":
				$_num_sizeUnit = 1;
			break;

			case "KB":
				$_num_sizeUnit = 1024;
			break;

			case "MB":
				$_num_sizeUnit = 1024 * 1024;
			break;

			case "GB":
				$_num_sizeUnit = 1024 * 1024 * 1024;
			break;
		}
		$this->uploadSize = BG_UPLOAD_SIZE * $_num_sizeUnit;
		if (BG_MODULE_FTP == true && defined("BG_UPLOAD_FTPHOST") && strlen(BG_UPLOAD_FTPHOST) > 1) {
			$_ftp_status = $this->obj_ftp->ftp_conn(BG_UPLOAD_FTPHOST, BG_UPLOAD_FTPPORT);
			if (!$_ftp_status) {
				return array(
					"str_alert" => "x030301",
				);
				exit;
			}
			$_ftp_status = $this->obj_ftp->ftp_login(BG_UPLOAD_FTPUSER, BG_UPLOAD_FTPPASS);
			if (!$_ftp_status) {
				return array(
					"str_alert" => "x030302",
				);
				exit;
			}
		}

		$this->uploadMime     = $arr_mime;
		$this->uploadThumb    = $arr_thumb;

		return array(
			"str_alert" => "y070403",
		);
	}


	/** 上传预处理
	 * upload_pre function.
	 *
	 * @access public
	 * @return void
	 */
	function upload_pre() {
		$this->attachFiles = $_FILES["attach_files"];

		switch ($this->attachFiles["error"]) { //返回错误
			case 1:
				return array(
					"str_alert" => "x100201",
				);
				exit;
			break;
			case 2:
				return array(
					"str_alert" => "x100202",
				);
				exit;
			break;
			case 3:
				return array(
					"str_alert" => "x100203",
				);
				exit;
			break;
			case 4:
				return array(
					"str_alert" => "x100204",
				);
				exit;
			break;
			case 6:
				return array(
					"str_alert" => "x100206",
				);
				exit;
			break;
			case 7:
				return array(
					"str_alert" => "x100207",
				);
				exit;
			break;
		}

		$_str_ext                 = pathinfo($this->attachFiles["name"], PATHINFO_EXTENSION); //取得扩展名
		$this->attachFiles["ext"] = strtolower($_str_ext); //扩展名

		if (!in_array($this->attachFiles["ext"], $this->uploadMime)) { //是否允许
			return array(
				"str_alert" => "x070202",
			);
			exit;
		}

		if ($this->attachFiles["size"] > $this->uploadSize) { //是否超过尺寸
			return array(
				"str_alert" => "x070203",
			);
			exit;
		}

		if (in_array($this->attachFiles["ext"], $this->config["img_ext"])) { //根据扩展名判断为图片
			$_str_type = getimagesize($this->attachFiles["tmp_name"]); //获取图片信息
			if ($_str_type) { //如果成功则为图片
				$_str_extChk = $this->mime[$_str_type["mime"]]["ext"];
				if ($_str_extChk != $this->attachFiles["ext"]) { //判断图片类型与扩展名是否一致
					$this->attachFiles["ext"] = $_str_extChk;
				}
			}
		}

		return array(
			"attach_tmp"     => $this->attachFiles["tmp_name"],
			"attach_ext"     => $this->attachFiles["ext"],
			"attach_name"    => $this->attachFiles["name"],
			"attach_size"    => $this->attachFiles["size"],
			"str_alert"      => "y100201",
		);
	}


	/** 提交上传
	 * upload_submit function.
	 *
	 * @access public
	 * @param mixed $tm_time 上传时间
	 * @param mixed $num_attachId 文件ID
	 * @return void
	 */
	function upload_submit($tm_time, $num_attachId) {

		if (BG_MODULE_FTP == true && defined("BG_UPLOAD_FTPHOST") && strlen(BG_UPLOAD_FTPHOST) > 1) { //如果定义了FTP服务器，则上传到FTP
			$this->attachPath = BG_PATH_ATTACH;
		} else {
			$this->attachPath = BG_PATH_ATTACH . date("Y", $tm_time) . "/" . date("m", $tm_time) . "/";
		}
		$this->attachUrl = BG_UPLOAD_URL . BG_URL_ATTACH . date("Y", $tm_time) . "/" . date("m", $tm_time) . "/";
		$this->attachFtp = "/" . date("Y", $tm_time) . "/" . date("m", $tm_time) . "/";

		if (!$this->obj_dir->mk_dir($this->attachPath)) { //建目录失败
			return array(
				"str_alert" => "x100101",
			);
			exit;
		}

		$this->attachName = $num_attachId; //原始文件名

		move_uploaded_file($this->attachFiles["tmp_name"], $this->attachPath . $this->attachName . "." . $this->attachFiles["ext"]); //将上传的文件移到指定路径

		if (BG_MODULE_FTP == true && defined("BG_UPLOAD_FTPHOST") && strlen(BG_UPLOAD_FTPHOST) > 1) { //如果定义了FTP服务器，则上传到FTP
			$_ftp_status = $this->obj_ftp->up_file($this->attachPath . $this->attachName . "." . $this->attachFiles["ext"], BG_UPLOAD_FTPPATH . $this->attachFtp . $this->attachName . "." . $this->attachFiles["ext"]);
			if (!$_ftp_status) {
				return array(
					"str_alert" => "x030303",
				);
				exit;
			}
		}

		if (in_array($this->attachFiles["ext"], $this->config["img_ext"])) { //如果是图片，则生成缩略图
			foreach ($this->uploadThumb as $_value) {
				//file_put_contents(BG_PATH_ATTACH . "test.txt", $_value["thumb_width"] . " - " . $_value["thumb_height" . " - " . $_value["thumb_type"], FILE_APPEND);
				$_arr_thumbRow = $this->thumb_do($_value["thumb_width"], $_value["thumb_height"], $_value["thumb_type"]);
			}
		}

		if (BG_MODULE_FTP == true && defined("BG_UPLOAD_FTPHOST") && strlen(BG_UPLOAD_FTPHOST) > 1 && file_exists($this->attachPath . $this->attachName . "." . $this->attachFiles["ext"])) { //如果FTP上传成功，且文件存在，在上传完成后删除
			unlink($this->attachPath . $this->attachName . "." . $this->attachFiles["ext"]);
		}

		return array(
			"attach_path"    => $this->attachPath . $this->attachName . "." . $this->attachFiles["ext"],
			"attach_url"     => $this->attachUrl . $this->attachName . "." . $this->attachFiles["ext"],
			"str_alert"      => "y070401",
		);
	}


	/** 删除
	 * upload_del function.
	 *
	 * @access public
	 * @param mixed $arr_attach 预删除的文件数组
	 * @return void
	 */
	function upload_del($arr_attach) {
		foreach ($arr_attach as $_value) {
			$_str_filePath = date("Y", $_value["attach_time"]) . "/" . date("m", $_value["attach_time"]) . "/" . $_value["attach_id"] . "." . $_value["attach_ext"];

			if (file_exists(BG_PATH_ATTACH . $_str_filePath)) { //文件是否存在
				unlink(BG_PATH_ATTACH . $_str_filePath);
			}

			if (BG_MODULE_FTP == true && defined("BG_UPLOAD_FTPHOST") && strlen(BG_UPLOAD_FTPHOST) > 1) { //是否定义FTP服务器
				$this->obj_ftp->del_file(BG_UPLOAD_FTPPATH . "/" . $_str_filePath);
			}

			if (in_array($_value["attach_ext"], $this->config["img_ext"])) { //是否为图片
				foreach ($this->uploadThumb as $_value_thumb) { //删除缩略图
					$_str_thumbPath = date("Y", $_value["attach_time"]) . "/" . date("m", $_value["attach_time"]) . "/" . $_value["attach_id"] . "_" . $_value_thumb["thumb_width"] . "_" . $_value_thumb["thumb_height"] . "_" . $_value_thumb["thumb_type"] . "." . $_value["attach_ext"];

					if (file_exists(BG_PATH_ATTACH . $_str_thumbPath)) {
						unlink(BG_PATH_ATTACH . $_str_thumbPath);
					}

					if (BG_MODULE_FTP == true && defined("BG_UPLOAD_FTPHOST") && strlen(BG_UPLOAD_FTPHOST) > 1) {
						$this->obj_ftp->del_file(BG_UPLOAD_FTPPATH . "/" . $_str_thumbPath);
					}
				}
			}
		}
	}


	/** 生成缩略图
	 * thumb_do function.
	 *
	 * @access public
	 * @param mixed $num_width 宽度
	 * @param mixed $num_height 高度
	 * @param string $str_type (default: "ratio") 类型（默认等比例）
	 * @return void
	 */
	function thumb_do($num_width, $num_height, $str_type = "ratio") {

		$_str_srcFile = $this->attachPath . $this->attachName . "." . $this->attachFiles["ext"]; //源图片
		$_str_dstFile = $this->attachPath . $this->attachName . "_" . $num_width . "_" . $num_height . "_" . $str_type . "." . $this->attachFiles["ext"]; //目标缩略图

		switch ($this->attachFiles["ext"]) { //创建图片对象
			case "jpg":
			case "jpe":
			case "jpeg":
				$_src_image = imagecreatefromjpeg($_str_srcFile);
			break;

			case "gif":
				$_src_image = imagecreatefromgif($_str_srcFile);
			break;

			case "png":
				$_src_image = imagecreatefrompng($_str_srcFile);
			break;

			case "bmp":
				$_src_image = imagecreatefromwbmp($_str_srcFile);
			break;
		}

		$_width_src       = imagesx($_src_image); //取得源图片的尺寸
		$_height_src      = imagesy($_src_image);
		$_arr_thumb_size  = $this->thumb_size($num_width, $num_height, $_width_src, $_height_src, $str_type); //计算缩略图尺寸

		if ($_arr_thumb_size["width_dst"] >= $_width_src && $_arr_thumb_size["height_dst"] >= $_height_src) { //如果源图片小于目标缩略图，则只是拷贝
			copy($_str_srcFile, $_str_dstFile);

			if (BG_MODULE_FTP == true && defined("BG_UPLOAD_FTPHOST") && strlen(BG_UPLOAD_FTPHOST) > 1) { //如果定义了FTP服务器，则上传
				$this->obj_ftp->up_file($_str_dstFile, BG_UPLOAD_FTPPATH . $this->attachFtp . $this->attachName . "_" . $num_width . "_" . $num_height . "_" . $str_type . "." . $this->attachFiles["ext"]);
				if (file_exists($_str_dstFile)) {
					unlink($_str_dstFile);
				}
			}

			return array(
				"str_alert" => "x070402",
			);
			exit;
		}

		$_dst_image = imagecreatetruecolor($_arr_thumb_size["width_dst"], $_arr_thumb_size["height_dst"]); //根据计算结果生成毛图片

		switch ($str_type) {
			case "cut": //裁切
				$_tmp_image = imagecreatetruecolor($_arr_thumb_size["width_tmp"], $_arr_thumb_size["height_tmp"]);
				imagecopyresampled($_tmp_image, $_src_image, 0, 0, 0, 0, $_arr_thumb_size["width_tmp"], $_arr_thumb_size["height_tmp"], $_width_src, $_height_src); //先缩小
				imagecopymerge($_dst_image, $_tmp_image, 0, 0, $_arr_thumb_size["width_cut"], $_arr_thumb_size["height_cut"], $_arr_thumb_size["width_dst"], $_arr_thumb_size["height_dst"], 100); //合成
				imagedestroy($_tmp_image);
			break;
			default: //按比例缩小
				imagecopyresampled($_dst_image, $_src_image, 0, 0, 0, 0, $_arr_thumb_size["width_tmp"], $_arr_thumb_size["height_tmp"], $_width_src, $_height_src); //直接缩小
			break;
		}

		switch ($this->attachFiles["ext"]) { //生成最终图片
			case "jpg":
			case "jpe":
			case "jpeg":
				imagejpeg($_dst_image, $_str_dstFile);
			break;

			case "gif":
				imagegif($_dst_image, $_str_dstFile);
			break;

			case "png":
				imagepng($_dst_image, $_str_dstFile);
			break;

			case "bmp":
				imagewbmp($_dst_image, $_str_dstFile);
			break;
		}

		imagedestroy($_src_image); //清空对象
		imagedestroy($_dst_image);

		if (BG_MODULE_FTP == true && defined("BG_UPLOAD_FTPHOST") && strlen(BG_UPLOAD_FTPHOST) > 1) { //如果定义了FTP服务器，则上传
			$this->obj_ftp->up_file($_str_dstFile, BG_UPLOAD_FTPPATH . $this->attachFtp . $this->attachName . "_" . $num_width . "_" . $num_height . "_" . $str_type . "." . $this->attachFiles["ext"]);
			if (file_exists($_str_dstFile)) {
				unlink($_str_dstFile);
			}
		}

		return array(
			"str_alert" => "y070402",
		);
	}


	/** 计算缩略图尺寸
	 * thumb_size function.
	 *
	 * @access public
	 * @param mixed $num_width 宽度
	 * @param mixed $num_height 高度
	 * @param mixed $width_src 原始宽度
	 * @param mixed $height_src 原始高度
	 * @param string $str_type (default: "ratio") 类型（默认等比例）
	 * @return void
	 */
	function thumb_size($num_width, $num_height, $width_src, $height_src, $str_type = "ratio") {

		switch ($str_type) {
			case "cut": //裁切
				if ($width_src > $height_src) { //横向
					$_height_tmp   = intval($num_height); //缩小高度
					$_width_tmp    = intval($width_src / $height_src * $_height_tmp); //按比例计算宽度
					$_height_cut   = 0;
					$_width_cut    = intval(($_width_tmp - $num_width) / 2); //需裁切的部分
					if ($_width_tmp < $num_width) { //如缩小后，宽度小于设定的宽度，则按照宽度重新计算
						$_width_tmp   = intval($num_width);
						$_height_tmp  = intval($_width_tmp / ($width_src / $height_src));
						$_width_cut   = 0;
						$_height_cut  = intval(($_height_tmp - $num_height) / 2);
					}
				} else { //纵向
					$_width_tmp    = intval($num_width);
					$_height_tmp   = intval($height_src / $width_src * $_width_tmp); //按比例计算高度
					$_width_cut    = 0;
					$_height_cut   = intval(($_height_tmp - $num_height) / 2); //需裁切的部分
					if ($_height_tmp < $num_height) { //如缩小后，高度小于设定的高度，则按照高度重新计算
						$_height_tmp  = intval($num_height);
						$_width_tmp   = intval($_height_tmp / ($height_src / $width_src));
						$_height_cut  = 0;
						$_width_cut   = intval(($_width_tmp - $num_width) / 2);
					}
				}

				$_width_dst     = $num_width;
				$_height_dst    = $num_height;
			break;

			default: //按比例缩小
				if ($width_src > $height_src) { //横向
					$_width_tmp    = intval($num_width);
					$_height_tmp   = intval($height_src / $width_src * $_width_tmp); //按比例计算高度
				} else { //纵向
					$_height_tmp   = intval($num_height); //缩小高度
					$_width_tmp    = intval($width_src / $height_src * $_height_tmp); //按比例计算宽度
				}
				$_width_cut     = 0;
				$_height_cut    = 0;
				$_width_dst     = $_width_tmp;
				$_height_dst    = $_height_tmp;
			break;
		}

		return array(
			"width_tmp"  => $_width_tmp,
			"height_tmp" => $_height_tmp,
			"width_cut"  => $_width_cut,
			"height_cut" => $_height_cut,
			"width_dst"  => $_width_dst,
			"height_dst" => $_height_dst,
		);
	}


	/**
	 * __destruct function.
	 *
	 * @access public
	 * @return void
	 */
	function __destruct() { //析构函数
		if (BG_MODULE_FTP == true && defined("BG_UPLOAD_FTPHOST") && strlen(BG_UPLOAD_FTPHOST) > 1) {
			$this->obj_ftp->close();
		}
	}
}
?>