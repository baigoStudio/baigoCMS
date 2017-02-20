<?php $cfg = array(
    "sub_title"     => $this->lang["page"]["rcode"],
    "mod_help"      => "install",
    "act_help"      => "ext",
    "pathInclude"   => BG_PATH_TPLSYS . "install/default/include/",
);

$_str_status = substr($this->tplData["rcode"], 0, 1);
?>

<?php include($cfg["pathInclude"] . "setup_head.php"); ?>

    <div class="alert alert-<?php if ($_str_status == "y") { ?>success<?php } else { ?>danger<?php } ?>">
        <span class="glyphicon glyphicon-<?php if ($_str_status == "y") { ?>ok-sign<?php } else { ?>remove-sign<?php } ?>"></span>
        <?php if (isset($this->tplData["rcode"]) && !fn_isEmpty($this->tplData["rcode"]) && isset($this->rcode[$this->tplData["rcode"]])) {
            echo $this->rcode[$this->tplData["rcode"]];
        } ?>
    </div>

    <p>
        <?php echo $this->lang["label"]["rcode"]; ?>
        :
        <?php if (isset($this->tplData["rcode"]) && !fn_isEmpty($this->tplData["rcode"])) {
            echo $this->tplData["rcode"];
        } ?>
    </p>

    <?php if (isset($this->tplData["rcode"]) && !fn_isEmpty($this->tplData["rcode"]) && isset($this->install[$this->tplData["rcode"]])) {
        echo $this->install[$this->tplData["rcode"]];
    } ?>

<?php include($cfg["pathInclude"] . "install_foot.php");
include($cfg["pathInclude"] . "html_foot.php"); ?>