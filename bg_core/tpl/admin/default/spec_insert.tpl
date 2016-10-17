<div class="modal-header">
    <div class="pull-left">
        <div class="form-group">{$lang.page.spec}</div>
    </div>
    <div class="pull-right form-inline">
        <div class="form-group">
            <div class="input-group input-group-sm">
                <input type="text" name="search_key" id="search_key" class="form-control" placeholder="{$lang.label.key}" value="{$tplData.search.key}">
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
                <th class="text-nowrap td_sm">{$lang.label.status}</th>
            </tr>
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
var _str_appent_page;
var _spec_status = new Array();
{foreach $status.spec as $key=>$value}
    _spec_status["{$key}"] = "{$value}";
{/foreach}

var _specIds = {$tplData.specIds};
var _str_appent_spec;
var _spec_list_html;

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
                _str_appent_page += "<span title=\"{$lang.href.pagePrev}\">&laquo;</span>";
            } else {
                _str_appent_page += "<a href=\"javascript:reload_spec(" + (result.pageRow.page - 1) + ",'" + _key + "');\" title=\"{$lang.href.pagePrev}\">&laquo;</a>";
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
                _str_appent_page += "<span title=\"{$lang.href.pageNext}\">&raquo;</span>";
            } else {
                _str_appent_page += "<a href=\"javascript:reload_spec(" + (result.pageRow.page + 1) + ",'" + _key + "');\" title=\"{$lang.href.pageNext}\">&raquo;</a>";
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
    var _css_status;
    var _checked;

    if (_value.spec_status == "show") {
        _css_status = "success";
    } else {
        _css_status = "default";
    }

    if ($.inArray(_value.spec_id, _specIds) >= 0) {
        _checked = "checked";
    } else {
        _checked = "";
    }

    _str_appent_spec = "<tr>" +
        "<td class=\"text-nowrap td_mn\">" +
            "<input type=\"checkbox\" id=\"spec_id_" + _value.spec_id + "\" name=\"spec_id\" " + _checked + " value=\"" + _value.spec_id + "\" title=\"" + _value.spec_name + "\">" +
        "</td>" +
        "<td class=\"text-nowrap td_mn\">" + _value.spec_id + "</td>" +
        "<td>" + _value.spec_name + "</td>" +
        "<td class=\"text-nowrap td_sm label_baigo\">" +
            "<span class=\"label label-" + _css_status + "\">" +
                _spec_status[_value.spec_status] +
            "</span>" +
        "</td>" +
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
            _str_appent_spec = get_list(_value);

            $("#spec_list").append(_str_appent_spec);
        });

        $("[name='spec_id']").click(function(){
            var _spec_id    = $(this).val();
            var _spec_name  = $(this).attr("title");
            var _is_checked = $(this).prop("checked");
            insertSpec(_spec_name, _spec_id, _is_checked);
        });
    });
}

function insertSpec(spec_name, spec_id, is_checked) {
    if (is_checked) {
        _spec_list_html = "<div class=\"checkbox\" id=\"spec_checkbox_" + spec_id + "\">" +
            "<label for=\"{$tplData.search.target}_spec_ids_" + spec_id + "\">" +
                "<input type=\"checkbox\" id=\"{$tplData.search.target}_spec_ids_" + spec_id + "\" checked name=\"{$tplData.search.target}_spec_ids[]\" value=\"" + spec_id + "\">" +
                spec_name +
            "</label>" +
        "</div>";

        $("#spec_check_list").append(_spec_list_html);
    } else {
        $("#spec_checkbox_" + spec_id).remove();
    }
}

$(document).ready(function(){
    reload_spec(1, "{$tplData.search.key}", "", "", "");
    $("#search_btn").click(function(){
        var _key = $("#search_key").val();
        reload_spec(1, _key);
    });
});
</script>