{* article_list.tpl 文章列表 *}
{function cate_list arr=""}
	{foreach $arr as $value}
		<option {if $tplData.search.cate_id == $value.cate_id}selected{/if} value="{$value.cate_id}">
			{if $value.cate_level > 1}
				{for $_i=2 to $value.cate_level}
					&nbsp;&nbsp;&nbsp;&nbsp;
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
	menu_active    => "article",
	sub_active     => "list",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li>{$adminMod.article.main.title}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<div class="pull-left">
			<ul class="list-inline">
				<li>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=form">
						<span class="glyphicon glyphicon-plus"></span>
						{$lang.href.add}
					</a>
				</li>
				<li>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article" {if !$tplData.search.box}class="text-muted"{/if}>
						{$lang.href.all}
						<span class="badge">{$tplData.articleCount.all}</span>
					</a>
				</li>
				<li>
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&box=draft" {if $tplData.search.box == "draft"}class="text-muted"{/if}>
						{$lang.href.draft}
						<span class="badge">{$tplData.articleCount.draft}</span>
					</a>
				</li>
				{if $tplData.articleCount.recycle > 0}
					<li>
						<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&box=recycle" {if $tplData.search.box == "recycle"}class="text-muted"{/if}>
							{$lang.href.recycle}
							<span class="badge">{$tplData.articleCount.recycle}</span>
						</a>
					</li>
				{/if}
				<li>
					<a href="{$smarty.const.BG_URL_HELP}?lang=zh_CN&mod=help&act=article" target="_blank">
						<span class="glyphicon glyphicon-question-sign"></span>
						{$lang.href.help}
					</a>
				</li>
			</ul>
		</div>
		<div class="pull-right">
			{if $tplData.search.box == "recycle"}
				<form name="article_empty" id="article_empty">
					<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
					<input type="hidden" id="act_empty" name="act_post" value="empty">
					<button type="button" id="go_empty" class="btn btn-info btn-sm">{$lang.btn.empty}</button>
				</form>
			{/if}
		</div>
		<div class="clearfix"></div>
	</div>

	<div class="form-group text-right">
		<form name="article_search" id="article_search" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get" class="form-inline">
			<input type="hidden" name="mod" value="article">
			<input type="hidden" name="act_get" value="list">

			<select name="cate_id" class="form-control input-sm">
				<option value="">{$lang.option.allCate}</option>
				{cate_list arr=$tplData.cateRows}
				<option {if $tplData.search.cate_id == -1}selected{/if} value="-1">{$lang.option.unknow}</option>
			</select>

			<select name="year" class="form-control input-sm">
				<option value="">{$lang.option.allYear}</option>
				{foreach $tplData.articleYear as $value}
					<option {if $tplData.search.year == $value.article_year}selected{/if} value="{$value.article_year}">{$value.article_year}</option>
				{/foreach}
			</select>

			<select name="month" class="form-control input-sm">
				<option value="">{$lang.option.allMonth}</option>
				{for $_i = 1 to 12}
					{if $_i<10}
						{$_str_month=0|cat:$_i|truncate:2}
					{else}
						{$_str_month=$_i}
					{/if}
					<option {if $tplData.search.month == $_str_month}selected{/if} value="{$_str_month}">{$_str_month}</option>
				{/for}
			</select>

			<select name="mark_id" class="form-control input-sm">
				<option value="">{$lang.option.allMark}</option>
				{foreach $tplData.markRows as $value}
					<option {if $tplData.search.mark_id == $value.mark_id}selected{/if} value="{$value.mark_id}">{$value.mark_name}</option>
				{/foreach}
			</select>

			<select name="status" class="form-control input-sm">
				<option value="">{$lang.option.allStatus}</option>
				{foreach $status.article as $key=>$value}
					<option {if $tplData.search.status == $key}selected{/if} value="{$key}">{$value}</option>
				{/foreach}
			</select>

			<input type="text" name="key" value="{$tplData.search.key}" placeholder="{$lang.label.key}" class="form-control input-sm">
			<button type="submit" class="btn btn-default btn-sm">{$lang.btn.filter}</button>
		</form>
	</div>

	<form name="article_list" id="article_list" class="form-inline">
		<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">

		<div class="panel panel-default">
			<div class="table-responsive">
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th class="td_mn">
								<label for="chk_all" class="checkbox-inline">
									<input type="checkbox" name="chk_all" id="chk_all" class="first">
									{$lang.label.all}
								</label>
							</th>
							<th class="td_mn">{$lang.label.id}</th>
							<th>{$lang.label.articleTitle}</th>
							<th class="td_md">{$lang.label.articleCate} / {$lang.label.articleMark}</th>
							<th class="td_md">{$lang.label.status}</th>
							<th class="td_md">{$lang.label.admin}</th>
						</tr>
					</thead>
					<tbody>
						{foreach $tplData.articleRows as $value}
							{if $value.article_box == "normal"}
								{if $value.article_time_pub > $smarty.now}
									{$_css_status = "info"}
									{$_str_status = "{$lang.label.deadline} {$value.article_time_pub|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}"}
								{else}
									{if $value.article_top == 1}
										{$_css_status = "primary"}
										{$_str_status = $lang.label.top}
									{else}
										{if $value.article_status == "pub"}
											{$_css_status = "success"}
										{else if $value.article_status == "wait"}
											{$_css_status = "warning"}
										{else}
											{$_css_status = "default"}
										{/if}
										{$_str_status = $status.article[$value.article_status]}
									{/if}
								{/if}
							{else}
								{$_css_status = "default"}
								{$_str_status = $lang.label[$value.article_box]}
							{/if}
							<tr>
								<td class="td_mn"><input type="checkbox" name="article_id[]" value="{$value.article_id}" id="article_id_{$value.article_id}" group="article_id" class="chk_all validate"></td>
								<td class="td_mn">{$value.article_id}</td>
								<td>
									<div>
										{if $value.article_title}
											{$value.article_title}
										{else}
											{$lang.label.noname}
										{/if}
									</div>
									<div>
										<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=show&article_id={$value.article_id}">{$lang.href.show}</a>
										&nbsp;|&nbsp;
										<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=form&article_id={$value.article_id}">{$lang.href.edit}</a>
									</div>
								</td>
								<td class="td_md">
									<div>
										{if $value.cateRow.cate_name}
											<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&cate_id={$value.article_cate_id}">{$value.cateRow.cate_name}</a>
										{else}
											{$lang.label.unknow}
										{/if}
									</div>
									<div>
										{if isset($value.markRow.mark_name)}
											<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&mark_id={$value.article_mark_id}">{$value.markRow.mark_name}</a>
										{else}
											{$lang.label.none}
										{/if}
									</div>
								</td>
								<td class="td_md">
									<div>
										<span class="label label-{$_css_status}">{$_str_status}</span>
									</div>
									<div>{$value.article_time|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}</div>
								</td>
								<td class="td_md">
									{if isset($value.adminRow.admin_name)}
										<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&admin_id={$value.article_admin_id}">{$value.adminRow.admin_name} {if $value.adminRow.admin_nick}[ {$value.adminRow.admin_nick} ]{/if}</a>
									{else}
										{$lang.label.unknow}
									{/if}
								</td>
							</tr>
						{/foreach}
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"><span id="msg_article_id"></span></td>
							<td colspan="4">
								<select name="act_post" id="act_post" class="validate form-control input-sm">
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
								<button type="button" id="go_submit" class="btn btn-primary btn-sm">{$lang.btn.submit}</button>
								<span id="msg_act_post"></span>
							</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>

	</form>

	<div class="text-right">
		{include "include/page.tpl" cfg=$cfg}
	</div>

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
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	var opts_submit_empty = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=article",
		confirm_id: "act_empty",
		confirm_val: "empty",
		confirm_msg: "{$lang.confirm.empty}",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validate_list = $("#article_list").baigoValidator(opts_validator_list);
		var obj_submit_list = $("#article_list").baigoSubmit(opts_submit_list);
		$("#go_submit").click(function(){
			if (obj_validate_list.validateSubmit()) {
				obj_submit_list.formSubmit();
			}
		});

		var obj_submit_empty = $("#article_empty").baigoSubmit(opts_submit_empty);
		$("#go_empty").click(function(){
			obj_submit_empty.formSubmit();
		});

		$("#article_list").baigoCheckall();
	})
	</script>

{include "include/html_foot.tpl" cfg=$cfg}
