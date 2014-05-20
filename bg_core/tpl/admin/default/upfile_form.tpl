{*upfile_form.php 上传界面*}
{$cfg = [
	title          => $lang.page.admin,
	css            => "admin_insert",
	uploadify      => "true"
]}

{include "include/iframe_head.tpl" cfg=$cfg}

	{include "include/upfile_insert.tpl"}

	<form>
		<div class="form">
			{include "include/uploadify.tpl" cfg=$cfg}
		</div>
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
}

$(document).ready(function(){
	$("#ok").click(function(){
		parent.$.fn.colorbox.close();
	});
});
</script>

{include "include/html_foot.tpl" cfg=$cfg}