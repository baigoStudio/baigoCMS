<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['gather']['sub']['gsite'],
    'noToken'        => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'html_head.php'); ?>

    <style type="text/css">
    .loading {
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: #fff;
        text-align: center;
        padding-top: 100px;
    }
    </style>

    <div class="loading">
        <h1>
            <span class="glyphicon glyphicon-refresh bg-spin"></span>
            Loading...
        </h1>
    </div>

    <?php if (!fn_isEmpty($this->tplData['listRows'])) { ?>
        <ul>
            <?php foreach ($this->tplData['listRows'] as $_key=>$_value) { ?>
                <li>
                    <a href="<?php echo $_value['url']; ?>" target="_blank"><?php echo $_value['content']; ?></a>
                </li>
            <?php } ?>
        </ul>
    <?php } ?>

    <script type="text/javascript">
    $(document).ready(function(){
        $(".loading").hide();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>