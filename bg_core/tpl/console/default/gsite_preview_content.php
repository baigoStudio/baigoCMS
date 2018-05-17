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
            <span class="oi oi-loop-circular bg-spin"></span>
            Loading...
        </h1>
    </div>

    <h3>
        <a href="<?php echo $this->tplData['contentRow']['url']; ?>" target="_blank"><?php echo $this->tplData['contentRow']['title']; ?></a>
    </h3>

    <div>
        <ul class="bg-nav-line">
            <?php if (isset($this->tplData['contentRow']['time'])) { ?>
                <li>
                    <?php echo $this->lang['mod']['label']['time'], ' ', $this->tplData['contentRow']['time']; ?>
                </li>
            <?php }

            if (isset($this->tplData['contentRow']['source'])) { ?>
                <li>
                    <?php echo $this->lang['mod']['label']['source'], ' ', $this->tplData['contentRow']['source']; ?>
                </li>
            <?php }

            if (isset($this->tplData['contentRow']['author'])) { ?>
                <li>
                    <?php echo $this->lang['mod']['label']['author'], ' ', $this->tplData['contentRow']['author']; ?>
                </li>
            <?php } ?>
        </ul>
    </div>

    <div><?php echo $this->tplData['contentRow']['content']; ?></div>

    <script type="text/javascript">
    $(document).ready(function(){
        $(".loading").hide();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php');