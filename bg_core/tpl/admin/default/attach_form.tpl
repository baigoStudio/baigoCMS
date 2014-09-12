{*attach_form.php 上传界面*}
<div class="modal-header">
	<ul class="nav nav-pills pull-left">
		<li class="active">
			<a href="#pane_insert" data-toggle="tab">{$lang.href.insert}</a>
		</li>
		<li>
			<a href="#pane_upload" data-toggle="tab">{$lang.href.upload}</a>
		</li>
	</ul>
	<form name="attach_search" id="attach_search" class="form-inline pull-right hidden-xs">
		<input type="hidden" name="mod" value="attach">
		<input type="hidden" name="act_get" value="list">
		<select name="year" id="search_year" class="form-control input-sm">
			<option value="">{$lang.option.allYear}</option>
			{foreach $tplData.yearRows as $value}
				<option {if $tplData.search.year == $value.attach_year}selected{/if} value="{$value.attach_year}">{$value.attach_year}</option>
			{/foreach}
		</select>
		<select name="month" id="search_month" class="form-control input-sm">
			<option value="">{$lang.option.allMonth}</option>
			{for $_i = 1 to 12}
				{if $_i < 10}
					{$_str_month = "0{$_i}"}
				{else}
					{$_str_month = $_i}
				{/if}
				<option {if $tplData.search.month == $_str_month}selected{/if} value="{$_str_month}">{$_str_month}</option>
			{/for}
		</select>
		<select name="ext" id="search_ext" class="form-control input-sm">
			<option value="">{$lang.option.allExt}</option>
			{foreach $tplData.extRows as $value}
				<option {if $tplData.search.ext == $value.attach_ext}selected{/if} value="{$value.attach_ext}">{$value.attach_ext}</option>
			{/foreach}
		</select>
		<button class="btn btn-default btn-sm" type="button" id="search_btn">{$lang.btn.filter}</button>
	</form>
	<div class="clearfix"></div>
</div>

<div class="modal-body">

	<div class="tab-content attach_modal">
		<div class="tab-pane active" id="pane_insert">
			<div id="attach_list" class="row"></div>
			<div id="attach_page" class="text-right"></div>
		</div>
		<div class="tab-pane" id="pane_upload">
			{include "include/upload.tpl" cfg=$cfg}
		</div>
	</div>

</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal">{$lang.btn.close}</button>
</div>

