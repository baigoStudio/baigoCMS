<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['group']['main']['title'] . ' &raquo; ' . $this->lang['mod']['page']['show'],
    'menu_active'    => 'group',
    'sub_active'     => "list",
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=group&a=list" class="nav-link">
                <span class="oi oi-chevron-left"></span>
                <?php echo $this->lang['common']['href']['back']; ?>
            </a>
        </li>
    </ul>

    <div class="row">
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['groupName']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['groupRow']['group_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['groupAllow']; ?></label>
                        <?php allow_list($this->consoleMod, $this->lang['consoleMod'], $this->opt, $this->lang['opt'], $this->lang['mod'], $this->lang['common'], $this->tplData['groupRow']['group_allow'], false); ?>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['note']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['groupRow']['group_note']; ?></div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=group&a=form&group_id=<?php echo $this->tplData['groupRow']['group_id']; ?>">
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
                        <div class="form-text"><?php echo $this->tplData['groupRow']['group_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['status']; ?></label>
                        <div class="form-text">
                            <?php group_status_process($this->tplData['groupRow']['group_status'], $this->lang['mod']['status']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['type']; ?></label>
                        <div class="form-text">
                            <?php if (isset($this->lang['mod']['type'][$this->tplData['groupRow']['group_type']])) {
                                echo $this->lang['mod']['type'][$this->tplData['groupRow']['group_type']];
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php');
include('include' . DS . 'html_foot.php');
