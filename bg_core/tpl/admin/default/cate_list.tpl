{*cate_list.php 栏目列表*}
{* 栏目显示函数（递归） *}
{function cate_list arr=""}
	{foreach $arr as $value}
		<ol id="cate_list_{$value.cate_id}">
			<li class="float_left">
				<div class="tmini"><input type="checkbox" name="cate_id[]" value="{$value.cate_id}" id="cate_id_{$value.cate_id}" group="cate_id" class="chk_all validate" /></div>
				<div class="tmini">{$value.cate_id}</div>
				<div class="float_left">
					<div class="title {$value.cate_status}">
						{if $value.cate_level > 0}
							{for $_i=1 to $value.cate_level}
								—
							{/for}
						{/if}
						{if $value.cate_name}
							{$value.cate_name}
						{else}
							{$lang.label.noname}
						{/if}
					</div>
					<div class="double">
						<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=article&cate_id={$value.cate_id}">{$lang.href.articleList}</a>
						&#160;|&#160;
						<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=cate&act_get=form&cate_id={$value.cate_id}">{$lang.href.edit}</a>
						&#160;|&#160;
						<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=cate&act_get=order&cate_id={$value.cate_id}&view=iframe" class="c_iframe">{$lang.href.order}</a>
					</div>
				</div>
			</li>
			<li class="float_right {$value.cate_status}">
				<div class="tlong">
					{if $value.cate_alias}
						{$value.cate_alias}
					{else}
						{$value.cate_id}
					{/if}
				</div>
				<div class="tshort">{$type.cate[$value.cate_type]}</div>
				<div class="tshort">{$status.cate[$value.cate_status]}</div>
			</li>
			<li class="float_clear"></li>
		</ol>

		{if $value.cate_childs}
			{cate_list arr=$value.cate_childs}
		{/if}
	{/foreach}
{/function}

{$cfg = [
	title          => $adminMod.cate.main.title,
	css            => "admin_list",
	menu_active    => "cate",
	sub_active     => "list",
	baigoCheckall  => "true",
	validate       => "true",
	baigoSubmit    => "true",
	baigoValidator => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=cate&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<h5>
		<div><a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=cate&act_get=form">+ {$lang.href.add}</a></div>
		<form name="cate_search" id="cate_search" action="{$smarty.const.BG_URL_ADMIN}admin.php" method="get">
			<input type="hidden" name="mod" value="cate" />
			<input type="hidden" name="act_get" value="list" />
			<select name="type">
				<option value="">{$lang.option.allType}</option>
				{foreach $type.cate as $key=>$value}
					<option {if $tplData.search.type == $key}selected="selected"{/if} value="{$key}">{$value}</option>
				{/foreach}
			</select>
			<select name="status">
				<option value="">{$lang.option.allStatus}</option>
				{foreach $status.cate as $key=>$value}
					<option {if $tplData.search.status == $key}selected="selected"{/if} value="{$key}">{$value}</option>
				{/foreach}
			</select>
			<input type="test" name="key" value="{$tplData.search.key}" />
			<button type="submit">{$lang.btn.filter}</button>
		</form>
	</h5>

	<form name="cate_list" id="cate_list" class="tlist">

		<input type="hidden" name="token_session" value="{$common.token_session}" />

		<ul>
			<li class="thead">
				<ol>
					<li class="float_left">
						<div class="tmini">
							<input type="checkbox" name="chk_all" id="chk_all" class="first" />
							{$lang.label.all}
						</div>
						<div class="tmini">{$lang.label.id}</div>
						<div class="float_left">{$lang.label.cateName}</div>
					</li>
					<li class="float_right">
						<div class="tlong">{$lang.label.cateAlias}</div>
						<div class="tshort">{$lang.label.cateType}</div>
						<div class="tshort">{$lang.label.status}</div>
					</li>
					<li class="float_clear"></li>
				</ol>
			</li>
			<li class="tbody">
				{cate_list arr=$tplData.cateRows}
			</li>
			<li class="tfoot">
				<ol>
					<li class="float_left">
						<div class="tshort"><span id="msg_cate_id"></span></div>
					<li class="float_left">
						<div>
							<select name="act_post" id="act_post" class="validate">
								<option value="">{$lang.option.batch}</option>
								{foreach $status.cate as $key=>$value}
									<option value="{$key}">{$value}</option>
								{/foreach}
								<option value="del">{$lang.option.del}</option>
							</select>
							<button type="button" id="go_submit">{$lang.btn.submit}</button>
							<span id="msg_act_post"></span>
						</div>
					</li>
					<li class="float_clear"></li>
				</ol>
			</li>
		</ul>
	</form>

	<h6>
		<ul>
			<li class="float_right">
				{include "include/page.tpl" cfg=$cfg}
			</li>
			<li class="float_clear"></li>
		</ul>
	</h6>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_list = {
	cate_id: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_cate_id", too_few: "{$alert.x030202}" }
	},
	act_post: {
		length: { min: 1, max: 0 },
		validate: { type: "select" },
		msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
	}
};

var opts_submit_list = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=cate",
	confirm_id: "act_post",
	confirm_val: "del",
	confirm_msg: "{$lang.confirm.del}",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}"
};

$(".c_iframe").colorbox({ iframe: true, width: "640px", height: "480px" });

$(document).ready(function(){
	$(".chk_all").click(function(){
		var _cate_id = $(this).val();
		if ($(this).prop("checked")) {
			$("#cate_list_" + _cate_id).addClass("div_checked");
		} else {
			$("#cate_list_" + _cate_id).removeClass("div_checked");
		}
	});
	var obj_validate_list  = $("#cate_list").baigoValidator(opts_validator_list);
	var obj_submit_list    = $("#cate_list").baigoSubmit(opts_submit_list);
	$("#go_submit").click(function(){
		if (obj_validate_list.validateSubmit()) {
			obj_submit_list.formSubmit();
		}
	});
	$("#cate_list").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}

