<?php $cfg = array(
    'title'          => $this->lang['consoleMod']['call']['main']['title'] . ' &raquo; ' . $this->lang['mod']['page']['show'],
    'menu_active'    => "call",
    'sub_active'     => "list",
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <div class="form-group">
        <ul class="nav nav-pills bg-nav-pills">
            <li>
                <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=call&act=list">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <?php echo $this->lang['common']['href']['back']; ?>
                </a>
            </li>
            <li>
                <a href="<?php echo BG_URL_HELP; ?>index.php?mod=console&act=call#form" target="_blank">
                    <span class="glyphicon glyphicon-question-sign"></span>
                    <?php echo $this->lang['mod']['href']['help']; ?>
                </a>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['callFunc']; ?></label>
                        <div class="form-control-static">
                            <code>
                                <?php if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == 'static') {
                                    switch ($this->tplData['callRow']['call_file']) {
                                        case "js": ?>
                                            &lt;script src=&quot;<?php echo $this->tplData['callRow']['urlRow']['call_url']; ?>&quot; type=&quot;text/javascript&quot;&gt;&lt;/script&gt;
                                        <?php break;

                                        default: ?>
                                            &lt;!--#include virtual=&quot;<?php echo $this->tplData['callRow']['urlRow']['call_url']; ?>&quot; --&gt;
                                        <?php break;
                                    }
                                } else { ?>
                                    &lt;?php echo callDisplay(<?php echo $this->tplData['callRow']['call_id']; ?>); ?&gt;
                                <?php } ?>
                            </code>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['callName']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['callRow']['call_name']; ?></div>
                    </div>

                    <?php if ($this->tplData['callRow']['call_type'] == 'cate') { ?>
                        <div class="alert alert-success"><?php echo $this->lang['mod']['label']['callFilter']; ?></div>

                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['callCate']; ?></label>
                            <div class="form-control-static">
                                <div <?php if ($this->tplData['callRow']['call_cate_id'] < 1) { ?>class="text-primary"<?php } ?>>
                                    <?php if ($this->tplData['callRow']['call_cate_id'] < 1) { ?>
                                        <span class="glyphicon glyphicon-ok-sign"></span>
                                    <?php } else { ?>
                                        <span class="glyphicon glyphicon-remove-sign"></span>
                                    <?php } ?>

                                    <?php echo $this->lang['mod']['label']['allCate']; ?>
                                </div>
                                <table class="bg-table-empty">
                                    <tbody>
                                        <?php cate_list_radio($this->tplData['cateRows'], $this->lang['mod'], $this->tplData['callRow']['call_cate_id'], $this->tplData['callRow']['call_cate_excepts'], false); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php } else if ($this->tplData['callRow']['call_type'] != 'spec' && $this->tplData['callRow']['call_type'] != 'tag_list' && $this->tplData['callRow']['call_type'] != 'tag_rank' && $this->tplData['callRow']['call_type'] != 'link') { ?>
                        <div class="alert alert-success"><?php echo $this->lang['mod']['label']['callFilter']; ?></div>

                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['callCate']; ?></label>
                            <div class="form-control-static">
                                <table class="bg-table-empty">
                                    <tbody>
                                        <?php cate_list_checkbox($this->tplData['cateRows'], $this->tplData['callRow']['call_cate_ids'], "", false); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['common']['label']['spec']; ?></label>
                            <div class="form-control-static">
                                <?php foreach ($this->tplData['specRows'] as $key=>$value) { ?>
                                    <div class="text-primary">
                                        <span class="glyphicon glyphicon-ok-sign"></span>
                                        <?php echo $value['spec_name']; ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['callAttach']; ?></label>
                            <div class="form-control-static"><?php echo $this->lang['mod']['attach'][$this->tplData['callRow']['call_attach']]; ?></div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><?php echo $this->lang['mod']['label']['callMark']; ?></label>
                            <div class="form-control-static">
                                <?php foreach ($this->tplData['markRows'] as $key=>$value) { ?>
                                    <div <?php if (in_array($value['mark_id'], $this->tplData['callRow']['call_mark_ids'])) { ?>class="text-primary"<?php } ?>>
                                        <?php if (in_array($value['mark_id'], $this->tplData['callRow']['call_mark_ids'])) { ?>
                                            <span class="glyphicon glyphicon-ok-sign"></span>
                                        <?php } ?>

                                        <?php echo $value['mark_name']; ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="panel-footer">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?mod=call&act=form&call_id=<?php echo $this->tplData['callRow']['call_id']; ?>">
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
                    <div class="form-control-static"><?php echo $this->tplData['callRow']['call_id']; ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['type']; ?></label>
                    <div class="form-control-static">
                        <?php if (isset($this->lang['mod']['type'][$this->tplData['callRow']['call_type']])) {
                            echo $this->lang['mod']['type'][$this->tplData['callRow']['call_type']];
                        } ?>
                    </div>
                </div>

                <?php if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == 'static') { ?>
                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['callFile']; ?></label>
                        <div class="form-control-static"><?php echo $this->lang['mod']['file'][$this->tplData['callRow']['call_file']]; ?></div>
                    </div>

                    <div class="form-group">
                        <label class="control-label"><?php echo $this->lang['mod']['label']['callTpl']; ?></label>
                        <div class="form-control-static"><?php echo $this->tplData['callRow']['call_tpl']; ?></div>
                    </div>
                <?php } ?>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['status']; ?></label>
                    <div class="form-control-static">
                        <?php call_status_process($this->tplData['callRow']['call_status'], $this->lang['mod']['status']); ?>
                    </div>
                </div>

                <div class="alert alert-success"><?php echo $this->lang['mod']['label']['callAmount']; ?></div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['callAmoutTop']; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData['callRow']['call_amount']['top']; ?></div>
                </div>

                <div class="form-group">
                    <label class="control-label"><?php echo $this->lang['mod']['label']['callAmoutExcept']; ?></label>
                    <div class="form-control-static"><?php echo $this->tplData['callRow']['call_amount']['except']; ?></div>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php');
include($cfg['pathInclude'] . 'html_foot.php'); ?>