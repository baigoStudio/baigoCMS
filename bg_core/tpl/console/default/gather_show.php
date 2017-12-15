<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['gather']['main']['title'] . ' &raquo; ' . $this->lang['mod']['page']['show'],
    'menu_active'    => 'gather',
    'sub_active'     => "approve",
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gather&act=list">
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
                        <label class="control-label"><?php echo $this->lang['mod']['label']['title']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['gatherRow']['gather_title']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['content']; ?></label>
                        <div>
                            <div class="embed-responsive embed-responsive-16by9">
                                <iframe class="embed-responsive-item" scrolling="auto" src="<?php echo BG_URL_CONSOLE; ?>index.php?mod=gather&act=show_content&gather_id=<?php echo $this->tplData['gatherRow']['gather_id']; ?>&view=iframe">
                                </iframe>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['source']; ?></label>
                        <div class="form-control-static">
                            <a href="<?php echo $this->tplData['gatherRow']['gather_source_url']; ?>" target="_blank">
                                <?php echo $this->tplData['gatherRow']['gather_source']; ?>
                            </a>
                        </div>
                    </div>

                    <?php if (isset($this->tplData['articleRow']['article_title'])) { ?>
                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['common']['label']['article']; ?></label>
                            <div class="form-control-static">
                                <a href="<?php echo BG_URL_CONSOLE, "index.php?mod=article&act=show&article_id=", $this->tplData['articleRow']['article_id']; ?>" target="_blank">
                                    <?php echo $this->tplData['articleRow']['article_title']; ?>
                                </a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="panel-footer">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=article&act=form&gather_id=<?php echo $this->tplData['gatherRow']['gather_id']; ?>">
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
                    <div class="form-control-static"><?php echo $this->tplData['gatherRow']['gather_id']; ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['author']; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData['gatherRow']['gather_author']; ?></div>
                </div>
                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['time']; ?></label>
                    <div class="form-control-static"><?php echo date(BG_SITE_DATE . ' ' . BG_SITE_TIMESHORT, $this->tplData['gatherRow']['gather_time_show']); ?></div>
                </div>

                <?php if (isset($this->tplData['cateRow']['cate_name'])) { ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['belongCate']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['cateRow']['cate_name']; ?></div>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?></label>
                    <div class="form-control-static">
                        <?php gather_status_process($this->tplData['gatherRow']['gather_article_id'], $this->lang['mod']['status']); ?>
                    </div>
                </div>

                <?php if (isset($this->tplData['adminRow']['admin_name'])) { ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['admin']; ?></label>
                        <div class="form-control-static">
                            <a href="<?php echo BG_URL_CONSOLE, "index.php?mod=admin&act=show&admin_id=", $this->tplData['adminRow']['admin_id']; ?>" target="_blank">
                                <?php echo $this->tplData['adminRow']['admin_name']; ?>
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="alert alert-warning">
                <h4><?php echo $this->lang['mod']['label']['gsite']; ?></h4>

                <?php if (isset($this->tplData['gsiteRow']['gsite_name'])) { ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['gsiteName']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['gsiteRow']['gsite_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['id']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['gsiteRow']['gsite_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?></label>
                        <div class="form-control-static">
                            <?php gsite_status_process($this->tplData['gsiteRow']['gsite_status'], $this->lang['mod']['status']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['gsiteUrl']; ?></label>
                        <div class="form-control-static bg-wrap-enforce">
                            <a href="<?php echo $this->tplData['gsiteRow']['gsite_url']; ?>" target="_blank"><?php echo $this->tplData['gsiteRow']['gsite_url']; ?></a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['note']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['gsiteRow']['gsite_note']; ?></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php');
include($cfg['pathInclude'] . 'html_foot.php'); ?>