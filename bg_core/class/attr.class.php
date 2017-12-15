<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
exit('Access Denied');
}

/** HTML Attribute Filter
*  Date:  2013-09-22
*  Author: fdipzone
*  ver:  1.0
*
*  Func:
*  public strip        过滤属性
*  public setAllow     设置允许的属性
*  public setExcept    设置特例
*  public setIgnore    设置忽略的标记
*  private findEles    搜寻需要处理的元素
*  private findAttr    搜寻属性
*  private removeAttr  移除属性
*  private isExcept    判断是否特例
*  private createAttr  创建属性
*  private protect     特殊字符转义
*/

class CLASS_ATTR { // class start

    private $_str       = '';       // 源字符串
    private $_allow     = array();  // 允许保留的属性 例如:array('id','class','title')
    private $_except    = array();  // 特例 例如:array('a'=>array('href','class'),'span'=>array('class'))
    private $_ignore    = array();  // 忽略过滤的标记 例如:array('span','img')


    /** 处理HTML,过滤不保留的属性
    * @param String $str 源字符串
    * @return String
    */
    public function strip($str) {
        $this->_str = $str;

        if (is_string($this->_str) && strlen($this->_str)>0) { // 判断字符串

            $this->_str = strtolower($this->_str); // 转成小写

            $_obj_res = $this->findEles();
            if (is_string($_obj_res)) {
                return $_obj_res;
            }
            $_arr_nodeRows = $this->findAttr($_obj_res);

            //print_r($_arr_nodeRows);

            $this->removeAttr($_arr_nodeRows);
        }
        return $this->_str;
    }

    /** 设置允许的属性
    * @param Array $arr_allow
    */
    public function setAllow($arr_allow = array()) {
        $this->_allow = $arr_allow;
    }

    /** 设置特例
    * @param Array $arr_except
    */
    public function setExcept($arr_except = array()) {
        $this->_except = $arr_except;
    }

    /** 设置忽略的标记
    * @param Array $arr_ignore
    */
    public function setIgnore($arr_ignore = array()) {
        $this->_ignore = $arr_ignore;
    }

    /** 搜寻需要处理的元素 */
    private function findEles() {
        $_arr_nodeRows = array();
        preg_match_all('/<([^ !\/\>\n]+)([^>]*)>/i', $this->_str, $_arr_eleRows);
        foreach ($_arr_eleRows[1] as $_key_ele=>$_value_ele) {
            if (isset($_arr_eleRows[2][$_key_ele]) && !fn_isEmpty($_arr_eleRows[2][$_key_ele])) {
                if (is_array($this->_ignore) && !in_array($_arr_eleRows[1][$_key_ele], $this->_ignore)) {
                    $_arr_nodeRows[] = array(
                        'literal'   => $_arr_eleRows[0][$_key_ele],
                        'name'      => $_arr_eleRows[1][$_key_ele],
                        'attrs'     => $_arr_eleRows[2][$_key_ele],
                    );
                }
            }
        }

        if (!$_arr_nodeRows[0]) {
            return $this->_str;
        } else {
            return $_arr_nodeRows;
        }
    }

    /** 搜寻属性
    * @param Array $arr_nodeRows 需要处理的元素
    */
    private function findAttr($arr_nodeRows) {
        foreach ($arr_nodeRows as $_key_node=>$_value_node) {
            preg_match_all('/([^ =]+)\s*=\s*["|\']{0,1}([^"\']*)["|\']{0,1}/i', $_value_node['attrs'], $_arr_attrRows);
            if (isset($_arr_attrRows[1]) && !fn_isEmpty($_arr_attrRows[1])) {
                foreach ($_arr_attrRows[1] as $_key_attr=>$att) {
                    $_arr_attrs[] = array(
                        'literal'   => $_arr_attrRows[0][$_key_attr],
                        'name'      => $_arr_attrRows[1][$_key_attr],
                        'value'     => $_arr_attrRows[2][$_key_attr],
                    );
                }
                $arr_nodeRows[$_key_node]['attrs'] = $_arr_attrs;
            } else {
                $arr_nodeRows[$_key_node]['attrs'] = array();
            }
        }
        return $arr_nodeRows;
    }

    /** 移除属性
    * @param Array $arr_nodeRows 需要处理的元素
    */
    private function removeAttr($arr_nodeRows) {
        foreach ($arr_nodeRows as $_key_node=>$_value_node) {
            $_str_nodeName  = $_value_node['name'];
            $_str_newAttrs  = '';
            if (is_array($_value_node['attrs'])) {
                foreach ($_value_node['attrs'] as $_key_attr=>$_value_attr) {
                    if ((is_array($this->_allow) && in_array($_value_attr['name'], $this->_allow)) || $this->isExcept($_str_nodeName, $_value_attr['name'], $this->_except)) {
                        $_str_newAttrs = $this->createAttr($_str_newAttrs, $_value_attr['name'], $_value_attr['value']);
                    }
                }
            }
            if (fn_isEmpty($_str_newAttrs)) {
                $_str_replace = '<' . $_str_nodeName . '>';
            } else {
                $_str_replace = '<' . $_str_nodeName . ' ' . $_str_newAttrs . '>';
            }
            $this->_str = preg_replace('/' . $this->protect($_value_node['literal']) . '/', $_str_replace, $this->_str);
        }
    }

    /** 判断是否特例
    * @param String $str_eleName  元素名
    * @param String $str_attrName 属性名
    * @param Array $excepts   允许的特例
    * @return boolean
    */
    private function isExcept($str_eleName, $str_attrName) {
        if (array_key_exists($str_eleName, $this->_except)) {
            if (in_array($str_attrName, $this->_except[$str_eleName])) {
                return true;
            }
        }
        return false;
    }

    /** 创建属性
    * @param String $str_newAttrs
    * @param String $str_name
    * @param String $str_value
    * @return String
    */
    private function createAttr($str_newAttrs, $str_name, $str_value) {
        if (!fn_isEmpty($str_newAttrs)) {
            $str_newAttrs .= ' ';
        }
        $str_newAttrs .= $str_name . '="' . $str_value . '"';
        return $str_newAttrs;
    }


    /** 特殊字符转义
    * @param String $str 源字符串
    * @return String
    */
    private function protect($str) {
        $_arr_convers = array(
            '^'     => '\^',
            '['     => '\[',
            '.'     => '\.',
            '$'     => '\$',
            '{'     => '\{',
            '*'     => '\*',
            '('     => '\(',
            '\\'    => '\\\\',
            '/'     => '\/',
            '+'     => '\+',
            ')'     => '\)',
            '|'     => '\|',
            '?'     => '\?',
            '<'     => '\<',
            '>'     => '\>',
        );
        return strtr($str, $_arr_convers);
    }

} // class end