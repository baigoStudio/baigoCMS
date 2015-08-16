{* article_form.tpl 文章编辑 *}
{function custom_list arr=""}
	{foreach $arr as $key=>$value}
		{if $value.custom_childs}
			<label class="control-label static_label">{$value.custom_name}</label>
		{else}
			<div class="form-group">
				<label class="control-label static_label">{$value.custom_name}</label>
				<p class="form-control-static static_input">
					{if isset($tplData.articleRow.article_customs["custom_{$value.custom_id}"])}
						{$tplData.articleRow.article_customs["custom_{$value.custom_id}"]}
					{/if}
				</p>
			</div>
		{/if}

		{if $value.custom_childs}
			{custom_list arr=$value.custom_childs}
		{/if}
	{/foreach}
{/function}

{function cate_list arr="" level=""}
	<ul class="list-unstyled{if $level > 0} list_padding{/if}">
		{foreach $arr as $key=>$value}
			<li>
				<div class="checkbox_baigo">
					<label>
						<span class="glyphicon glyphicon-{if $value.cate_id|in_array:$tplData.articleRow.cate_ids}ok-circle text-success{else}remove-circle text-danger{/if}"></span>
						{$value.cate_name}
					</label>
				</div>
				{if $value.cate_childs}
					{cate_list arr=$value.cate_childs level=$value.cate_level}
				{/if}
			</li>
		{/foreach}
	</ul>
{/function}

{$cfg = [
	title          => "{$adminMod.article.main.title} - {$lang.page.show}",
	menu_active    => "article",
	sub_active     => "list"
]}

{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/admin_head.tpl" cfg=$cfg}

	<li><a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">{$adminMod.article.main.title}</a></li>
	<li>{$lang.page.show}</li>

	{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/admin_left.tpl" cfg=$cfg}

	<div class="form-group">
		<ul class="nav nav-pills nav_baigo">
			<li>
				<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=list">
					<span class="glyphicon glyphicon-chevron-left"></span>
					{$lang.href.back}
				</a>
			</li>
		</ul>
	</div>

	<div class="row">
		<div class="col-md-9">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label static_label">{$lang.label.articleTitle}</label>
						<p class="form-control-static static_input">
							{$tplData.articleRow.article_title}
						</p>
					</div>

					<div class="form-group">
						<label class="control-label static_label">{$lang.label.articleContent}</label>
						<p class="form-control-static static_input content_baigo">
							{$tplData.articleRow.article_content}
						</p>
					</div>

					<div class="form-group">
						<label class="control-label static_label">{$lang.label.articleExcerpt}</label>
						<p class="form-control-static static_input">
							{$tplData.articleRow.article_excerpt}
						</p>
					</div>

					{custom_list arr=$tplData.customRows}

					<div class="form-group">
						<label class="control-label static_label">{$lang.label.articleTag}</label>
						<p class="form-control-static">
							<ul class="list-inline">
								{foreach $tplData.tagRows as $key=>$value}
									<li>{$value.tag_name}</li>
								{/foreach}
							</ul>
						</p>
					</div>

					<div class="form-group">
						<label class="control-label static_label">{$lang.label.articleLink}</label>
						<p class="form-control-static">
							{$tplData.articleRow.article_link}
						</p>
					</div>

					<div class="form-group">
						<label class="control-label static_label">{$lang.label.hits}</label>
						<ul class="list-inline">
							<li>{$lang.label.hitsDay} {$tplData.articleRow.article_hits_day}</li>
							<li>{$lang.label.hitsWeek} {$tplData.articleRow.article_hits_week}</li>
							<li>{$lang.label.hitsMonth} {$tplData.articleRow.article_hits_month}</li>
							<li>{$lang.label.hitsYear} {$tplData.articleRow.article_hits_year}</li>
							<li>{$lang.label.hitsAll} {$tplData.articleRow.article_hits_all}</li>
						</ul>
					</div>

					<div class="form-group">
						<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=form&article_id={$tplData.articleRow.article_id}">
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
					<label class="control-label static_label">{$lang.label.id}</label>
					<p class="form-control-static">{$tplData.articleRow.article_id}</p>
				</div>

				<div class="form-group">
					<label class="control-label static_label">{$lang.label.articleCate}</label>
					<p class="form-control-static">{$tplData.cateRow.cate_name}</p>
				</div>

				<div class="form-group">
					<label class="control-label static_label">{$lang.label.articleBelong}</label>
					{cate_list arr=$tplData.cateRows}
				</div>

				{if $tplData.articleRow.article_box == "normal"}
					{if $tplData.articleRow.article_time_pub > $smarty.now}
						{$_css_status = "info"}
						{$_str_status = "{$lang.label.deadline} {$tplData.articleRow.article_time_pub|date_format:"{$smarty.const.BG_SITE_DATE} {$smarty.const.BG_SITE_TIMESHORT}"}"}
					{else}
						{if $tplData.articleRow.article_top == 1}
							{$_css_status = "primary"}
							{$_str_status = $lang.label.top}
						{else}
							{if $tplData.articleRow.article_status == "pub"}
								{$_css_status = "success"}
							{else if $tplData.articleRow.article_status == "wait"}
								{$_css_status = "warning"}
							{else}
								{$_css_status = "default"}
							{/if}
							{$_str_status = $status.article[$tplData.articleRow.article_status]}
						{/if}
					{/if}
				{else}
					{$_css_status = "default"}
					{$_str_status = $lang.label[$tplData.articleRow.article_box]}
				{/if}

				<div class="form-group">
					<label class="control-label static_label">{$lang.label.status}</label>
					<p class="form-control-static label_baigo">
						<span class="label label-{$_css_status}">{$_str_status}</span>
					</p>
				</div>

				<div class="form-group">
					<label class="control-label static_label">{$lang.label.time}</label>
					<p class="form-control-static">
						{$tplData.articleRow.article_time|date_format:"%Y-%m-%d %H:%M"}
					</p>
				</div>

				<div class="form-group">
					<label class="control-label static_label">{$lang.label.articleMark}</label>
					<p class="form-control-static">
						{if isset($tplData.markRow.mark_name)}
							{$tplData.markRow.mark_name}
						{else}
							{$lang.label.none}
						{/if}
					</p>
				</div>

				<div class="form-group">
					<a href="{$smarty.const.BG_URL_ADMIN}ctl.php?mod=article&act_get=form&article_id={$tplData.articleRow.article_id}">
						<span class="glyphicon glyphicon-edit"></span>
						{$lang.href.edit}
					</a>
				</div>
			</div>
		</div>
	</div>


{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/admin_foot.tpl" cfg=$cfg}
{include "{$smarty.const.BG_PATH_SYSTPL_ADMIN}default/include/html_foot.tpl" cfg=$cfg}

