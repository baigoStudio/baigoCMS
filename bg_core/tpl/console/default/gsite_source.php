<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['gather']['sub']['gsite'],
    "prism"          => 'true',
    'noToken'        => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS
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

    <h3><?php echo $this->tplData['sourceRow']['url']; ?></h3>

    <pre class="bg-pre-nostyle"><code class="language-markup"><?php echo $this->tplData['sourceRow']['content']; ?></code></pre>

    <script type="text/javascript">
    $(document).ready(function(){
        $(".loading").hide();
    });
    </script>

<?php include($cfg['pathInclude'] . 'html_foot.php'); ?>