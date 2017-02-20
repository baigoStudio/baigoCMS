<?php $cfg = array(
    "title"  => "提示信息"
);

$_str_status = substr($this->tplData["rcode"], 0, 1);

include("include/pub_head.php"); ?>

    <div class="page-header">
        <h1>
            <?php echo $this->lang["page"]["rcode"]; ?>
        </h1>
    </div>

    <div class="alert alert-<?php if ($_str_status == "y") { ?>success<?php } else { ?>danger<?php } ?>">
        <h3>
            <span class="glyphicon glyphicon-<?php if ($_str_status == "y") { ?>ok-sign<?php } else { ?>remove-sign<?php } ?>"></span>
            <?php if (isset($this->tplData["rcode"]) && !fn_isEmpty($this->tplData["rcode"]) && isset($this->rcode[$this->tplData["rcode"]])) {
                echo $this->rcode[$this->tplData["rcode"]];
            } ?>
        </h3>

        <p>
            <a href="javascript:history.go(-1);">
                <span class="glyphicon glyphicon-chevron-left"></span>
                返回
            </a>
        </p>
        <hr>
        <p>
            提示信息 : <?php if (isset($this->tplData["rcode"]) && !fn_isEmpty($this->tplData["rcode"]) {
                echo $this->tplData["rcode"];
            }?>
        </p>
    </div>
</div>

<?php include("include/pub_foot.php");
include("include/html_foot.php"); ?>