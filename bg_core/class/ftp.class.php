<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if(!defined("IN_BAIGO")) {
	exit("Access Denied");
}

/**
* FTP操作类
*/
class CLASS_FTP {

	public $ftp_status; //返回操作状态(成功/失败)
	public $ftp_conn; //FTP连接


	/**v连接FTP服务器
	 * ftp_conn function.
	 *
	 * @access public
	 * @param mixed $ftp_host 服务器地址
	 * @param int $ftp_port (default: 21) 端口
	 * @return void
	 */
	function ftp_conn($ftp_host, $ftp_port = 21) {
		$this->ftp_conn = @ftp_connect($ftp_host, $ftp_port); //连接
		return $this->ftp_conn;
	}


	/** 登录
	 * ftp_login function.
	 *
	 * @access public
	 * @param mixed $ftp_user 用户名
	 * @param mixed $ftp_pass 密码
	 * @return void
	 */
	function ftp_login($ftp_user, $ftp_pass) {
		$this->ftp_status = @ftp_login($this->ftp_conn, $ftp_user, $ftp_pass); //登录
		ftp_pasv($this->ftp_conn, 1); // 打开被动模式
		return $this->ftp_status;
	}


	/** 上传文件
	 * up_file function.
	 *
	 * @access public
	 * @param mixed $path_local 本地路径
	 * @param mixed $path_remote 远程路径
	 * @return void
	 */
	function up_file($path_local, $path_remote) {
		$_arr_dirRow      = $this->mk_dir($path_remote); //建立目录
		$this->ftp_status = @ftp_put($this->ftp_conn, $path_remote, $path_local, FTP_BINARY); //上传
		return $this->ftp_status;
	}


	/** 删除文件
	 * del_file function.
	 *
	 * @access public
	 * @param mixed $path_remote 远程路径
	 * @return void
	 */
	function del_file($path_remote) {
		$this->ftp_status = @ftp_delete($this->ftp_conn, $path_remote);
		return $this->ftp_status;
	}


	/** 创建目录
	 * mk_dir function.
	 *
	 * @access public
	 * @param mixed $path_remote 远程路径
	 * @return void
	 */
	function mk_dir($path_remote) {
		if (stristr($path_remote, ".")) {
			$path_remote = dirname($path_remote);
		}
		if (@ftp_chdir($this->ftp_conn, $path_remote) || stristr($path_remote, ".")) { //已存在
			$this->ftp_status = true;
		} else {
			//创建目录
			if ($this->mk_dir(dirname($path_remote))) {
				if(@ftp_mkdir($this->ftp_conn, $path_remote)) {
					$this->ftp_status = true;
				} else {
					$this->ftp_status = false; //失败
				}
			} else {
				$this->ftp_status = false;
			}
		}

		return $this->ftp_status;
	}


	/** 关闭连接
	 * close function.
	 *
	 * @access public
	 * @return void
	 */
	function close() {
		@ftp_close($this->ftp_conn);
	}
}