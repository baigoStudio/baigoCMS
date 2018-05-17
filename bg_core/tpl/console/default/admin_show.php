<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['admin']['main']['title'] .  ' &raquo; ' . $this->lang['mod']['page']['show'],
    'menu_active'    => 'admin',
    'sub_active'     => "list",
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=admin&a=list" class="nav-link">
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
                        <label><?php echo $this->lang['mod']['label']['username']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['adminRow']['ssoRow']['user_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['mail']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['adminRow']['ssoRow']['user_mail']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['nick']; ?></label>
                        <div class="form-text">
                            <?php if (!fn_isEmpty($this->tplData['adminRow']['admin_nick'])) {
                                echo $this->tplData['adminRow']['admin_nick'];
                            } else {
                                echo $this->tplData['adminRow']['ssoRow']['user_nick'];
                            } ?>
                        </div>
                    </div>

                    <table class="table">
                        <thead>
                            <tr>
                                <th>
                                    <?php echo $this->lang['mod']['label']['cateAllow']; ?>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php cate_list_allow($this->tplData['cateRows'], $this->tplData['cateAllow'], $this->lang['mod'], $this->tplData['adminRow']['admin_allow_cate'], $this->tplData['adminLogged']['groupRow']['group_allow']['article'], $this->tplData['adminRow']['admin_type'], false); ?>
                        </tbody>
                    </table>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['note']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['adminRow']['admin_note']; ?></div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=admin&a=form&admin_id=<?php echo $this->tplData['adminRow']['admin_id']; ?>">
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
                        <div class="form-text"><?php echo $this->tplData['adminRow']['admin_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['type']; ?></label>
                        <div class="form-text">
                            <?php if (isset($this->lang['mod']['type'][$this->tplData['adminRow']['admin_type']])) {
                                echo $this->lang['mod']['type'][$this->tplData['adminRow']['admin_type']];
                            } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['status']; ?></label>
                        <div class="form-text">
                            <?php admin_status_process($this->tplData['adminRow']['admin_status'], $this->lang['mod']['status']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <?php foreach ($this->profile as $_key=>$_value) {
                            if (isset($this->tplData['adminRow']['admin_allow_profile'][$_key]) && $this->tplData['adminRow']['admin_allow_profile'][$_key] == 1) { ?>
                                <div>
                                    <span class="badge badge-danger">
                                        <?php echo $this->lang['mod']['label']['forbidModi'];
                                        if (isset($this->lang['common']['profile'][$_key]['title'])) {
                                            echo $this->lang['common']['profile'][$_key]['title'];
                                        } else {
                                            echo $_value['title'];
                                        } ?>
                                    </span>
                                </div>
                            <?php }
                        } ?>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['adminGroup']; ?></label>
                        <div class="form-text">
                            <?php if (isset($this->tplData['groupRow']['group_name']) && !fn_isEmpty($this->tplData['groupRow']['group_name'])) {
                                echo $this->tplData['groupRow']['group_name']; ?> | <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=group&a=show&group_id=<?php echo $this->tplData['adminRow']['admin_group_id']; ?>"><?php echo $this->lang['mod']['href']['show']; ?></a>
                            <?php } else {
                                echo $this->lang['mod']['label']['none'];
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php');
include($cfg['pathInclude'] . 'html_foot.php');