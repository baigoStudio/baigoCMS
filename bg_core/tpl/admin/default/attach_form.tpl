{*attach_form.php 上传界面*}
{$cfg = [
	js_insert => "true"
]}
<div class="modal-header">
	<div class="pull-left">
		<ul class="nav nav-pills nav_baigo">
			<li class="active">
				<a href="#pane_insert" id="btn_insert" data-toggle="tab">{$lang.href.insert}</a>
			</li>
			<li>
				<a href="#pane_upload" id="btn_upload" data-toggle="tab">{$lang.href.upload}</a>
			</li>
			{if $tplData.article_id > 0}
				<li>
					<a href="#pane_article" id="btn_article" data-toggle="tab">{$lang.href.uploadArticle}</a>
				</li>
			{/if}
		</ul>
	</div>
	<form name="attach_search" id="attach_search" class="form-inline pull-right">
		<input type="hidden" name="mod" value="attach">
		<input type="hidden" name="act_get" value="list">
		<div class="form-group">
			<select name="year" id="search_year" class="form-control input-sm hidden-xs">
				<option value="">{$lang.option.allYear}</option>
				{foreach $tplData.yearRows as $key=>$value}
					<option value="{$value.attach_year}">{$value.attach_year}</option>
				{/foreach}
			</select>
		</div>
		<div class="form-group">
			<select name="month" id="search_month" class="form-control input-sm hidden-xs">
				<option value="">{$lang.option.allMonth}</option>
				{for $_i = 1 to 12}
					{if $_i < 10}
						{$_str_month = "0{$_i}"}
					{else}
						{$_str_month = $_i}
					{/if}
					<option value="{$_str_month}">{$_str_month}</option>
				{/for}
			</select>
		</div>
		<div class="form-group">
			<select name="ext" id="search_ext" class="form-control input-sm hidden-xs">
				<option value="">{$lang.option.allExt}</option>
				{foreach $tplData.extRows as $key=>$value}
					<option value="{$value.attach_ext}">{$value.attach_ext}</option>
				{/foreach}
			</select>
		</div>
		<div class="form-group">
			<div class="input-group">
				<input type="text" name="key" id="search_key" placeholder="{$lang.label.key}" class="form-control input-sm">
				<span class="input-group-btn">
					<button class="btn btn-default btn-sm" type="button" id="search_btn">
						<span class="glyphicon glyphicon-search"></span>
					</button>
				</span>
			</div>
		</div>
	</form>
	<div class="clearfix"></div>
</div>

