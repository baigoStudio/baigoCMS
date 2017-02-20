<?php $cfg = array(
    "title"         => $this->lang["page"]["gening"],
    "pathInclude"   => BG_PATH_TPLSYS . "console/default/include/",
);

include($cfg["pathInclude"] . "html_head.php");

    switch($this->tplData["status"]) {
        case "complete": ?>
            <div class="alert alert-success">
                <span class="glyphicon glyphicon-ok-sign"></span>
                <?php echo $this->rcode["y250403"]; ?>
            </div>
        <?php break;

        case "without": ?>
            <div class="alert alert-warning">
                <span class="glyphicon glyphicon-warning-sign"></span>
                <?php echo $this->rcode["x250404"]; ?>
            </div>
        <?php break;

        default: ?>
            <div class="alert alert-info">
                <h4>
                    <?php echo $this->lang["label"]["cate"]; ?>
                    <?php echo $this->tplData["cateRow"]["cate_name"]; ?>
                </h4>
                <hr class="bg-alert-hr">
                <div>
                    <?php echo $this->lang["label"]["id"]; ?> 
                    <?php echo $this->tplData["cateRow"]["cate_id"]; ?>
                </div>
                <div>
                    <?php echo $this->lang["label"]["pageCount"]; ?> 
                    <?php echo $this->tplData["pageRow"]["page"]; ?> <?php echo $this->lang["label"]["pagePage"]; ?>
                </div>
            </div>
        <?php break;
    }
        
    if ($this->tplData["status"] == "loading") { ?>
        <meta http-equiv="refresh" content="0; url=<?php echo BG_URL_CONSOLE; ?>gen.php?mod=cate&act=single&cate_id=<?php echo $this->tplData["cateRow"]["cate_id"]; ?>&page=<?php echo $this->tplData["pageRow"]["page"] + 1; ?>">
    <?php }

include($cfg["pathInclude"] . "html_foot.php"); ?>
