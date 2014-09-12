{* admin_form.tpl 管理员编辑界面 *}
{* 栏目显示函数（递归） *}
{function cate_list arr="" level=""}
	<dl {if $level > 0}class="list_padding"{/if}>
		{foreach $arr as $value}
			<dt>{$value.cate_name}</dt>
			<dd>
				<ul class="list-inline">
					{foreach $lang.allow as $key_s=>$value_s}
						<li>
							<span class="glyphicon glyphicon-{if $tplData.adminRow.admin_allow_cate[$value.cate_id][$key_s] == 1 || $tplData.groupRow.group_allow.article[$key_s]}ok-circle text-success{else}remove-circle text-danger{/if}"></span>
							{$value_s}
						</li>
					{/foreach}
				</ul>
				{if $value.cate_childs}
					{cate_list arr=$value.cate_childs level=$value.cate_level}
				{/if}
			</dd>
		{/foreach}
	</dl>
{/function}

{$cfg = [
	title          => "{$adminMod.admin.main.title} - {$lang.page.show}",
	css            => "admin_form",
	menu_active    => "admin",
	sub_active     => "list"
]}

{include "include/admin_head.tpl" cfg=$cfg}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=admin&act_get=list">{$adminMod.admin.main.title}</a></li>
	<li>{$lang.page.show}</li>

	{include "include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=admin&act_get=list">
			<span class="glyphicon glyphicon-chevron-left"></span>
			{$lang.href.back}
		</a>
	</div>

	<div class="row">
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label static_label">{$lang.label.username}</label>
						<p class="form-control-static static_input">{$tplData.userRow.user_name}</p>
					</div>

					<div class="form-group">
						<label lass="control-label static_label">{$lang.label.mail}</label>
						<p class="form-control-static static_input">{$tplData.userRow.user_mail}</p>
					</div>

					<div class="form-group">
						<label class="control-label static_label">{$lang.label.nick}</label>
						<p class="form-control-static static_input">{$tplData.adminRow.admin_nick}</p>
					</div>

					<div class="form-group">
						<label class="control-label static_label">{$lang.label.cateAllow}</label>
						{cate_list arr=$tplData.cateRows}
					</div>

					<div class="form-group">
						<label class="control-label static_label">{$lang.label.note}<span id="msg_admin_note"></span></label>
						<p class="form-control-static static_input">{$tplData.adminRow.admin_note}</p>
					</div>

					<div class="form-group">
						<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=admin&act_get=form&admin_id={$tplData.adminRow.admin_id}">
							<span class="glyphicon glyphicon-edit"></span>
							{$lang.href.edit}
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="well">
				<div class="form-group">
					<label class="control-label">{$lang.label.id}</label>
					<p class="form-control-static">{$tplData.adminRow.admin_id}</p>
				</div>

				{if $tplData.adminRow.admin_status == "enable"}
					{$_css_status = "success"}
				{else}
					{$_css_status = "warning"}
				{/if}

				<div class="form-group">
					<label class="control-label">{$lang.label.status}</label>
					<p class="form-control-static">
						<span class="label label-{$_css_status}">{$status.admin[$tplData.adminRow.admin_status]}</span>
					</p>
				</div>

				<div class="form-group">
					{if $tplData.adminRow.admin_allow_profile.info == "1"}
						<div>
							<span class="label label-danger">{$lang.label.profileInfo}</span>
						</div>
					{/if}

					{if $tplData.adminRow.admin_allow_profile.pass == "1"}
						<div>
							<span class="label label-danger">{$lang.label.profilePass}</span>
						</div>
					{/if}
				</div>

				<div class="form-group">
					<label class="control-label">{$lang.label.adminGroup}</label>
					<p class="form-control-static">
						{if $tplData.groupRow.group_name}
							{$tplData.groupRow.group_name} | <a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=group&act_get=show&group_id={$tplData.adminRow.admin_group_id}">{$lang.href.show}</a>
						{else}
							{$lang.label.none}
						{/if}
					</p>
				</div>
			</div>
		</div>
	</div>

{include "include/admin_foot.tpl" cfg=$cfg}
{include "include/html_foot.tpl" cfg=$cfg}
