<?php $cfg = array(
    "title"         => $this->lang["page"]["gening"],
    "pathInclude"   => BG_PATH_TPLSYS . "console/default/include/",
);

include($cfg["pathInclude"] . "html_head.php");
    
    switch($this->tplData["status"]) {
        case "complete":
            if ($this->tplData["overall"] == "true") { ?>
                <meta http-equiv="refresh" content="0; url=<?php echo BG_URL_CONSOLE; ?>gen.php?mod=cate&act=1by1&overall=true">
            <?php } else { ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok-sign"></span>
                    <?php echo $this->rcode["y120403"]; ?>
                </div>
            <?php }
        break;

        case "without": ?>
            <div class="alert alert-warning">
                <h4>
                    <?php echo $this->lang["label"]["article"]; ?>
                    <?php echo $this->tplData["articleRow"]["article_title"]; ?>
                </h4>
                <hr class="bg-alert-hr">
                <div>
                    <?php echo $this->lang["label"]["id"]; ?>
                    <?php echo $this->tplData["articleRow"]["article_id"]; ?>
                </div>
                <span class="glyphicon glyphicon-warning-sign"></span>
                <?php echo $this->rcode["x120404"]; ?>
            </div>
        <?php break;

        default: ?>
            <div class="alert alert-info">
                <h4>
                    <?php echo $this->lang["label"]["article"]; ?>
                    <?php echo $this->tplData["articleRow"]["article_title"]; ?>
                </h4>
                <hr class="bg-alert-hr">
                <div>
                    <?php echo $this->lang["label"]["id"]; ?>
                    <?php echo $this->tplData["articleRow"]["article_id"]; ?>
                </div>
            </div>
        <?php break;
    }

    if ($this->tplData["status"] != "complete") { ?>
        <meta http-equiv="refresh" content="0; url=<?php echo BG_URL_CONSOLE; ?>gen.php?mod=article&act=1by1&max_id=<?php echo $this->tplData["max_id"]; ?>&enforce=<?php echo $this->tplData["enforce"]; ?>&overall=<?php echo $this->tplData["overall"]; ?>">
    <?php }
        
include($cfg["pathInclude"] . "html_foot.php"); ?>
