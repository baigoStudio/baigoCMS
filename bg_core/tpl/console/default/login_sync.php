<?php $cfg = array(
    "title"          => $this->lang["page"]["consoleLogin"],
    "pathInclude"    => BG_PATH_TPLSYS . "console/default/include/",
);

include($cfg["pathInclude"] . "login_head.php"); ?>

        <h4>
            <span class="glyphicon glyphicon-refresh bg-spin"></span>
            <?php echo $this->lang["label"]["loging"]; ?>
        </h4>
        <div class="form-group">
            <?php echo $this->lang["text"]["notForward"]; ?>
        </div>
        <div class="form-group">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php" class="btn btn-primary"><?php echo $this->lang["href"]["forward"]; ?></a>
        </div>

<?php include($cfg["pathInclude"] . "login_foot.php"); ?>

    <script type="text/javascript">
    $(document).ready(function(){
        <?php if (fn_cookie("prefer_sync_sync") == "on" && isset($this->tplData["sync"]["urlRows"]) && $this->tplData["sync"]["urlRows"]) {
            foreach ($this->tplData["sync"]["urlRows"] as $key=>$value) { ?>
                $.ajax({
                    url: "<?php echo $value; ?>", //url
                    dataType: "jsonp", //数据格式为 jsonp 支持跨域提交
                    jsonpCallback: "s",
                    complete: function(_result){ //读取返回结果
                        //alert(_result.status);
                        <?php if ($value == end($this->tplData["sync"]["urlRows"])) { ?>
                            setTimeout("window.location.href = '<?php echo $this->tplData["forward"]; ?>'", 3000);
                        <?php } ?>
                    }
                });
            <?php }
        } else { ?>
            setTimeout("window.location.href = '<?php echo $this->tplData["forward"]; ?>'", 3000);
        <?php } ?>
    });
    </script>

<?php include($cfg["pathInclude"] . "html_foot.php"); ?>
