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
	title          => "{$adminMod.article.main.title} - {$adminMod.article.sub.tag.title}",
	menu_active    => "article",
	sub_active     => "spec",
	baigoCheckall  => "true",
	baigoValidator => "true",
	baigoSubmit    => "true",
	tinymce        => "true",
	upload         => "true",
	str_url        => "{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&{$tplData.query}"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">{$adminMod.article.main.title}</a></li>
	<li>{$adminMod.article.sub.tag.title}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<ul class="list-inline">
			<li>
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=list">
					<span class="glyphicon glyphicon-chevron-left"></span>
					{$lang.href.back}
				</a>
			</li>
			<li>
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=spec&act_get=form&spec_id={$tplData.specRow.spec_id}">
					<span class="glyphicon glyphicon-edit"></span>
					{$lang.href.edit}
				</a>
			</li>
			<li>
				<a href="{$smarty.const.BG_URL_HELP}?lang=zh_CN&mod=help&act=spec#select" target="_blank">
					<span class="glyphicon glyphicon-question-sign"></span>
					{$lang.href.help}
				</a>
			</li>
		</ul>
	</div>

	<div class="form-group">
		<p>{$lang.label.specName} <strong>{$tplData.specRow.spec_name}</strong></p>
	</div>

	<div class="row">

		<div class="col-md-6">

			<div class="well">
				<form name="belong_search" id="belong_search" class="form-inline" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get">
					<input type="hidden" name="mod" value="spec">
					<input type="hidden" name="act_get" value="select">
					<input type="hidden" name="spec_id" value="{$tplData.specRow.spec_id}">
					<div class="pull-left">{$lang.label.belongArticle}</div>
					<div class="pull-right">
						<input type="text" name="key_belong" class="form-control input-sm" value="{$tplData.search.key_belong}" placeholder="{$lang.label.key}">
						<button class="btn btn-default btn-sm" type="submit">{$lang.btn.filter}</button>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>

			<form name="belong_form" id="belong_form" class="form-inline">
				<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">

				<div class="panel panel-default">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th class="td_mn">
										<label for="belong_all" class="checkbox-inline">
											<input type="checkbox" name="belong_all" id="belong_all" class="first">
											{$lang.label.all}
										</label>
									</th>
									<th class="td_mn">{$lang.label.id}</th>
									<th>{$lang.label.articleTitle}</th>
									<th class="td_md">{$lang.label.status}</th>
								</tr>
							</thead>
							<tbody>
								{foreach $tplData.belongRows as $value}
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
										<td class="td_mn"><input type="checkbox" name="article_id[]" value="{$value.article_id}" id="belong_id_{$value.article_id}" group="belong_id" class="belong_all validate"></td>
										<td class="td_mn">{$value.article_id}</td>
										<td>
											{if $value.article_title}
												{$value.article_title}
											{else}
												{$lang.label.noname}
											{/if}
										</td>
										<td class="td_md">
											<div>
												<span class="label label-{$_css_status}">{$_str_status}</span>
											</div>
											<div>{$lang.label.add} {$value.article_time|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}</div>
										</td>
									</tr>
								{/foreach}
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"><span id="msg_belong_id"></span></td>
									<td colspan="2">
										<input type="hidden" name="act_post" value="exc">
										<button type="button" id="go_del" class="btn btn-primary btn-sm">{$lang.btn.belongDel}</button>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>

			</form>
		</div>

		<div class="col-md-6">

			<div class="well">
				<form name="select_search" id="select_search" class="form-inline" action="{$smarty.const.BG_URL_ADMIN}ctl.php" method="get">
					<input type="hidden" name="mod" value="spec">
					<input type="hidden" name="act_get" value="select">
					<input type="hidden" name="spec_id" value="{$tplData.specRow.spec_id}">
					<div class="pull-left">{$lang.label.selectArticle}</div>
					<div class="pull-right">
						<select name="cate_id" class="form-control input-sm">
							<option value="">{$lang.option.allCate}</option>
							{cate_list arr=$tplData.cateRows}
							<option {if $tplData.search.cate_id == -1}selected{/if} value="-1">{$lang.option.unknow}</option>
						</select>
						<select name="status" class="form-control input-sm">
							<option value="">{$lang.option.allStatus}</option>
							{foreach $status.article as $key=>$value}
								<option {if $tplData.search.status == $key}selected{/if} value="{$key}">{$value}</option>
							{/foreach}
						</select>
						<input type="text" name="key_select" class="form-control input-sm" value="{$tplData.search.key_select}" placeholder="{$lang.label.key}">
						<button class="btn btn-default btn-sm" type="submit">{$lang.btn.filter}</button>
					</div>
					<div class="clearfix"></div>
				</form>
			</div>

			<form name="select_form" id="select_form" class="form-inline">
				<input type="hidden" name="token_session" class="token_session" value="{$common.token_session}">
				<input type="hidden" name="spec_id" value="{$tplData.specRow.spec_id}">

				<div class="panel panel-default">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th class="td_mn">
										<label for="select_all" class="checkbox-inline">
											<input type="checkbox" name="select_all" id="select_all" class="first">
											{$lang.label.all}
										</label>
									</th>
									<th class="td_mn">{$lang.label.id}</th>
									<th>{$lang.label.articleTitle}</th>
									<th>{$lang.label.articleSpec}</th>
									<th class="td_md">{$lang.label.status}</th>
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
										<td class="td_mn"><input type="checkbox" name="article_id[]" value="{$value.article_id}" id="select_id_{$value.article_id}" group="select_id" class="select_all validate"></td>
										<td class="td_mn">{$value.article_id}</td>
										<td>
											{if $value.article_title}
												{$value.article_title}
											{else}
												{$lang.label.noname}
											{/if}
										</td>
										<td>
											{$value.specRow.spec_name}
										</td>
										<td class="td_md">
											<div>
												<span class="label label-{$_css_status}">{$_str_status}</span>
											</div>
											<div>{$lang.label.add} {$value.article_time|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}</div>
										</td>
									</tr>
								{/foreach}
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2"><span id="msg_select_id"></span></td>
									<td colspan="3">
										<input type="hidden" name="act_post" value="to">
										<button type="button" id="go_add" class="btn btn-primary btn-sm">{$lang.btn.belongAdd}</button>
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

		</div>
	</div>