<div class="modal-body">

	<div class="tab-content attach_modal">
		<div class="tab-pane active" id="pane_insert">
			<div id="attach_list" class="row"></div>
		</div>

		<div class="tab-pane" id="pane_upload">
			{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/upload.tpl" cfg=$cfg}
		</div>

		<div class="tab-pane active" id="pane_article">
			<div id="attach_list_article" class="row"></div>
		</div>
	</div>

</div>

<div class="modal-footer">
	<div class="pull-left">
		<div id="attach_page" class="page_baigo"></div>
	</div>
	<div class="pull-right">
		<div class="form-group">
			<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{$lang.btn.close}</button>
		</div>
	</div>
	<div class="clearfix"></div>
</div>

<script type="text/javascript">
var _thumb_type = new Array();
{foreach $type.thumb as $_key=>$_value}
	_thumb_type["{$_key}"] = "{$_value}";
{/foreach}

function get_page(result, _page, _year, _month, _ext, _key, func) {
	_str_appent_page = "<ul class=\"pagination pagination-sm\">";

		if (result.pageRow.page > 1) {
			_str_appent_page += "<li><a href=\"javascript:" + func + "(1,'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"{$lang.href.pageFirst}\">{$lang.href.pageFirst}</a></li>";
		}

		if (result.pageRow.p * 10 > 0) {
			_str_appent_page += "<li><a href=\"javascript:" + func + "(" + (result.pageRow.p * 10) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"{$lang.href.pagePrevList}\">&laquo;</a></li>";
		}

		_str_appent_page += "<li";
		if (result.pageRow.page <= 1) {
			_str_appent_page += " class=\"disabled\"";
		}
		_str_appent_page += ">";
			if (result.pageRow.page <= 1) {
				_str_appent_page += "<span title=\"{$lang.href.pagePrev}\">&lsaquo;</span>";
			} else {
				_str_appent_page += "<a href=\"javascript:" + func + "(" + (result.pageRow.page - 1) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"{$lang.href.pagePrev}\">&lsaquo;</a>";
			}
		_str_appent_page += "</li>";

		for (_iii = result.pageRow.begin; _iii <= result.pageRow.end; _iii++) {
			_str_appent_page += "<li";
				if (_iii == result.pageRow.page) {
					_str_appent_page += " class=\"active\"";
				}
			_str_appent_page += ">";
			if (_iii == result.pageRow.page) {
				_str_appent_page += "<span>" + _iii + "</span>";
			} else {
				_str_appent_page += "<a href=\"javascript:" + func + "(" + _iii + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"" + _iii + "\">" + _iii + "</a>";
			}
			_str_appent_page += "</li>";
		}

		_str_appent_page += "<li";
		if (result.pageRow.page >= result.pageRow.total) {
			_str_appent_page += " class=\"disabled\"";
		}
		_str_appent_page += ">";
			if (result.pageRow.page >= result.pageRow.total) {
				_str_appent_page += "<span title=\"{$lang.href.pageNext}\">&rsaquo;</span>";
			} else {
				_str_appent_page += "<a href=\"javascript:" + func + "(" + (result.pageRow.page + 1) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"{$lang.href.pageNext}\">&rsaquo;</a>";
			}
		_str_appent_page += "</li>";

		if (_iii < result.pageRow.total) {
			_str_appent_page += "<li><a href=\"javascript:" + func + "(" + _iii + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"{$lang.href.pageNextList}\">&raquo;</a></li>";
		}

		if (result.pageRow.page < result.pageRow.total) {
			_str_appent_page += "<li><a href=\"javascript:" + func + "(" + result.pageRow.total + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"{$lang.href.pageLast}\">{$lang.href.pageLast}</a></li>";
		}
	_str_appent_page += "</ul>";

	return _str_appent_page;
}


function get_list(_value) {
	_str_appent_attach = "<div class=\"col-xs-6 col-md-3\">" +
		"<div class=\"thumbnail\">";
			if (_value.attach_type == "image") {
				_str_url = _value.attach_thumb[0].thumb_url;
			} else {
				_str_url = "{$smarty.const.BG_URL_IMAGE}file_" + _value.attach_ext + ".png";
			}
			_str_appent_attach += "<a href=\"" + _value.attach_url + "\" target=\"_blank\">" +
				"<img src=\"" + _str_url + "\" alt=\"" + _value.attach_name + "\" class=\"img-responsive\" alt=\"" + _value.attach_name + "\" title=\"" + _value.attach_name + "\">" +
			"</a>" +

			"<div class=\"caption\">" +
				"<p class=\"attach_overflow\" title=\"" + _value.attach_name + "\">" + _value.attach_name + "</p>" +
				"<div class=\"dropdown\">" +
					"<button type=\"button\" class=\"btn btn-success btn-block btn-sm dropdown-toggle\" data-toggle=\"dropdown\">"+
						"{$lang.href.insertThumb}" +
						"&nbsp;<span class=\"caret\"></span>" +
					"</button>" +
					"<ul class=\"dropdown-menu\" aria-labelledby=\"attach_" + _value.attach_id + "\">" +
						"<li><a href=\"javascript:insertAttach('" + _value.attach_url + "', '" + _value.attach_name + "', '" + _value.attach_id + "', '" + _value.attach_type + "', '" + _value.attach_ext + "');\">{$lang.href.insertOriginal}</a></li>";

						if (_value.attach_type == "image") {
							$.each(_value.attach_thumb, function(thumb_i, field_thumb){
								_str_appent_attach += "<li><a href=\"javascript:insertAttach('" + field_thumb.thumb_url+ "', '" + _value.attach_name + "', '" + _value.attach_id + "', '" + _value.attach_type + "', '" + _value.attach_ext + "');\">{$lang.href.insertThumb}: " + field_thumb.thumb_width + "x" + field_thumb.thumb_height + " " + _thumb_type[field_thumb.thumb_type] + "</a></li>";
							})
						}

						_str_appent_attach += "<li><a href=\"" + _value.attach_url + "\" target=\"_blank\">{$lang.href.browseOriginal}</a></li>" +
					"</ul>" +
				"</div>" +
			"</div>" +
		"</div>" +
	"</div>";

	return _str_appent_attach;
}


function reload_attach(_page, _year, _month, _ext, _key) {
	$("#attach_list").empty();
	$("#attach_page").empty();

	$.getJSON("{$smarty.const.BG_URL_ADMIN}ajax.php?mod=attach&act_get=list&page=" + _page + "&year=" + _year + "&month=" + _month + "&ext=" + _ext + "&key=" + _key, function(result){
		//alert(result.pageRow.page);
		_str_appent_page = get_page(result, _page, _year, _month, _ext, _key, "reload_attach");

		$("#attach_page").append(_str_appent_page);

		$.each(result.attachRows, function(_key, _value){
			//alert(_value.attach_name);
			_str_appent_attach = get_list(_value);

			$("#attach_list").append(_str_appent_attach);
		});
	});
}

function reload_attach_article(_page, _year, _month, _ext, _key) {
	$("#attach_list_article").empty();
	$("#attach_page").empty();

	$.getJSON("{$smarty.const.BG_URL_ADMIN}ajax.php?mod=attach&act_get=article&page=" + _page + "&article_id={$tplData.article_id}", function(result){
		//alert(result.pageRow.page);
		_str_appent_page = get_page(result, _page, _year, _month, _ext, _key, "reload_attach_article");

		$("#attach_page").append(_str_appent_page);

		$.each(result.attachRows, function(_key, _value){
			//alert(_value.attach_name);
			_str_appent_attach = get_list(_value);

			$("#attach_list_article").append(_str_appent_attach);
		});
	});
}

function insertAttach(src, name, id, type, ext) {
	switch (type) {
		case "image":
			_str = "<img src='" + src + "' id='baigo_" + id + "' class='img-responsive'>"
		break;

		default:
			_str = "<img src='{$smarty.const.BG_URL_IMAGE}file_" + ext + ".png'> <a href='" + src + "'>" + name + "</a>"
		break;
	}

	tinyMCE.execCommand("mceInsertContent", false , _str);
}

$(document).ready(function(){
	reload_attach(1, "", "", "", "");
	$("#btn_insert").click(function(){
		reload_attach(1, "", "", "", "");
		$("#attach_search").show();
		$("#attach_page").show();
	});
	$("#btn_article").click(function(){
		reload_attach_article(1, "", "", "", "");
		$("#attach_search").hide();
		$("#attach_page").show();
	});
	$("#btn_upload").click(function(){
		$("#attach_search").hide();
		$("#attach_page").hide();
	});
	$("#search_btn").click(function(){
		var _year   = $("#search_year").val();
		var _month  = $("#search_month").val();
		var _ext    = $("#search_ext").val();
		var _key    = $("#search_key").val();
		reload_attach(1, _year, _month, _ext, _key);
	});
});
</script>