<script type="text/javascript">
function reload_attach(_page, _year, _month, _ext) {
	var _thumb_type = Array();
	{foreach $type.thumb as $_key=>$_value}
		_thumb_type["{$_key}"] = "{$_value}";
	{/foreach}

	$("#attach_list").empty();
	$("#attach_page").empty();

	$.getJSON("{$smarty.const.BG_URL_USER}ajax.php?mod=attach&act_get=list&page=" + _page + "&year=" + _year + "&month=" + _month + "&ext=" + _ext, function(result){
		//alert(result.pageRow.page);
		_str_appent_page = "<ul class=\"pagination pagination-sm\">";

			if (result.pageRow.page > 1) {
				_str_appent_page += "<li><a href=\"javascript:reload_attach(1, '" + _year + "','" + _month + "','" + _ext + "');\" title=\"{$lang.href.pageFirst}\">{$lang.href.pageFirst}</a></li>";
			}

			if (result.pageRow.p * 10 > 0) {
				_str_appent_page += "<li><a href=\"javascript:reload_attach(" + (result.pageRow.p * 10) + ", '" + _year + "','" + _month + "','" + _ext + "');\" title=\"{$lang.href.pagePrevList}\">{$lang.href.pagePrevList}</a></li>";
			}

			_str_appent_page += "<li";
			if (result.pageRow.page <= 1) {
				_str_appent_page += " class=\"disabled\"";
			}
			_str_appent_page += ">";
				if (result.pageRow.page <= 1) {
					_str_appent_page += "<span title=\"{$lang.href.pagePrev}\">&laquo;</span>";
				} else {
					_str_appent_page += "<a href=\"javascript:reload_attach(" + (result.pageRow.page - 1) + ", '" + _year + "','" + _month + "','" + _ext + "');\" title=\"{$lang.href.pagePrev}\">&laquo;</a>";
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
					_str_appent_page += "<a href=\"javascript:reload_attach(" + _iii + ", '" + _year + "','" + _month + "','" + _ext + "');\" title=\"" + _iii + "\">" + _iii + "</a>";
				}
				_str_appent_page += "</li>";
			}

			_str_appent_page += "<li";
			if (result.pageRow.page >= result.pageRow.total) {
				_str_appent_page += " class=\"disabled\"";
			}
			_str_appent_page += ">";
				if (result.pageRow.page >= result.pageRow.total) {
					_str_appent_page += "<span title=\"{$lang.href.pageNext}\">&raquo;</span>";
				} else {
					_str_appent_page += "<a href=\"javascript:reload_attach(" + (result.pageRow.page + 1) + ", '" + _year + "','" + _month + "','" + _ext + "');\" title=\"{$lang.href.pageNext}\">&raquo;</a>";
				}
			_str_appent_page += "</li>";

			if (_iii < result.pageRow.total) {
				_str_appent_page += "<li><a href=\"javascript:reload_attach(" + _iii + ", '" + _year + "','" + _month + "','" + _ext + "');\" title=\"{$lang.href.pageNextList}\">{$lang.href.pageNextList}</a></li>";
			}

			if (result.pageRow.page < result.pageRow.total) {
				_str_appent_page += "<li><a href=\"javascript:reload_attach(" + result.pageRow.total + ", '" + _year + "','" + _month + "','" + _ext + "');\" title=\"{$lang.href.pageLast}\">{$lang.href.pageLast}</a></li>";
			}
		_str_appent_page += "</ul>";

		$("#attach_page").append(_str_appent_page);

		$.each(result.attachRows, function(i_attach, field_attach){
			//alert(field_attach.attach_name);
			_str_appent_attach = "<div class=\"col-xs-6 col-md-3\">" +
					"<div class=\"dropdown\">" +
						"<a class=\"btn btn-default thumbnail dropdown-toggle attach_item\" id=\"attach_" + field_attach.attach_id + "\" data-toggle=\"dropdown\">";
							if (field_attach.attach_type == "image") {
								_str_url = field_attach.attach_thumb[0].thumb_url;
							} else {
								_str_url = "{$smarty.const.BG_URL_IMAGE}file_" + field_attach.attach_ext + ".png";
							}
							_str_appent_attach += "<img src=\"" + _str_url + "\" alt=\"" + field_attach.attach_name + "\">" +
							"<span class=\"caret\"></span>" +
						"</a>" +
						"<ul class=\"dropdown-menu\" aria-labelledby=\"attach_" + field_attach.attach_id + "\">" +
							"<li><a href=\"javascript:insertAttach('" + field_attach.attach_url + "', '" + field_attach.attach_name + "', '" + field_attach.attach_id + "', '" + field_attach.attach_type + "', '" + field_attach.attach_ext + "');\">{$lang.href.insertOriginal}</a></li>";

							if (field_attach.attach_type == "image") {
								$.each(field_attach.attach_thumb, function(thumb_i, field_thumb){
									_str_appent_attach += "<li><a href=\"javascript:insertAttach('" + field_thumb.thumb_url+ "', '" + field_attach.attach_name + "', '" + field_attach.attach_id + "', '" + field_attach.attach_type + "', '" + field_attach.attach_ext + "');\">{$lang.href.insertThumb}: " + field_thumb.thumb_width + "x" + field_thumb.thumb_height + " " + _thumb_type[field_thumb.thumb_type] + "</a></li>";
								})
							}

							_str_appent_attach += "<li><a href=\"" + field_attach.attach_url + "\" target=\"_blank\">{$lang.href.show}: " + field_attach.attach_name + "</a></li>" +
						"</ul>" +
					"</div>" +
				"</div>";

			$("#attach_list").append(_str_appent_attach);
		});
	});
}

function insertAttach(src, name, id, type, ext) {
	switch (type) {
		case "image":
			_str = "<img src='" + src + "' id='baigo_" + id + "'>"
		break;

		default:
			_str = "<img src='{$smarty.const.BG_URL_IMAGE}file_" + ext + ".png'> <a href='" + src + "'>" + name + "</a>"
		break;
	}
	//{$tplData.target}.insertHtml(_str);

	tinyMCE.execCommand("mceInsertContent", false , _str);
}

$(document).ready(function(){
	reload_attach(1, "", "", "");
	$("#btn_insert").click(function(){
		reload_attach(1, "", "", "");
	});
	$("#search_btn").click(function(){
		var _year   = $("#search_year").val();
		var _month  = $("#search_month").val();
		var _ext    = $("#search_ext").val();
		reload_attach(1, _year, _month, _ext);
	});
});
</script>