<?php $cfg = array(
    'pathInclude'   => $path_tpl . 'include' . DS,
    'prism'         => 'true',
);

include($cfg['pathInclude'] . 'html_head' . GK_EXT_TPL); ?>

    <div class="container-fluid">
        <?php if (!empty($listRows)) { ?>
            <ul>
                <?php foreach ($listRows as $_key=>$_value) { ?>
                    <li>
                        <a href="<?php echo $_value['url']; ?>" target="_blank"><?php echo $_value['content']; ?></a>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </div>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);