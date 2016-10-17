<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined("IN_BAIGO")) {
    exit("Access Denied");
}

/*-------------文件夹操作类类-------------*/
class CLASS_DIR {

    public $dir_status; //返回操作状态(成功/失败)


    /**
     * del_dir function.
     *
     * @access public
     * @param mixed $str_path
     * @return void
     */
    function del_dir($str_path) {

        //删除目录及目录里所有的文件夹和文件
        if (is_dir($str_path)) {
            $_arr_dir = $this->list_dir($str_path); //逐级列出

            foreach ($_arr_dir as $_key=>$_value) {
                if ($_value["type"] == "file") {
                    $this->del_file($str_path . "/" . $_value["name"]);  //删除
                } else {
                    $this->del_dir($str_path . "/" . $_value["name"]); //递归
                }
            }

            rmdir($str_path);
        }
    }


    /**
     * mk_dir function.
     *
     * @access public
     * @param mixed $str_path
     * @return void
     */
    function mk_dir($str_path) {
        if (stristr($str_path, ".")) {
            $str_path = dirname($str_path);
        }
        if (is_dir($str_path) || stristr($str_path, ".")) { //已存在
            $this->dir_status = true;
        } else {
            //创建目录
            if ($this->mk_dir(dirname($str_path))) { //递归
                if (mkdir($str_path)) { //创建成功
                    $this->dir_status = true;
                } else {
                    $this->dir_status = false; //失败
                }
            } else {
                $this->dir_status = false;
            }
        }

        return $this->dir_status;
    }


    /**
     * list_dir function.
     *
     * @access public
     * @param mixed $str_path
     * @return void
     */
    function list_dir($str_path) {

        $this->mk_dir($str_path);

        $_arr_return  = array();
        $_arr_dir     = scandir($str_path);

        if ($_arr_dir) {
            foreach ($_arr_dir as $_key=>$_value) {
                if ($_value != "." && $_value != "..") {
                    if (is_dir($str_path . $_value)) {
                        $_arr_return[$_key]["type"] = "dir";
                    } else {
                        $_arr_return[$_key]["type"] = "file";
                    }

                    $_arr_return[$_key]["name"] = $_value;
                }
            }
        }

        return $_arr_return;
    }


    function del_file($str_path) {
        $bool_return = false;
        if (file_exists($str_path)) {
            unlink($str_path);  //删除
            $bool_return = true;
        }
        return $bool_return;
    }


    function put_file($str_path, $str_content) {
        $this->mk_dir($str_path);
        $_num_size = file_put_contents($str_path, $str_content);
        return $_num_size;
    }


    function copy_file($str_src, $str_dst) {
        $bool_return = false;
        $this->mk_dir($str_dst);
        if (file_exists($str_src)) {
            $bool_return = copy($str_src, $str_dst);
        }
        return $bool_return;
    }
}