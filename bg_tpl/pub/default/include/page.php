<?php function page_process($thisPage, $cfg) {
    $_str_echo = '';
    if (BG_MODULE_GEN > 0 && BG_VISIT_TYPE == 'static') {
        if ($thisPage <= BG_VISIT_PAGE) {
            $_str_echo .= $cfg['str_url'] . $thisPage . $cfg['page_ext'];
        } else {
            $_str_echo .= $cfg['str_urlMore'] . $thisPage;
        }
    } else {
        $_str_echo .= $cfg['str_url'] . $thisPage;
    }
    return $_str_echo;
} ?>

    <ul class="pagination pagination-sm">
        <?php if ($this->tplData['pageRow']['page'] > 1) { ?>
            <li>
                <a href="<?php echo $cfg['str_url']; ?>1<?php echo $cfg['page_ext']; ?>" title="首页">首页</a>
            </li>
        <?php }

        if ($this->tplData['pageRow']['p'] * 10 > 0) { ?>
            <li>
                <a href="<?php echo page_process($this->tplData['pageRow']['p'] * 10, $cfg); ?>" title="上十页">...</a>
            </li>
        <?php } ?>

        <li class="<?php if ($this->tplData['pageRow']['page'] <= 1) { ?>disabled<?php } ?>">
            <?php if ($this->tplData['pageRow']['page'] <= 1) { ?>
                <span title="上一页"><span class="glyphicon glyphicon-menu-left"></span></span>
            <?php } else { ?>
                <a href="<?php echo page_process($this->tplData['pageRow']['page'] - 1, $cfg); ?>" title="上一页"><span class="glyphicon glyphicon-menu-left"></span></a>
            <?php } ?>
        </li>

        <?php for ($iii = $this->tplData['pageRow']['begin'];  $iii <= $this->tplData['pageRow']['end']; $iii++) { ?>
            <li class="<?php if ($iii == $this->tplData['pageRow']['page']) { ?>active<?php } ?>">
                <?php if ($iii == $this->tplData['pageRow']['page']) { ?>
                    <span><?php echo $iii; ?></span>
                <?php } else { ?>
                    <a href="<?php echo page_process($iii, $cfg); ?>" title="<?php echo $iii; ?>"><?php echo $iii; ?></a>
                <?php } ?>
            </li>
        <?php } ?>

        <li class="<?php if ($this->tplData['pageRow']['page'] >= $this->tplData['pageRow']['total']) { ?>disabled<?php } ?>">
            <?php if ($this->tplData['pageRow']['page'] >= $this->tplData['pageRow']['total']) { ?>
                <span title="下一页"><span class="glyphicon glyphicon-menu-right"></span></span>
            <?php } else { ?>
                <a href="<?php echo page_process($this->tplData['pageRow']['page'] + 1, $cfg); ?>" title="下一页"><span class="glyphicon glyphicon-menu-right"></span></a>
            <?php } ?>
        </li>

        <?php if ($this->tplData['pageRow']['end'] < $this->tplData['pageRow']['total']) { ?>
            <li>
                <a href="<?php echo page_process($iii, $cfg); ?>" title="下十页">...</a>
            </li>
        <?php }

        if ($this->tplData['pageRow']['page'] < $this->tplData['pageRow']['total']) { ?>
            <li>
                <a href="<?php echo page_process($this->tplData['pageRow']['total'], $cfg); ?>" title="末页">末页</a>
            </li>
        <?php }

        if (isset($cfg['is_static'])) { ?>
            <li>
                <a href="<?php echo $cfg['str_urlMore'], ($this->tplData['pageRow']['total'] + 1); ?>" title="更多">更多</a>
            </li>
        <?php } ?>
    </ul>
