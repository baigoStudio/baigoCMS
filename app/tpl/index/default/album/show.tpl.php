<?php $cfg = array(
    'title'         => $albumRow['album_name'],
    'imageAsync'    => 'true',
    'pathInclude'   => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'index_head' . GK_EXT_TPL); ?>

    <h3><?php echo $albumRow['album_name']; ?></h3>

    <div class="card-columns">
        <?php foreach ($attachRows as $key=>$value) { ?>
            <div class="card">
                <a href="<?php echo $value['attach_url']; ?>" target="_blank">
                    <img src="{:DIR_STATIC}image/loading.gif" data-src="<?php echo $value['thumb_default']; ?>" data-toggle="async" alt="<?php echo $value['attach_name']; ?>" class="card-img-top" id="img_<?php echo $value['attach_id']; ?>">
                </a>
                <div class="card-body">
                    <a href="<?php echo $value['attach_url']; ?>" target="_blank">
                        <?php echo $value['attach_name']; ?>
                    </a>
                    <div><?php echo $value['attach_time_format']['date_time']; ?></div>
                </div>
            </div>
        <?php } ?>
    </div>

    <?php include($cfg['pathInclude'] . 'pagination' . GK_EXT_TPL);

include($cfg['pathInclude'] . 'index_foot' . GK_EXT_TPL);
include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);