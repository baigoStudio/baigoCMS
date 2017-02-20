    <?php $cfg = array(
        "pathInclude"   => BG_PATH_TPLSYS . "console/default/include/",
        "js_insert"     => "true",
    ); ?>
    <div class="modal-header clearfix">
        <div class="pull-left">
            <div class="form-group">
                <ul class="nav nav-pills bg-nav-pills">
                    <li class="active">
                        <a href="#pane_insert" id="btn_insert" data-toggle="tab"><?php echo $this->lang["href"]["insert"]; ?></a>
                    </li>
                    <li>
                        <a href="#pane_upload" id="btn_upload" data-toggle="tab"><?php echo $this->lang["href"]["upload"]; ?></a>
                    </li>
                    <?php if ($this->tplData["articleRow"]["article_id"] > 0) { ?>
                        <li>
                            <a href="#pane_article" id="btn_article" data-toggle="tab"><?php echo $this->lang["href"]["uploadArticle"]; ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
        <div class="pull-right form-inline">
            <div class="form-group">
                <select name="year" id="search_year" class="form-control input-sm hidden-xs">
                    <option value=""><?php echo $this->lang["option"]["allYear"]; ?></option>
                    <?php foreach ($this->tplData["yearRows"] as $key=>$value) { ?>
                        <option value="<?php echo $value["attach_year"]; ?>"><?php echo $value["attach_year"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <select name="month" id="search_month" class="form-control input-sm hidden-xs">
                    <option value=""><?php echo $this->lang["option"]["allMonth"]; ?></option>
                    <?php for ($iii = 1 ; $iii <= 12; $iii++) {
                        if ($iii < 10) {
                            $str_month = "0" . $iii;
                        } else {
                            $str_month = $iii;
                        } ?>
                        <option value="<?php echo $str_month; ?>"><?php echo $str_month; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <select name="ext" id="search_ext" class="form-control input-sm hidden-xs">
                    <option value=""><?php echo $this->lang["option"]["allExt"]; ?></option>
                    <?php foreach ($this->tplData["extRows"] as $key=>$value) { ?>
                        <option value="<?php echo $value["attach_ext"]; ?>"><?php echo $value["attach_ext"]; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <div class="input-group input-group-sm">
                    <input type="text" name="search_key" id="search_key" class="form-control" placeholder="<?php echo $this->lang["label"]["key"]; ?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default btn-sm" type="button" id="search_btn">
                            <span class="glyphicon glyphicon-search"></span>
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal-body">
    
        <div class="tab-content">
            <div class="tab-pane active" id="pane_insert">
                <div id="attach_list" class="row"></div>
            </div>
    
            <div class="tab-pane" id="pane_upload">
                <?php include($cfg["pathInclude"] . "upload.php"); ?>
            </div>
    
            <div class="tab-pane active" id="pane_article">
                <div id="attach_list_article" class="row"></div>
            </div>
        </div>
    
    </div>
    
    <div class="modal-footer clearfix">
        <div class="pull-left">
            <div id="attach_page"></div>
        </div>
        <div class="pull-right">
            <div class="form-group">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang["btn"]["close"]; ?></button>
            </div>
        </div>
    </div>
    
    <script type="text/javascript">
    var _thumb_type = new Array();
    <?php foreach ($this->type["thumb"] as $key=>$value) { ?>
        _thumb_type["<?php echo $key; ?>"] = "<?php echo $value; ?>";
    <?php } ?>
    
    var _str_appent_page;
    var _str_appent_attach;
    
    function get_page(result, _page, _year, _month, _ext, _key, func) {
        _str_appent_page = "<ul class=\"pagination pagination-sm bg-pagination\">";
    
            if (result.pageRow.page > 1) {
                _str_appent_page += "<li><a href=\"javascript:" + func + "(1,'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang["href"]["pageFirst"]; ?>\"><?php echo $this->lang["href"]["pageFirst"]; ?></a></li>";
            }
    
            if (result.pageRow.p * 10 > 0) {
                _str_appent_page += "<li><a href=\"javascript:" + func + "(" + (result.pageRow.p * 10) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang["href"]["pagePrevList"]; ?>\">...</a></li>";
            }
    
            _str_appent_page += "<li";
            if (result.pageRow.page <= 1) {
                _str_appent_page += " class=\"disabled\"";
            }
            _str_appent_page += ">";
                if (result.pageRow.page <= 1) {
                    _str_appent_page += "<span title=\"<?php echo $this->lang["href"]["pagePrev"]; ?>\"><span class=\"glyphicon glyphicon-menu-left\"></span></span>";
                } else {
                    _str_appent_page += "<a href=\"javascript:" + func + "(" + (result.pageRow.page - 1) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang["href"]["pagePrev"]; ?>\"><span class=\"glyphicon glyphicon-menu-left\"></span></a>";
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
                    _str_appent_page += "<a href=\"javascript:" + func + "(" + _iii + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"" + _iii + "\">" + _iii + "</a>";
                }
                _str_appent_page += "</li>";
            }
    
            _str_appent_page += "<li";
            if (result.pageRow.page >= result.pageRow.total) {
                _str_appent_page += " class=\"disabled\"";
            }
            _str_appent_page += ">";
                if (result.pageRow.page >= result.pageRow.total) {
                    _str_appent_page += "<span title=\"<?php echo $this->lang["href"]["pageNext"]; ?>\"><span class=\"glyphicon glyphicon-menu-right\"></span></span>";
                } else {
                    _str_appent_page += "<a href=\"javascript:" + func + "(" + (result.pageRow.page + 1) + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang["href"]["pageNext"]; ?>\"><span class=\"glyphicon glyphicon-menu-right\"></span></a>";
                }
            _str_appent_page += "</li>";
    
            if (_iii < result.pageRow.total) {
                _str_appent_page += "<li><a href=\"javascript:" + func + "(" + _iii + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang["href"]["pageNextList"]; ?>\">...</a></li>";
            }
    
            if (result.pageRow.page < result.pageRow.total) {
                _str_appent_page += "<li><a href=\"javascript:" + func + "(" + result.pageRow.total + ",'" + _year + "','" + _month + "','" + _ext + "','" + _key + "');\" title=\"<?php echo $this->lang["href"]["pageLast"]; ?>\"><?php echo $this->lang["href"]["pageLast"]; ?></a></li>";
            }
        _str_appent_page += "</ul>";
    
        return _str_appent_page;
    }
    
    function get_list(_value) {
        _str_appent_attach = "<div class=\"col-xs-6 col-md-3\">" +
            "<div class=\"thumbnail\">";
                if (_value.attach_type == "image") {
                    _str_url = _value.attach_thumb[0].thumb_url;
                } else {
                    _str_url = "<?php echo BG_URL_STATIC; ?>image/file_" + _value.attach_ext + ".png";
                }
                _str_appent_attach += "<a href=\"" + _value.attach_url + "\" target=\"_blank\">" +
                    "<img src=\"" + _str_url + "\" alt=\"" + _value.attach_name + "\" class=\"img-responsive\" alt=\"" + _value.attach_name + "\" title=\"" + _value.attach_name + "\">" +
                "</a>" +
    
                "<div class=\"caption\">" +
                    "<p class=\"bg-overflow text-nowrap\" title=\"" + _value.attach_name + "\">" + _value.attach_name + "</p>" +
                    "<div class=\"dropdown\">" +
                        "<button type=\"button\" class=\"btn btn-success btn-block btn-sm dropdown-toggle\" data-toggle=\"dropdown\">"+
                            "<?php echo $this->lang["href"]["insertThumb"]; ?>" +
                            "&nbsp;<span class=\"caret\"></span>" +
                        "</button>" +
                        "<ul class=\"dropdown-menu\">" +
                            "<li><a href=\"javascript:insertAttach('" + _value.attach_url + "', '" + _value.attach_name + "', '" + _value.attach_id + "', '" + _value.attach_type + "', '" + _value.attach_ext + "');\"><?php echo $this->lang["href"]["insertOriginal"]; ?></a></li>";
    
                            if (_value.attach_type == "image") {
                                $.each(_value.attach_thumb, function(thumb_i, field_thumb){
                                    _str_appent_attach += "<li><a href=\"javascript:insertAttach('" + field_thumb.thumb_url+ "', '" + _value.attach_name + "', '" + _value.attach_id + "', '" + _value.attach_type + "', '" + _value.attach_ext + "');\"><?php echo $this->lang["href"]["insertThumb"]; ?>: " + field_thumb.thumb_width + "x" + field_thumb.thumb_height + " " + _thumb_type[field_thumb.thumb_type] + "</a></li>";
                                });
                            }
    
                            _str_appent_attach += "<li><a href=\"" + _value.attach_url + "\" target=\"_blank\"><?php echo $this->lang["href"]["browseOriginal"]; ?></a></li>" +
                        "</ul>" +
                    "</div>" +
                "</div>" +
            "</div>" +
        "</div>";
    
        return _str_appent_attach;
    }
    
    
    function reload_attach(_page, _year, _month, _ext, _key) {
        $("#attach_list").empty();
        $("#attach_page").empty();
    
        $.getJSON("<?php echo BG_URL_CONSOLE; ?>request.php?mod=attach&act=list&page=" + _page + "&year=" + _year + "&month=" + _month + "&ext=" + _ext + "&key=" + _key, function(result){
            //alert(result.pageRow"]["page);
            _str_appent_page = get_page(result, _page, _year, _month, _ext, _key, "reload_attach");
    
            $("#attach_page").append(_str_appent_page);
    
            $.each(result.attachRows, function(_key, _value){
                //alert(_value["attach_name);
                _str_appent_attach = get_list(_value);
    
                $("#attach_list").append(_str_appent_attach);
            });
        });
    }
    
    function reload_attach_article(_page, _year, _month, _ext, _key) {
        $("#attach_list_article").empty();
        $("#attach_page").empty();
    
        $.getJSON("<?php echo BG_URL_CONSOLE; ?>request.php?mod=attach&act=article&page=" + _page + "&article_id=<?php echo $this->tplData["articleRow"]["article_id"]; ?>", function(result){
            //alert(result.pageRow"]["page);
            _str_appent_page = get_page(result, _page, _year, _month, _ext, _key, "reload_attach_article");
    
            $("#attach_page").append(_str_appent_page);
    
            $.each(result.attachRows, function(_key, _value){
                //alert(_value["attach_name);
                _str_appent_attach = get_list(_value);
    
                $("#attach_list_article").append(_str_appent_attach);
            });
        });
    }
    
    function insertAttach(src, name, id, type, ext) {
        switch (type) {
            case "image":
                _str = "<img src='" + src + "' id='baigo_" + id + "' class='img-responsive'>"
            break;
    
            default:
                _str = "<img src='<?php echo BG_URL_STATIC; ?>image/file_" + ext + ".png'> <a href='" + src + "'>" + name + "</a>"
            break;
        }
    
        tinyMCE.execCommand("mceInsertContent", false , _str);
    }
    
    $(document).ready(function(){
        reload_attach(1, "", "", "", "");
        $("#btn_insert").click(function(){
            reload_attach(1, "", "", "", "");
            $("#attach_search").show();
            $("#attach_page").show();
        });
        $("#btn_article").click(function(){
            reload_attach_article(1, "", "", "", "");
            $("#attach_search").hide();
            $("#attach_page").show();
        });
        $("#btn_upload").click(function(){
            $("#attach_search").hide();
            $("#attach_page").hide();
        });
        $("#search_btn").click(function(){
            var _year   = $("#search_year").val();
            var _month  = $("#search_month").val();
            var _ext    = $("#search_ext").val();
            var _key    = $("#search_key").val();
            reload_attach(1, _year, _month, _ext, _key);
        });
    });
    </script>