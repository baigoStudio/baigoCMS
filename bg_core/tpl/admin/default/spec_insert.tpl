{*spec_form.php 上传界面*}
<div class="modal-header">
    <div class="pull-left">
        <div class="form-group">{$lang.page.spec}</div>
    </div>
    <div class="pull-right form-inline">
        <div class="form-group">
            <div class="input-group input-group-sm">
                <input type="text" name="search_key" id="search_key" class="form-control" placeholder="{$lang.label.key}">
                <span class="input-group-btn">
                    <button class="btn btn-default btn-sm" type="button" id="search_btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="text-nowrap td_mn"> </th>
                <th class="text-nowrap td_mn">{$lang.label.id}</th>
                <th>{$lang.label.specName}</th>
            </tr>
            <tr>
                <td class="text-nowrap td_mn">
                    <input type="radio" name="spec_id" checked value="0" title="{$lang.label.noSpec}">
                </td>
                <td class="text-nowrap td_mn">0</td>
                <td>{$lang.label.noSpec}</td>
            </tr>
            {if isset($tplData.articleRow.specRow.spec_name)}
                <tr>
                    <td class="text-nowrap td_mn">
                        <input type="radio" name="spec_id" checked value="{$tplData.articleRow.specRow.spec_id}" title="{$tplData.articleRow.specRow.spec_name}">
                    </td>
                    <td class="text-nowrap td_mn">{$tplData.articleRow.specRow.spec_id}</td>
                    <td>{$tplData.articleRow.specRow.spec_name}</td>
                </tr>
            {/if}
        </thead>
        <tbody id="spec_list">
        </tbody>
    </table>
</div>

<div class="modal-footer">
    <div class="pull-left">
        <div id="spec_page" class="page_baigo"></div>
    </div>
    <div class="pull-right">
        <div class="form-group">
            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">{$lang.btn.close}</button>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<script type="text/javascript">
function get_page(result, _page, _key) {
    _str_appent_page = "<ul class=\"pagination pagination-sm\">";

        if (result.pageRow.page > 1) {
            _str_appent_page += "<li><a href=\"javascript:reload_spec(1,'" + _key + "');\" title=\"{$lang.href.pageFirst}\">{$lang.href.pageFirst}</a></li>";
        }

        if (result.pageRow.p * 10 > 0) {
            _str_appent_page += "<li><a href=\"javascript:reload_spec(" + (result.pageRow.p * 10) + ",'" + _key + "');\" title=\"{$lang.href.pagePrevList}\">&laquo;</a></li>";
        }

        _str_appent_page += "<li";
        if (result.pageRow.page <= 1) {
            _str_appent_page += " class=\"disabled\"";
        }
        _str_appent_page += ">";
            if (result.pageRow.page <= 1) {
                _str_appent_page += "<span title=\"{$lang.href.pagePrev}\">&lsaquo;</span>";
            } else {
                _str_appent_page += "<a href=\"javascript:reload_spec(" + (result.pageRow.page - 1) + ",'" + _key + "');\" title=\"{$lang.href.pagePrev}\">&lsaquo;</a>";
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
                _str_appent_page += "<a href=\"javascript:reload_spec(" + _iii + ",'" + _key + "');\" title=\"" + _iii + "\">" + _iii + "</a>";
            }
            _str_appent_page += "</li>";
        }

        _str_appent_page += "<li";
        if (result.pageRow.page >= result.pageRow.total) {
            _str_appent_page += " class=\"disabled\"";
        }
        _str_appent_page += ">";
            if (result.pageRow.page >= result.pageRow.total) {
                _str_appent_page += "<span title=\"{$lang.href.pageNext}\">&rsaquo;</span>";
            } else {
                _str_appent_page += "<a href=\"javascript:reload_spec(" + (result.pageRow.page + 1) + ",'" + _key + "');\" title=\"{$lang.href.pageNext}\">&rsaquo;</a>";
            }
        _str_appent_page += "</li>";

        if (_iii < result.pageRow.total) {
            _str_appent_page += "<li><a href=\"javascript:reload_spec(" + _iii + ",'" + _key + "');\" title=\"{$lang.href.pageNextList}\">&raquo;</a></li>";
        }

        if (result.pageRow.page < result.pageRow.total) {
            _str_appent_page += "<li><a href=\"javascript:reload_spec(" + result.pageRow.total + ",'" + _key + "');\" title=\"{$lang.href.pageLast}\">{$lang.href.pageLast}</a></li>";
        }
    _str_appent_page += "</ul>";

    return _str_appent_page;
}


function get_list(_value) {
    _str_appent_spec = "<tr>" +
        "<td class=\"text-nowrap td_mn\"><input type=\"radio\" name=\"spec_id\" value=\"" + _value.spec_id + "\" title=\"" + _value.spec_name + "\"></td>" +
        "<td class=\"text-nowrap td_mn\">" + _value.spec_id + "</td>" +
        "<td>" + _value.spec_name + "</td>" +
    "</div>";

    return _str_appent_spec;
}


function reload_spec(_page, _key) {
    $("#spec_list").empty();
    $("#spec_page").empty();

    $.getJSON("{$smarty.const.BG_URL_ADMIN}ajax.php?mod=spec&act_get=list&page=" + _page + "&key=" + _key, function(result){
        //alert(result.pageRow.page);
        _str_appent_page = get_page(result, _page, _key);

        $("#spec_page").append(_str_appent_page);

        $.each(result.specRows, function(_key, _value){
            //alert(_value.spec_name);
            _str_appent_spec = get_list(_value);

            $("#spec_list").append(_str_appent_spec);
        });

        $("[name='spec_id']").click(function(){
            var _spec_id = $(this).val();
            var _spec_name = $(this).attr("title");
            insertSpec(_spec_name, _spec_id);
        });
    });
}

function insertSpec(name, id) {
    $("#article_spec_name").val(name);
    $("#article_spec_id").val(id);
}

$(document).ready(function(){
    reload_spec(1, "", "", "", "");
    $("#search_btn").click(function(){
        var _key    = $("#search_key").val();
        reload_spec(1, _key);
    });
});
</script>