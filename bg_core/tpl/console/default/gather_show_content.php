<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['mod']['page']['show'],
    'menu_active'    => 'gather',
    'sub_active'     => "approve",
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'html_head.php'); ?>

    <p class="bg-content">
        <?php echo $this->tplData['gatherRow']['gather_content']; ?>
    </p>

<?php include('include' . DS . 'html_foot.php');