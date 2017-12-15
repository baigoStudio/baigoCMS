<?php  function custom_list($arr_customRows, $customs = array()) {
    if (!fn_isEmpty($arr_customRows)) {
        foreach ($arr_customRows as $key=>$value) {
            if (isset($value['custom_childs']) && !fn_isEmpty($value['custom_childs'])) { ?>
                <h4>
                    <span class="label label-default"><?php echo $value['custom_name'] ; ?></span>
                </h4>
            <?php } else { ?>
                <div class="form-group">
                    <label class="control-label"><?php echo $value['custom_name'] ; ?></label>
                    <input type="text" name="custom_<?php echo $value['custom_id'] ; ?>" value="<?php if (isset($customs['custom_' . $value['custom_id']])) { echo $customs['custom_' . $value['custom_id']]; } ?>" class="search_customs_in form-control" placeholder="<?php echo $value['custom_name'] ; ?>">
                </div>
            <?php }

            if (isset($value['custom_childs']) && !fn_isEmpty($value['custom_childs'])) {
                custom_list($value['custom_childs'], $customs);
            }
        }
    }
}

$cfg = array(
    'title'      => '搜索',
    'str_url'    => $this->tplData['urlRow']['search_url'] . 'key-' . $this->tplData['search']['key'] . '/customs-' . $this->tplData['search']['customs'] . '/cate-' . $this->tplData['search']['cate_id'] . '/' . $this->tplData['urlRow']['page_attach'],
    'page_ext'   => ''
);

include('include' . DS . 'pub_head.php'); ?>

    <ol class="breadcrumb">
        <li><a href="<?php echo BG_URL_ROOT; ?>">首页</a></li>
        <li><a href="<?php echo $this->tplData['urlRow']['search_url']; ?>">搜索</a></li>
    </ol>

    <form name="search" id="search_form_in">
        <div class="form-group">
            <label class="control-label">关键词</label>
            <input type="text" name="key" id="search_key_in" value="<?php echo $this->tplData['search']['key']; ?>" class="form-control" placeholder="关键词">
        </div>

        <?php custom_list($this->tplData['customRows'], $this->tplData['customs']); ?>

        <button type="button" id="search_btn_in" class="btn btn-primary">搜索</button>
    </form>

    <?php foreach ($this->tplData['articleRows'] as $key=>$value) { ?>
        <h3><a href="<?php echo $value['urlRow']['article_url']; ?>" target="_blank"><?php echo $value['article_title']; ?></a></h3>
        <div><?php echo date(BG_SITE_DATE, $value['article_time_show']); ?></div>
        <hr>
        <ul class="list-inline">
            <li>
                <span class="glyphicon glyphicon-tags"></span>
                Tags:
            </li>
            <?php if (isset($value['tagRows'])) {
                foreach ($value['tagRows'] as $tag_key=>$tag_value) { ?>
                    <li>
                        <a href="<?php echo $tag_value['urlRow']['tag_url']; ?>"><?php echo $tag_value['tag_name']; ?></a>
                    </li>
                <?php }
            } ?>
        </ul>
    <?php }

    if ($this->tplData['search']['key'] || $this->tplData['search']['customs']) {
        include('include' . DS . 'page.php');
    }

include('include' . DS . 'pub_foot.php'); ?>
	<script type="text/javascript">
    function search_go_in() {
        var _search_key_in        = $("#search_key_in").val();
        var _search_customs_in    = $(".search_customs_in").serialize();
        window.location.href = "<?php echo BG_URL_ROOT; ?>search/key-" + encodeURIComponent(_search_key_in) + "/customs-" + encodeURIComponent(Base64.encode(_search_customs_in)) + "/";
	}

	$(document).ready(function(){
		$("#search_btn_in").click(function(){
			search_go_in();
		});

		$("#search_form_in").submit(function(){
			search_go_in();
			return false;
		});
	});
	</script>
<?php include('include' . DS . 'html_foot.php'); ?>