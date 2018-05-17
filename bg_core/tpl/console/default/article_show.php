<?php function custom_list_show($arr_customRows, $article_customs = array()) {
    if (!fn_isEmpty($arr_customRows)) {
        foreach ($arr_customRows as $key=>$value) {
            if (isset($value['custom_childs']) && fn_isEmpty($value['custom_childs'])) { ?>
                <div class="form-group">
                    <label><?php echo $value['custom_name'] ; ?></label>
                    <div class="form-text">
                        <?php if (isset($article_customs['custom_' . $value['custom_id']])) {
                            echo $article_customs['custom_' . $value['custom_id']];
                        } ?>
                    </div>
                </div>
            <?php } else { ?>
                <label><?php echo $value['custom_name'] ; ?></label>
            <?php }

            if (isset($value['custom_childs']) && !fn_isEmpty($value['custom_childs'])) {
                custom_list_show($value['custom_childs'], $article_customs);
            }
        }
    }
}

$cfg = array(
    'title'          => $this->lang['consoleMod']['article']['main']['title'] . ' &raquo; ' . $this->lang['mod']['page']['show'],
    'menu_active'    => 'article',
    'sub_active'     => "list",
    "tooltip"        => 'true',
    'pathInclude'    => BG_PATH_TPLSYS . 'console' . DS . 'default' . DS . 'include' . DS,
);

include($cfg['pathInclude'] . 'function.php');
include($cfg['pathInclude'] . 'console_head.php'); ?>

    <ul class="nav nav-pills mb-3">
        <li class="nav-item">
            <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&a=list" class="nav-link">
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
                        <label><?php echo $this->lang['mod']['label']['title']; ?></label>
                        <div class="form-text">
                            <?php echo $this->tplData['articleRow']['article_title']; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['content']; ?></label>
                        <div>
                            <div class="embed-responsive embed-responsive-4by3">
                                <iframe class="embed-responsive-item" scrolling="auto" src="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&a=show_content&article_id=<?php echo $this->tplData['articleRow']['article_id']; ?>&view=iframe">
                                </iframe>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['excerpt']; ?></label>
                        <p class="bg-content">
                            <?php echo $this->tplData['articleRow']['article_excerpt']; ?>
                        </p>
                    </div>

                    <?php if (isset($this->tplData['articleRow']['article_customs'])) {
                        custom_list_show($this->tplData['customRows'], $this->tplData['articleRow']['article_customs']);
                    } ?>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['tag']; ?></label>
                        <ul class="list-inline">
                            <?php foreach ($this->tplData['tagRows'] as $key=>$value) { ?>
                                <li class="list-inline-item"><?php echo $value['tag_name']; ?></li>
                            <?php } ?>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['link']; ?></label>
                        <div class="form-text">
                            <?php echo $this->tplData['articleRow']['article_link']; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['hits']; ?></label>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <?php echo $this->lang['mod']['label']['hitsDay'], ' ', $this->tplData['articleRow']['article_hits_day']; ?>
                            </li>
                            <li class="list-inline-item">
                                <?php echo $this->lang['mod']['label']['hitsWeek'], ' ', $this->tplData['articleRow']['article_hits_week']; ?>
                            </li>
                            <li class="list-inline-item">
                                <?php echo $this->lang['mod']['label']['hitsMonth'], ' ', $this->tplData['articleRow']['article_hits_month']; ?>
                            </li>
                            <li class="list-inline-item">
                                <?php echo $this->lang['mod']['label']['hitsYear'], ' ', $this->tplData['articleRow']['article_hits_year']; ?>
                            </li>
                            <li class="list-inline-item">
                                <?php echo $this->lang['mod']['label']['hitsAll'], ' ', $this->tplData['articleRow']['article_hits_all']; ?>
                            </li>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['articleUrl']; ?></label>
                        <div class="form-text">
                            <a href="<?php echo $this->tplData['articleRow']['urlRow']['article_url']; ?>" target="_blank"><?php echo $this->tplData['articleRow']['urlRow']['article_url']; ?></a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['articlePath']; ?></label>
                        <div class="form-text">
                            <?php echo $this->tplData['articleRow']['urlRow']['article_pathFull']; ?>
                        </div>
                    </div>

                    <?php if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == 'static') {
                        if ($this->tplData['articleRow']['article_is_gen'] == "yes") {
                            $css_gen = 'secondary';
                        } else {
                            $css_gen = "danger";
                        } ?>
                        <div class="form-group">
                            <label><?php echo $this->lang['mod']['label']['staticFile']; ?></label>
                            <div class="form-text">
                                <span class="badge badge-<?php echo $css_gen; ?>">
                                    <?php if (isset($this->lang['mod']['status'][$this->tplData['articleRow']['article_is_gen']])) {
                                        echo $this->lang['mod']['status'][$this->tplData['articleRow']['article_is_gen']];
                                    } ?>
                                </span>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="card-footer">
                    <a href="<?php echo BG_URL_CONSOLE; ?>index.php?m=article&a=form&article_id=<?php echo $this->tplData['articleRow']['article_id']; ?>">
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
                        <div class="form-text"><?php echo $this->tplData['articleRow']['article_id']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['belongCate']; ?></label>
                        <div class="form-text"><?php echo $this->tplData['cateRow']['cate_name']; ?></div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['attachCate']; ?></label>
                        <table class="bg-table-empty">
                            <tbody>
                                <?php cate_list_checkbox($this->tplData['cateRows'], $this->tplData['articleRow']['cate_ids'], '', false); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['status']; ?></label>
                        <div class="form-text">
                            <?php article_status_process($this->tplData['articleRow'], $this->lang['mod']['status'], $this->lang['mod']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['timeShow']; ?></label>
                        <div class="form-text">
                            <?php echo date("Y-m-d H:i", $this->tplData['articleRow']['article_time_show']); ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['mod']['label']['mark']; ?></label>
                        <div class="form-text">
                            <?php if (isset($this->tplData['markRow']['mark_name'])) {
                                echo $this->tplData['markRow']['mark_name'];
                            } else {
                                echo $this->lang['mod']['label']['none'];
                            } ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label><?php echo $this->lang['common']['label']['spec']; ?></label>
                        <ul class="list-inline">
                            <?php foreach ($this->tplData['specRows'] as $key=>$value) { ?>
                                <li class="list-inline-item"><?php echo $value['spec_name']; ?></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include($cfg['pathInclude'] . 'console_foot.php');
include($cfg['pathInclude'] . 'html_foot.php');