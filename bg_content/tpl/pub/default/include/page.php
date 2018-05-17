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

    <ul class="pagination">
        <?php if ($this->tplData['pageRow']['page'] > 1) { ?>
            <li class="page-item">
                <a href="<?php echo $cfg['str_url']; ?>1<?php echo $cfg['page_ext']; ?>" title="首页" class="page-link">首页</a>
            </li>
        <?php }

        if ($this->tplData['pageRow']['p'] * 10 > 0) { ?>
            <li class="page-item">
                <a href="<?php echo page_process($this->tplData['pageRow']['p'] * 10, $cfg); ?>" title="上十页" class="page-link">...</a>
            </li>
        <?php } ?>

        <li class="page-item<?php if ($this->tplData['pageRow']['page'] <= 1) { ?> disabled<?php } ?>">
            <?php if ($this->tplData['pageRow']['page'] <= 1) { ?>
                <span class="page-link" title="上一页" class="page-link"><span class="oi oi-chevron-left"></span></span>
            <?php } else { ?>
                <a href="<?php echo page_process($this->tplData['pageRow']['page'] - 1, $cfg); ?>" title="上一页" class="page-link"><span class="oi oi-chevron-left"></span></a>
            <?php } ?>
        </li>

        <?php for ($iii = $this->tplData['pageRow']['begin'];  $iii <= $this->tplData['pageRow']['end']; $iii++) { ?>
            <li class="page-item<?php if ($iii == $this->tplData['pageRow']['page']) { ?> active<?php } ?>">
                <?php if ($iii == $this->tplData['pageRow']['page']) { ?>
                    <span class="page-link"><?php echo $iii; ?></span>
                <?php } else { ?>
                    <a href="<?php echo page_process($iii, $cfg); ?>" title="<?php echo $iii; ?>" class="page-link"><?php echo $iii; ?></a>
                <?php } ?>
            </li>
        <?php } ?>

        <li class="page-item<?php if ($this->tplData['pageRow']['page'] >= $this->tplData['pageRow']['total']) { ?> disabled<?php } ?>">
            <?php if ($this->tplData['pageRow']['page'] >= $this->tplData['pageRow']['total']) { ?>
                <span title="下一页" class="page-link"><span class="oi oi-chevron-right"></span></span>
            <?php } else { ?>
                <a href="<?php echo page_process($this->tplData['pageRow']['page'] + 1, $cfg); ?>" title="下一页" class="page-link"><span class="oi oi-chevron-right"></span></a>
            <?php } ?>
        </li>

        <?php if ($this->tplData['pageRow']['end'] < $this->tplData['pageRow']['total']) { ?>
            <li class="page-item">
                <a href="<?php echo page_process($iii, $cfg); ?>" title="下十页" class="page-link">...</a>
            </li>
        <?php }

        if ($this->tplData['pageRow']['page'] < $this->tplData['pageRow']['total']) { ?>
            <li class="page-item">
                <a href="<?php echo page_process($this->tplData['pageRow']['total'], $cfg); ?>" title="末页" class="page-link">末页</a>
            </li>
        <?php }

        if (isset($cfg['is_static'])) { ?>
            <li class="page-item">
                <a href="<?php echo $cfg['str_urlMore'], ($this->tplData['pageRow']['total'] + 1); ?>" title="更多" class="page-link">更多</a>
            </li>
        <?php } ?>
    </ul>
