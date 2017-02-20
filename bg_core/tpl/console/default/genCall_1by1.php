<?php $cfg = array(
    "title"         => $this->lang["page"]["gening"],
    "pathInclude"   => BG_PATH_TPLSYS . "console/default/include/",
);

include($cfg["pathInclude"] . "html_head.php");
    
    switch($this->tplData["status"]) {
        case "complete":
            if ($this->tplData["overall"] == "true") { ?>
                <meta http-equiv="refresh" content="0; url=<?php echo BG_URL_CONSOLE; ?>gen.php?mod=spec&act=1by1&overall=true">
            <?php } else { ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok-sign"></span>
                    <?php echo $this->rcode["y170403"]; ?>
                </div>
            <?php }
        break;

        case "without": ?>
            <div class="alert alert-warning">
                <h4>
                    <?php echo $this->lang["label"]["call"]; ?>
                    <?php echo $this->tplData["callRow"]["call_name"]; ?>
                </h4>
                <hr class="bg-alert-hr">
                <div>
                    <?php echo $this->lang["label"]["id"]; ?>
                    <?php echo $this->tplData["callRow"]["call_id"]; ?>
                </div>
                <span class="glyphicon glyphicon-warning-sign"></span>
                <?php echo $this->rcode["x170404"]; ?>
            </div>
        <?php break;

        default: ?>
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
    <?php break;
    }
        
    if ($this->tplData["status"] != "complete") { ?>
        <meta http-equiv="refresh" content="0; url=<?php echo BG_URL_CONSOLE; ?>gen.php?mod=call&act=1by1&min_id=<?php echo $this->tplData["min_id"]; ?>&overall=<?php echo $this->tplData["overall"]; ?>">
    <?php }

include($cfg["pathInclude"] . "html_foot.php"); ?>
