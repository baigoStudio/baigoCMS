<?php $cfg = array(
    "title"         => $this->lang["page"]["gening"],
    "pathInclude"   => BG_PATH_TPLSYS . "console/default/include/",
);

include($cfg["pathInclude"] . "html_head.php");
    
    if ($this->tplData["status"] == "complete") { ?>
        <div class="alert alert-success">
            <span class="glyphicon glyphicon-ok-sign"></span>
            <?php echo $this->rcode["y180403"]; ?>
        </div>
    <?php } else { ?>
        <div class="alert alert-info">
            <h4>
                <?php echo $this->lang["label"]["spec"]; ?> 
                <?php echo $this->tplData["specRow"]["spec_name"]; ?>
            </h4>
            <hr class="bg-alert-hr">
            <div>
                <?php echo $this->lang["label"]["id"]; ?> 
                <?php echo $this->tplData["specRow"]["spec_id"]; ?>
            </div>
            <div>
                <?php echo $this->lang["label"]["pageCount"]; ?> 
                <?php echo $this->tplData["pageRow"]["page"]; ?> 
                <?php echo $this->lang["label"]["pagePage"]; ?>
            </div>
        </div>
    <?php }
        
    if ($this->tplData["status"] == "loading") { ?>
        <meta http-equiv="refresh" content="0; url=<?php echo BG_URL_CONSOLE; ?>gen.php?mod=spec&act=single&spec_id=<?php echo $this->tplData["specRow"]["spec_id"]; ?>&page=<?php echo $this->tplData["pageRow"]["page"] + 1; ?>">
    <?php }

include($cfg["pathInclude"] . "html_foot.php"); ?>
