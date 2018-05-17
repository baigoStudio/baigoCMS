<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['article']['main']['title'] . ' &raquo; ' . $this->lang['mod']['page']['show'],
    'menu_active'    => 'article',
    'sub_active'     => "list",
    "tooltip"        => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'html_head.php'); ?>

    <p class="bg-content">
        <?php echo $this->tplData['articleRow']['article_content']; ?>
    </p>

<?php include('include' . DS . 'html_foot.php');