<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['gather']['sub']['gsite'],
    'menu_active'    => 'gather',
    'sub_active'     => 'gsite',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang['common']['href']['back']; ?>
                </a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['gsiteName']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['gsiteRow']['gsite_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['gsiteUrl']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['gsiteRow']['gsite_url']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['gsiteKeepTag']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['gsiteRow']['gsite_keep_tag']; ?></div>
                        <span class="help-block"><?php echo $this->lang['mod']['label']['gsiteKeepTagNote']; ?></span>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['note']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['gsiteRow']['gsite_note']; ?></div>
                    </div>
                </div>
                <div class="panel-footer">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gsite&act=form&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">
                        <span class="glyphicon glyphicon-edit"></span>
                        <?php echo $this->lang['mod']['href']['edit']; ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="well">
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData['gsiteRow']['gsite_id']; ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['belongCate']; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData['cateRow']['cate_name']; ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?></label>
                    <div class="form-control-static">
                        <?php gsite_status_process($this->tplData['gsiteRow']['gsite_status'], $this->lang['mod']['status']); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php');
include($cfg['pathInclude'] . 'html_foot.php'); ?>