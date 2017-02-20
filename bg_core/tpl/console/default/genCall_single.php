<?php $cfg = array(
    "title"         => $this->lang["page"]["gening"],
    "pathInclude"   => BG_PATH_TPLSYS . "console/default/include/",
);

include($cfg["pathInclude"] . "html_head.php");
    if ($this->tplData["status"] == "complete") { ?>
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok-sign"></span>
            <?php echo $this->rcode["y120403"]; ?>
        </div>
    <?php } else { ?>
        <div class="alert alert-info">
            <h4>
                <?php echo $this->lang["label"]["call"]; ?>
                <?php echo $this->tplData["callRow"]["call_name"]; ?>
            </h4>
            <hr class="bg-alert-hr">
            <div>
                <?php echo $this->lang["label"]["id"]; ?>
                <?php echo $this->tplData["callRow"]["call_id"]; ?>
            </div>
        </div>
    <?php }
include($cfg["pathInclude"] . "html_foot.php"); ?>
