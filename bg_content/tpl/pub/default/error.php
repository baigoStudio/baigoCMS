<?php $cfg = array(
    'title'  => '提示信息'
);

$_str_status = substr($this->tplData['rcode'], 0, 1);

include('include' . DS . 'pub_head.php'); ?>

    <div class="page-header">
        <h1>提示信息</h1>
    </div>

    <div class="alert alert-<?php if ($_str_status == 'y') { ?>success<?php } else { ?>danger<?php } ?>">
        <h3>
            <span class="oi oi-<?php if ($_str_status == 'y') { ?>circle-check<?php } else { ?>circle-x<?php } ?>"></span>
            <?php if (isset($this->tplData['rcode']) && !fn_isEmpty($this->tplData['rcode']) && isset($this->lang['rcode'][$this->tplData['rcode']])) {
                echo $this->lang['rcode'][$this->tplData['rcode']];
            } ?>
        </h3>

        <div>
            <a href="javascript:history.go(-1);">
                <span class="oi oi-chevron-left"></span>
                返回
            </a>
        </div>
        <hr>
        <div>
            提示信息 <?php if (isset($this->tplData['rcode']) && !fn_isEmpty($this->tplData['rcode'])) {
                echo $this->tplData['rcode'];
            } ?>
        </div>
    </div>
</div>

<?php include('include' . DS . 'pub_foot.php');
include('include' . DS . 'html_foot.php');