{include "include/admin_foot.tpl" cfg=$cfg}


	<script type="text/javascript">
	var opts_validator_select = {
		select_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_select_id", too_few: "{$alert.x030202}" }
		}
	};

	var opts_validator_belong = {
		belong_id: {
			length: { min: 1, max: 0 },
			validate: { type: "checkbox" },
			msg: { id: "msg_belong_id", too_few: "{$alert.x030202}" }
		}
	};

	var opts_submit_select = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=spec",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	var opts_submit_belong = {
		ajax_url: "{$smarty.const.BG_URL_ADMIN}ajax.php?mod=spec",
		btn_text: "{$lang.btn.ok}",
		btn_close: "{$lang.btn.close}",
		btn_url: "{$cfg.str_url}"
	};

	$(document).ready(function(){
		var obj_validate_select   = $("#select_form").baigoValidator(opts_validator_select);
		var obj_submit_select     = $("#select_form").baigoSubmit(opts_submit_select);
		$("#go_add").click(function(){
			if (obj_validate_select.validateSubmit()) {
				obj_submit_select.formSubmit();
			}
		});
		var obj_validate_belong   = $("#belong_form").baigoValidator(opts_validator_belong);
		var obj_submit_belong     = $("#belong_form").baigoSubmit(opts_submit_belong);
		$("#go_del").click(function(){
			if (obj_validate_belong.validateSubmit()) {
				obj_submit_belong.formSubmit();
			}
		});
		$("#belong_form").baigoCheckall();
		$("#select_form").baigoCheckall();
	});
	</script>

{include "include/html_foot.tpl" cfg=$cfg}

