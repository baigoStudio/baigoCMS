{* upfile_listInsert.php 上传管理(插入状态) *}
{$cfg = [
	title      => $lang.page.admin,
	css        => "admin_insert",
	str_url    => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=upfile&{$tplData.query}"
]}

{include "include/iframe_head.tpl" cfg=$cfg}

	{include "include/upfile_insert.tpl"}

	<h6>
		<form name="upfile_search" id="upfile_search" action="{$smarty.const.BG_URL_ADMIN}admin.php" method="get">
			<input type="hidden" name="mod" value="upfile" />
			<input type="hidden" name="act_get" value="list" />
			<input type="hidden" name="view" value="insert" />

			<select name="year">
				<option value="">{$lang.option.allYear}</option>
				{foreach $tplData.pathRows as $value}
					<option {if $tplData.search.year == $value.upfile_year}selected="selected"{/if} value="{$value.upfile_year}">{$value.upfile_year}</option>
				{/foreach}
			</select>
			<select name="month">
				<option value="">{$lang.option.allMonth}</option>
				{for $_i = 1 to 12}
					{if $_i < 10}
						{$_str_month = "0{$_i}"}
					{else}
						{$_str_month = $_i}
					{/if}
					<option {if $tplData.search.month == $_str_month}selected="selected"{/if} value="{$_str_month}">{$_str_month}</option>
				{/for}
			</select>

			<select name="ext">
				<option value="">{$lang.option.allExt}</option>
				{foreach $tplData.extRows as $value}
					<option {if $tplData.search.ext == $value.upfile_ext}selected="selected"{/if} value="{$value.upfile_ext}">{$value.upfile_ext}</option>
				{/foreach}
			</select>
			<button type="submit">{$lang.btn.filter}</button>
		</form>
	</h6>

	<form>
		<ol>
			{foreach $tplData.upfileRows as $value}
				<li class="list">
					<dl class="thumb">
						<dd>
							{if $value.upfile_type == "image"}
								<a href="javascript:insertHtml('{$value.upfile_row.upfile_url}', '{$value.upfile_name}', '{$value.upfile_id}', '{$value.upfile_type}');">{$lang.href.insertOriginal}</a>
								{foreach $value.upfile_row.upfile_thumb as $value_thumb}
									<a href="javascript:insertHtml('{$value_thumb.thumb_url}', '{$value.upfile_name}', '{$value.upfile_id}', '{$value.upfile_type}', '{$value.upfile_ext}');">{$value_thumb.thumb_width}x{$value_thumb.thumb_height} {$type.thumb[$value_thumb.thumb_type]}</a>
								{/foreach}
								<a href="{$value.upfile_row.upfile_url}" target="_blank">{$lang.href.browseOriginal}</a>
							{else}
								<a href="javascript:insertHtml('{$value.upfile_row.upfile_url}', '{$value.upfile_name}', '{$value.upfile_id}', '{$value.upfile_type}', '{$value.upfile_ext}');">{$lang.href.insert}</a>
							{/if}
						</dd>
						<dt>
							{if $value.upfile_type == "image"}
								{$_str_src = $value.upfile_row.upfile_thumb.0.thumb_url}
							{else}
								{$_str_src = "{$smarty.const.BG_URL_IMAGE}file_{$value.upfile_ext}.png"}
							{/if}
							<img src="{$_str_src}" alt="{$value.upfile_name}" />
						</dt>
					</dl>
				</li>
			{/foreach}
			<li class="float_clear"></li>
		</ol>

		<h6>
			<ul>
				<li class="float_right">
					{include "include/page.tpl" cfg=$cfg}
				</li>
				<li class="float_clear"></li>
			</ul>
		</h6>
	</form>

{include "include/iframe_foot.tpl" cfg=$cfg}

<script type="text/javascript">
function insertHtml(src, name, id, type, ext) {
	switch (type) {
		case "image":
			_str = "<img src='" + src + "' id='baigo_" + id + "' />"
		break;

		default:
			_str = "<img src='{$smarty.const.BG_URL_IMAGE}file_" + ext + ".png' /> <a href='" + src + "'>" + name + "</a>"
		break;
	}
	parent.{$tplData.search.target}.insertHtml(_str);
	alert( "{$alert.y070404}" );
}

$(document).ready(function(){
	$("#ok").click(function(){
		parent.$.fn.colorbox.close();
	});
});
</script>

{include "include/html_foot.tpl" cfg=$cfg}