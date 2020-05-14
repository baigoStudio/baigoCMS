<?php $cfg = array(
    'title'             => $specRow['spec_name'],
    'pathInclude'       => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'index_head' . GK_EXT_TPL); ?>

    <h3><?php echo $specRow['spec_name']; ?></h3>

    <?php foreach ($articleRows as $key=>$value) { ?>
        <h4><a href="<?php echo $value['article_url']; ?>" target="_blank"><?php echo $value['article_title']; ?></a></h4>
        <div><?php echo $value['article_time_show_format']['date_time']; ?></div>
        <hr>
        <ul class="list-inline">
            <li class="list-inline-item">
                <span class="fas fa-tags"></span>
                Tags:
            </li>
            <?php if (isset($value['tagRows'])) {
                foreach ($value['tagRows'] as $tag_key=>$tag_value) { ?>
                    <li class="list-inline-item">
                        <a href="<?php echo $tag_value['tag_url']['url']; ?>" target="_blank"><?php echo $tag_value['tag_name']; ?></a>
                    </li>
                <?php }
            } ?>
        </ul>
    <?php }

    include($cfg['pathInclude'] . 'pagination' . GK_EXT_TPL);

include($cfg['pathInclude'] . 'index_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);