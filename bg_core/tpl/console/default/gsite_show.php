<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['consoleMod']['gather']['sub']['gsite'],
    'menu_active'    => 'gather',
    'sub_active'     => 'gsite',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <?php include($cfg['pathInclude'] . 'gsite_menu.php'); ?>
                <div class="card-body">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['gsiteName']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['gsiteRow']['gsite_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['gsiteUrl']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['gsiteRow']['gsite_url']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['gsiteKeepTag']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['gsiteRow']['gsite_keep_tag']; ?></div>
                        <small class="form-text"><?php echo $this->lang['mod']['label']['gsiteKeepTagNote']; ?></small>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['note']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['gsiteRow']['gsite_note']; ?></div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=gsite&a=form&gsite_id=<?php echo $this->tplData['gsiteRow']['gsite_id']; ?>">
                        <span class="oi oi-pencil"></span>
                        <?php echo $this->lang['mod']['href']['edit']; ?>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light">
                <div class="card-body">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['id']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['gsiteRow']['gsite_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['belongCate']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['cateRow']['cate_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['status']; ?></label>
                        <div class="form-text">
                            <?php gsite_status_process($this->tplData['gsiteRow']['gsite_status'], $this->lang['mod']['status']); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php');
include('include' . DS . 'html_foot.php');