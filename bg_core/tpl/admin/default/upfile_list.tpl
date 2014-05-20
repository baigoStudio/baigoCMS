{*upfile_list.php 上传管理*}
{$cfg = [
	title          => $adminMod.upfile.main.title,
	css            => "admin_slist",
	menu_active    => "upfile",
	sub_active     => "list",
	baigoCheckall  => "true",
	colorbox       => "true",
	baigoValidator => "true",
	uploadify      => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=upfile&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<div class="tlist">
		<div class="left_form">
			<form name="upfile_form" id="upfile_form">
				<ol>
					<li>
						{include "include/uploadify.tpl" cfg=$cfg}
					</li>
				</ol>
			</form>
		</div>

		<div class="right_list">
			<h5>
				<form name="upfile_search" id="upfile_search" action="{$smarty.const.BG_URL_ADMIN}admin.php" method="get">
					<input type="hidden" name="mod" value="upfile" />
					<input type="hidden" name="act_get" value="list" />

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
					<input type="text" name="key" value="{$tplData.search.key}" />
					<button type="submit">{$lang.btn.filter}</button>
				</form>
			</h5>

			<form name="upfile_list" id="upfile_list">

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
								<div class="tshort">{$lang.label.upfileThumb}</div>
								<div class="float_left">{$lang.label.upfileName}</div>
							</li>
							<li class="float_right">
								<div class="tmiddle">{$lang.label.admin}</div>
							</li>
							<li class="float_clear"></li>
						</ol>
					</li>
					<li class="tbody">
					{foreach $tplData.upfileRows as $value}
						<ol id="upfile_list_{$value.upfile_id}">
							<li class="float_left">
								<div class="tmini"><input type="checkbox" name="upfile_id[]" value="{$value.upfile_id}" id="upfile_id_{$value.upfile_id}" group="upfile_id" class="chk_all validate" /></div>
								<div class="tmini">{$value.upfile_id}</div>
								<div class="tshort">
									<dl class="thumb">
										{if $value.upfile_type == "image"}
											<dd>
												{foreach $value.upfile_row.upfile_thumb as $value_thumb}
													<a href="{$value_thumb.thumb_url}" class="c_box">{$value_thumb.thumb_width}x{$value_thumb.thumb_height} {$type.thumb[$value_thumb.thumb_type]}</a>
												{/foreach}
												<a href="{$value.upfile_row.upfile_url}" target="_blank">{$lang.href.browseOriginal}</a>
											</dd>
										{/if}
										<dt>
											{if $value.upfile_type == "image"}
												<a href="{$value.upfile_row.upfile_url}" class="c_box"><img src="{$value.upfile_row.upfile_thumb.0.thumb_url}" alt="{$value.upfile_name}" /></a>
											{else}
												<a href="{$value.upfile_row.upfile_url}" target="_blank"><img src="{$smarty.const.BG_URL_IMAGE}file_{$value.upfile_ext}.png" alt="{$value.upfile_name}" /></a>
											{/if}
										</dt>
									</dl>
								</div>
								<div class="float_left">
									<div>{$value.upfile_name}</div>
									<div class="double"><a href="{$value.upfile_row.upfile_url}" target="_blank">{$value.upfile_row.upfile_url}</a></div>
									{if $value.upfile_size > 1024}
										{$_num_upfileSize = $value.upfile_size / 1024}
										{$_str_upfileUnit = "KB"}
									{else if $value.upfile_size > 1024 * 1024}
										{$_num_upfileSize = $value.upfile_size / 1024 / 1024}
										{$_str_upfileUnit = "MB"}
									{else if $value.upfile_size > 1024 * 1024 * 1024}
										{$_num_upfileSize = $value.upfile_size / 1024 / 1024 / 1024}
										{$_str_upfileUnit = "GB"}
									{/if}
									<div class="double">{$_num_upfileSize|string_format:"%.2f"} {$_str_upfileUnit}</div>
								</div>
							</li>
							<li class="float_right">
								<div  class="tmiddle">
									{if $value.upfile_admin_note}
										<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=upfile&admin_id={$value.upfile_admin_id}">{$value.upfile_admin_name} {if $value.upfile_admin_note}[ {$value.upfile_admin_note} ]{/if}</a>
									{else}
										{$lang.label.unknow}
									{/if}
								</div>
							</li>
							<li class="float_clear"></li>
						</ol>
					{/foreach}
					<li class="tfoot">
						<ol>
							<li class="float_left">
								<div class="tshort"><span id="msg_upfile_id"></span></div>
							</li>
							<li class="float_left">
								<div>
									<input type="hidden" name="act_post" id="act_post" value="del" />
									<button type="button" id="go_submit">{$lang.btn.del}</button>
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

		</div>

	</div>

{include "include/admin_foot.tpl" cfg=$cfg}

<script type="text/javascript">
var opts_validator_list = {
	upfile_id: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_upfile_id", too_few: "{$alert.x030202}" }
	}
};

var opts_submit_list = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=upfile",
	confirm_id: "act_post",
	confirm_val: "del",
	confirm_msg: "{$lang.confirm.del}",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}"
};

$(document).ready(function(){
	$(".chk_all").click(function(){
		var _upfile_id = $(this).val();
		if ($(this).prop("checked")) {
			$("#upfile_list_" + _upfile_id).addClass("div_checked");
		} else {
			$("#upfile_list_" + _upfile_id).removeClass("div_checked");
		}
	});
	var obj_validate_list = $("#upfile_list").baigoValidator(opts_validator_list);
	var obj_submit_list = $("#upfile_list").baigoSubmit(opts_submit_list);
	$("#go_submit").click(function(){
		if (obj_validate_list.validateSubmit()) {
			obj_submit_list.formSubmit();
		}
	});
	//colorbox
	$(".c_box").colorbox();
	$("#upfile_list").baigoCheckall();
});
</script>

{include "include/html_foot.tpl" cfg=$cfg}