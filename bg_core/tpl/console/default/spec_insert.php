<div class="modal-header clearfix">
    <div class="pull-left">
        <div class="form-group"><?php echo $this->lang['common']['label']['spec']; ?></div>
    </div>
    <div class="pull-right form-inline">
        <div class="form-group">
            <div class="input-group input-group-sm">
                <input type="text" name="search_key" id="search_key" class="form-control" placeholder="<?php echo $this->lang['mod']['label']['key']; ?>" value="<?php echo $this->tplData['search']['key']; ?>">
                <span class="input-group-btn">
                    <button class="btn btn-default btn-sm" type="button" id="search_btn">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th class="text-nowrap bg-td-xs"> </th>
                <th class="text-nowrap bg-td-xs"><?php echo $this->lang['mod']['label']['id']; ?></th>
                <th><?php echo $this->lang['mod']['label']['specName']; ?></th>
                <th class="text-nowrap bg-td-sm"><?php echo $this->lang['mod']['label']['status']; ?></th>
            </tr>
        </thead>
        <tbody id="spec_list">
        </tbody>
    </table>
</div>

<div class="modal-footer clearfix">
    <div class="pull-left">
        <div id="spec_page"></div>
    </div>
    <div class="pull-right">
        <div class="form-group">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang['common']['btn']['close']; ?></button>
        </div>
    </div>
</div>

<script type="text/javascript">
var _spec_status = <?php echo json_encode($this->lang['mod']['status']); ?>;

var _specIds = <?php echo $this->tplData['specIds']; ?>;

function get_page(result, _page, _key) {
    var _str_page = "";

    _str_page = "<ul class=\"pagination pagination-sm bg-pagination\">";
        if (result.pageRow.page > 1) {
            _str_page += "<li><a href=\"javascript:reload_spec(1,'" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pageFirst']; ?>\"><?php echo $this->lang['common']['href']['pageFirst']; ?></a></li>";
        }

        if (result.pageRow.p * 10 > 0) {
            _str_page += "<li><a href=\"javascript:reload_spec(" + (result.pageRow.p * 10) + ",'" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pagePrevList']; ?>\">...</a></li>";
        }

        _str_page += "<li";
        if (result.pageRow.page <= 1) {
            _str_page += " class=\"disabled\"";
        }
        _str_page += ">";
            if (result.pageRow.page <= 1) {
                _str_page += "<span title=\"<?php echo $this->lang['common']['href']['pagePrev']; ?>\"><span class=\"glyphicon glyphicon-menu-left\"></span></span>";
            } else {
                _str_page += "<a href=\"javascript:reload_spec(" + (result.pageRow.page - 1) + ",'" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pagePrev']; ?>\"><span class=\"glyphicon glyphicon-menu-left\"></span></a>";
            }
        _str_page += "</li>";

        for (_iii = result.pageRow.begin; _iii <= result.pageRow.end; _iii++) {
            _str_page += "<li";
                if (_iii == result.pageRow.page) {
                    _str_page += " class=\"active\"";
                }
            _str_page += ">";
            if (_iii == result.pageRow.page) {
                _str_page += "<span>" + _iii + "</span>";
            } else {
                _str_page += "<a href=\"javascript:reload_spec(" + _iii + ",'" + _key + "');\" title=\"" + _iii + "\">" + _iii + "</a>";
            }
            _str_page += "</li>";
        }

        _str_page += "<li";
        if (result.pageRow.page >= result.pageRow.total) {
            _str_page += " class=\"disabled\"";
        }
        _str_page += ">";
            if (result.pageRow.page >= result.pageRow.total) {
                _str_page += "<span title=\"<?php echo $this->lang['common']['href']['pageNext']; ?>\"><span class=\"glyphicon glyphicon-menu-right\"></span></span>";
            } else {
                _str_page += "<a href=\"javascript:reload_spec(" + (result.pageRow.page + 1) + ",'" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pageNext']; ?>\"><span class=\"glyphicon glyphicon-menu-right\"></span></a>";
            }
        _str_page += "</li>";

        if (_iii < result.pageRow.total) {
            _str_page += "<li><a href=\"javascript:reload_spec(" + _iii + ",'" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pageNextList']; ?>\">...</a></li>";
        }

        if (result.pageRow.page < result.pageRow.total) {
            _str_page += "<li><a href=\"javascript:reload_spec(" + result.pageRow.total + ",'" + _key + "');\" title=\"<?php echo $this->lang['common']['href']['pageLast']; ?>\"><?php echo $this->lang['common']['href']['pageLast']; ?></a></li>";
        }
    _str_page += "</ul>";

    return _str_page;
}

function get_list(_value) {
    var _css_status = "";
    var _checked    = "";

    if (_value.spec_status == 'show') {
        _css_status = 'success';
    } else {
        _css_status = 'default';
    }

    if ($.inArray(_value.spec_id, _specIds) >= 0) {
        _checked = "checked";
    } else {
        _checked = "";
    }

    var _str_spec = "<tr>" +
        "<td class=\"text-nowrap bg-td-xs\">" +
            "<input type=\"checkbox\" id=\"spec_id_" + _value.spec_id + "\" name=\"spec_id\" " + _checked + " value=\"" + _value.spec_id + "\" title=\"" + _value.spec_name + "\">" +
        "</td>" +
        "<td class=\"text-nowrap bg-td-xs\">" + _value.spec_id + "</td>" +
        "<td>" + _value.spec_name + "</td>" +
        "<td class=\"text-nowrap bg-td-sm\">" +
            "<span class=\"label label-" + _css_status + " bg-label\">" +
                _spec_status[_value.spec_status] +
            "</span>" +
        "</td>" +
    "</tr>";

    return _str_spec;
}

function reload_spec(_page, _key) {
    var _str_appent_spec = "";
    var _str_appent_page = "";

    $.getJSON("<?php echo BG_URL_CONSOLE; ?>request.php?mod=spec&act=list&page=" + _page + "&key=" + _key, function(result){
        //alert(result.pageRow.page);
        _str_appent_page = get_page(result, _page, _key);

        $("#spec_page").html(_str_appent_page);

        $.each(result.specRows, function(_key, _value){
            _str_appent_spec += get_list(_value);
        });

        $("#spec_list").html(_str_appent_spec);

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
        var _spec_list_html = "<div class=\"checkbox\" id=\"spec_checkbox_" + spec_id + "\">" +
            "<label for=\"<?php echo $this->tplData['search']['target']; ?>_spec_ids_" + spec_id + "\">" +
                "<input type=\"checkbox\" id=\"<?php echo $this->tplData['search']['target']; ?>_spec_ids_" + spec_id + "\" checked name=\"<?php echo $this->tplData['search']['target']; ?>_spec_ids[]\" value=\"" + spec_id + "\">" +
                spec_name +
            "</label>" +
        "</div>";

        $("#spec_check_list").append(_spec_list_html);
    } else {
        $("#spec_checkbox_" + spec_id).remove();
    }
}

$(document).ready(function(){
    reload_spec(1, "<?php echo $this->tplData['search']['key']; ?>", "", "", "");
    $("#search_btn").click(function(){
        var _key = $("#search_key").val();
        reload_spec(1, _key);
    });
});
</script>