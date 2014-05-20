{* article_list.tpl 文章列表 *}
{function cate_list arr=""}
	{foreach $arr as $value}
		<option {if $tplData.search.cate_id == $value.cate_id}selected="selected"{/if} value="{$value.cate_id}">
			{if $value.cate_level > 0}
				{for $_i=1 to $value.cate_level}
					&#160;&#160;&#160;&#160;&#160;&#160;
				{/for}
			{/if}
			{$value.cate_name}
		</option>

		{if $value.cate_childs}
			{cate_list arr=$value.cate_childs}
		{/if}
	{/foreach}
{/function}

{$cfg = [
	title          => $adminMod.article.main.title,
	css            => "admin_list",
	menu_active    => "article",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	colorbox       => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}admin.php?mod=article&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<h5>
		<div>
			<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=article&act_get=form">+ {$lang.href.add}</a>
			&#160;|&#160;
			<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=article" {if !$tplData.search.box}class="tab_active"{/if}>{$lang.href.all}</a>
			<span>({$tplData.articleCount.all})</span>
			&#160;|&#160;
			<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=article&box=draft" {if $tplData.search.box == "draft"}class="tab_active"{/if}>{$lang.href.draft}</a>
			<span>({$tplData.articleCount.draft})</span>
			{if $tplData.articleCount.recycle > 0}
				&#160;|&#160;
				<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=article&box=recycle" {if $tplData.search.box == "recycle"}class="tab_active"{/if}>{$lang.href.recycle}</a>
				<span>({$tplData.articleCount.recycle})</span>
			{/if}
		</div>
		<ul>
			<li class="float_left">
				<form name="article_search" id="article_search" action="{$smarty.const.BG_URL_ADMIN}admin.php" method="get">
					<input type="hidden" name="mod" value="article" />
					<input type="hidden" name="act_get" value="list" />

					<select name="cate_id">
						<option value="">{$lang.option.allCate}</option>
						{cate_list arr=$tplData.cateRows}
						<option {if $tplData.search.cate_id == -1}selected="selected"{/if} value="-1">{$lang.option.unknow}</option>
					</select>

					<select name="year">
						<option value="">{$lang.option.allYear}</option>
						{foreach $tplData.articleYear as $value}
							<option {if $tplData.search.year == $value.article_year}selected="selected"{/if} value="{$value.article_year}">{$value.article_year}</option>
						{/foreach}
					</select>

					<select name="month">
						<option value="">{$lang.option.allMonth}</option>
						{for $_i = 1 to 12}
							{if $_i<10}
								{$_str_month=0|cat:$_i|truncate:2}
							{else}
								{$_str_month=$_i}
							{/if}
							<option {if $tplData.search.month == $_str_month}selected="selected"{/if} value="{$_str_month}">{$_str_month}</option>
						{/for}
					</select>

					<select name="mark_id">
						<option value="">{$lang.option.allMark}</option>
						{foreach $tplData.markRows as $value}
							<option {if $tplData.search.mark_id == $value.mark_id}selected="selected"{/if} value="{$value.mark_id}">{$value.mark_name}</option>
						{/foreach}
					</select>

					<select name="status">
						<option value="">{$lang.option.allStatus}</option>
						{foreach $status.article as $key=>$value}
							<option {if $tplData.search.status == $key}selected="selected"{/if} value="{$key}">{$value}</option>
						{/foreach}
					</select>

					<input type="text" name="key" value="{$tplData.search.key}" />
					<button type="submit">{$lang.btn.filter}</button>
				</form>
			</li>
			<li class="float_right">
				{if $tplData.search.box == "recycle"}
					<form name="empty" id="empty">
						<input type="hidden" name="token_session" value="{$common.token_session}" />
						<input type="hidden" id="act_post" name="act_post" value="empty" />
						<button type="submit">{$lang.btn.empty}</button>
					</form>
				{/if}
			</li>
			<li class="float_clear"></li>
		</ul>
	</h5>

	<form name="article_list" id="article_list" class="tlist">

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
						<div class="float_left">{$lang.label.articleTitle}</div>
					</li>
					<li class="float_right">
						<div class="tshort">{$lang.label.articleCate}</div>
						<div class="tmiddle">{$lang.label.status}</div>
						<div class="tmiddle">{$lang.label.admin}</div>
					</li>
					<li class="float_clear"></li>
				</ol>
			</li>
			<li class="tbody">
				{foreach $tplData.articleRows as $value}
					{if $value.article_box == "normal"}
						{if $value.article_time_pub > $smarty.now}
							{$_css_status = "deadline"}
							{$_str_status = "{$lang.label.deadline} {$value.article_time_pub|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}"}
						{else}
							{$_css_status = $value.article_status}
							{$_str_status = $status.article[$value.article_status]}
						{/if}
					{else}
						{$_css_status = $value.article_box}
						{$_str_status = $lang.label[$value.article_box]}
					{/if}
					<ol id="article_list_{$value.article_id}">
						<li class="float_left">
							<div class="tmini"><input type="checkbox" name="article_id[]" value="{$value.article_id}" id="article_id_{$value.article_id}" group="article_id" class="chk_all validate" /></div>
							<div class="tmini">{$value.article_id}</div>
							<div class="float_left">
								<div class="title {$_css_status}">
									{if $value.article_title}
										{$value.article_title}
									{else}
										{$lang.label.noname}
									{/if}
								</div>
								<div class="double">
									<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=article&act_get=show&article_id={$value.article_id}">{$lang.href.show}</a>
									&#160;|&#160;
									<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=article&act_get=form&article_id={$value.article_id}">{$lang.href.edit}</a>
								</div>
							</div>
						</li>
						<li class="float_right {$_css_status}">
							<div class="tshort">
								{if $value.article_cate_name}
									<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=article&cate_id={$value.article_cate_id}">{$value.article_cate_name}</a>
								{else}
									{$lang.label.unknow}
								{/if}
							</div>
							<div class="tmiddle">
								<div>{$_str_status}</div>
								<div class="double">{$lang.label.add} {$value.article_time|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}</div>
							</div>
							<div class="tmiddle">
								{if $value.article_admin_note}
									<a href="{$smarty.const.BG_URL_ADMIN}admin.php?mod=article&admin_id={$value.article_admin_id}">{$value.article_admin_name} {if $value.article_admin_note}[ {$value.article_admin_note} ]{/if}</a>
								{else}
									{$lang.label.unknow}
								{/if}
							</div>
						</li>
						<li class="float_clear"></li>
					</ol>
				{/foreach}
			</li>
			<li class="tfoot">
				<ol>
					<li class="float_left">
						<div class="tshort"><span id="msg_article_id"></span></div>
					</li>
					<li class="float_left">
						<div>
							<select name="act_post" id="act_post" class="validate">
								<option value="">{$lang.option.batch}</option>
								{if $tplData.search.box == "recycle"}
									<option value="normal">{$lang.option.revert}</option>
									<option value="draft">{$lang.option.draft}</option>
									<option value="del">{$lang.option.del}</option>
								{else if $tplData.search.box == "draft"}
									<option value="normal">{$lang.option.revert}</option>
									<option value="recycle">{$lang.option.recycle}</option>
								{else}
									{foreach $status.article as $key=>$value}
										<option value="{$key}">{$value}</option>
									{/foreach}
									<option value="top">{$lang.option.top}</option>
									<option value="untop">{$lang.option.untop}</option>
									<option value="normal">{$lang.option.revert}</option>
									<option value="draft">{$lang.option.draft}</option>
									<option value="recycle">{$lang.option.recycle}</option>
								{/if}
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
	article_id: {
		length: { min: 1, max: 0 },
		validate: { type: "checkbox" },
		msg: { id: "msg_article_id", too_few: "{$alert.x030202}" }
	},
	act_post: {
		length: { min: 1, "max": 0 },
		validate: { type: "select" },
		msg: { id: "msg_act_post", too_few: "{$alert.x030203}" }
	}
};

var opts_submit_list = {
	ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=article",
	confirm_id: "act_post",
	confirm_val: "del",
	confirm_msg: "{$lang.confirm.del}",
	btn_text: "{$lang.btn.ok}",
	btn_url: "{$cfg.str_url}"
};

$(document).ready(function(){
	$(".chk_all").click(function(){
		var _article_id = $(this).val();
		if ($(this).prop("checked")) {
			$("#article_list_" + _article_id).addClass("div_checked");
		} else {
			$("#article_list_" + _article_id).removeClass("div_checked");
		}
	});
	var obj_validate_list = $("#article_list").baigoValidator(opts_validator_list);
	var obj_submit_list = $("#article_list").baigoSubmit(opts_submit_list);
	$("#go_submit").click(function(){
		if (obj_validate_list.validateSubmit()) {
			obj_submit_list.formSubmit();
		}
	});
	$("#article_list").baigoCheckall();
})
</script>

{include "include/html_foot.tpl" cfg=$cfg}
