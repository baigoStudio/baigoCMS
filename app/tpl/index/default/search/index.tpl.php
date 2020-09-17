<?php  function custom_list($arr_customRows, $arr_search = array()) {
    if (!empty($arr_customRows)) {
        foreach ($arr_customRows as $key=>$value) {
            if (isset($value['custom_childs']) && !empty($value['custom_childs'])) { ?>
                <h5>
                    <span class="badge badge-secondary"><?php echo $value['custom_name'] ; ?></span>
                </h5>
            <?php } else { ?>
                <div class="form-group">
                    <label><?php echo $value['custom_name'] ; ?></label>
                    <input type="text" name="custom_<?php echo $value['custom_id'] ; ?>" value="<?php if (isset($arr_search['custom_' . $value['custom_id']])) { echo $arr_search['custom_' . $value['custom_id']]; } ?>" class="form-control">
                </div>
            <?php }

            if (isset($value['custom_childs']) && !empty($value['custom_childs'])) {
                custom_list($value['custom_childs'], $arr_search);
            }
        }
    }
}

$cfg = array(
    'title'         => '搜索',
    'pathInclude'   => $path_tpl . 'include' . DS,
);

include($cfg['pathInclude'] . 'index_head' . GK_EXT_TPL); ?>

    <form name="search" id="search_form_in" action="<?php echo $url_search; ?>">
        <div class="input-group mb-3">
            <input type="text" name="key" id="search_key_in" value="<?php echo $search['key']; ?>" class="form-control" placeholder="关键词">
            <span class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit">
                    <span class="fas fa-search"></span>
                </button>
            </span>
            <span class="input-group-append">
                <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-toggle="collapse" data-target="#bg-search-more" >
                    <span class="sr-only">Dropdown</span>
                </button>
            </span>
        </div>
        <div class="collapse" id="bg-search-more">
            <?php custom_list($custom_tree, $search); ?>
        </div>
    </form>

    <?php if (!empty($articleRows)) {
        foreach ($articleRows as $key=>$value) { ?>
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
                            <a href="<?php echo $tag_value['tag_url']['url']; ?>"><?php echo $tag_value['tag_name']; ?></a>
                        </li>
                    <?php }
                } ?>
            </ul>
        <?php }

        include($cfg['pathInclude'] . 'pagination' . GK_EXT_TPL);
    }

include($cfg['pathInclude'] . 'index_foot' . GK_EXT_TPL); ?>

	<script type="text/javascript">
	$(document).ready(function(){
        var obj_query_in = $('#search_form_in').baigoQuery();

        $('#search_form_in').submit(function(){
            obj_query_in.formSubmit();
        });
	});
	</script>

<?php include($cfg['pathInclude'] . 'html_foot' . GK_EXT_TPL);
