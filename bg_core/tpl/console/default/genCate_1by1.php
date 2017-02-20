<?php $cfg = array(
    "title"         => $this->lang["page"]["gening"],
    "pathInclude"   => BG_PATH_TPLSYS . "console/default/include/",
);

include($cfg["pathInclude"] . "html_head.php");
    
    switch($this->tplData["status"]) {
        case "complete":
            if ($this->tplData["overall"] == "true") { ?>
                <meta http-equiv="refresh" content="0; url=<?php echo BG_URL_CONSOLE; ?>gen.php?mod=call&act=1by1&overall=true">
            <?php } else { ?>
                <div class="alert alert-success">
                    <span class="glyphicon glyphicon-ok-sign"></span>
                    <?php echo $this->rcode["y250403"]; ?>
                </div>
            <?php }
        break;

        case "without": ?>
            <div class="alert alert-warning">
                <h4>
                    <?php echo $this->lang["label"]["cate"]; ?>
                    <?php echo $this->tplData["cateRow"]["cate_name"]; ?>
                </h4>
                <hr class="bg-alert-hr">
                <div>
                    <?php echo $this->lang["label"]["id"]; ?>
                    <?php echo $this->tplData["cateRow"]["cate_id"]; ?>
                </div>
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
                    <?php echo $this->tplData["pageRow"]["page"]; ?> 
                    <?php echo $this->lang["label"]["pagePage"]; ?>
                </div>
            </div>
        <?php break;
    }

    if ($this->tplData["status"] == "loading") {
        $num_page = $this->tplData["pageRow"]["page"] + 1;
    } else {
        $num_page = 1;
    }

    if ($this->tplData["status"] != "complete") { ?>
        <meta http-equiv="refresh" content="0; url=<?php echo BG_URL_CONSOLE; ?>gen.php?mod=cate&act=1by1&min_id=<?php echo $this->tplData["min_id"]; ?>&page=<?php echo $num_page; ?>&overall=<?php echo $this->tplData["overall"]; ?>">
    <?php }

include($cfg["pathInclude"] . "html_foot.php"); ?>
