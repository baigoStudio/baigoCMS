  <?php $cfg = array(
    'script_insert' => 'true',
  );

  $_lang_pageFirst        = $lang->get('First page', 'console.common');
  $_lang_pagePrevGroup    = $lang->get('Previous ten pages', 'console.common');
  $_lang_pagePrev         = $lang->get('Previous page', 'console.common');
  $_lang_pageNext         = $lang->get('Next page', 'console.common');
  $_lang_pageNextGroup    = $lang->get('Next ten pages', 'console.common');
  $_lang_pageFinal        = $lang->get('End page', 'console.common'); ?>

  <div class="modal-header bg-light">
    <ul class="nav nav-tabs bg-modal-header-tabs">
      <li class="nav-item">
        <a href="#pane_insert" id="btn_insert" data-toggle="tab" class="nav-link py-1 active"><?php echo $lang->get('Insert'); ?></a>
      </li>
      <li class="nav-item">
        <a href="#pane_upload" id="btn_upload" data-toggle="tab" class="nav-link py-1"><?php echo $lang->get('Upload'); ?></a>
      </li>
      <?php if (isset($articleRow['article_id']) && $articleRow['article_id'] > 0) { ?>
        <li class="nav-item">
          <a href="#pane_article" id="btn_article" data-toggle="tab" data-article="<?php echo $articleRow['article_id']; ?>" class="nav-link py-1"><?php echo $lang->get('Attachments in this article'); ?></a>
        </li>
      <?php } ?>
    </ul>
    <button type="button" class="close pb-2" data-dismiss="modal">&times;</button>
  </div>

  <div class="modal-body">
    <div class="clearfix" id="attach_search">
      <div class="float-right">
        <div class="input-group input-group-sm mb-3">
          <input type="text" name="search_key" id="search_key" placeholder="<?php echo $lang->get('Keyword'); ?>" class="form-control">
          <span class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="search_btn">
              <span class="bg-icon"><?php include($tpl_icon . 'search' . BG_EXT_SVG); ?></span>
            </button>
            <button class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" type="button" data-toggle="collapse" data-target="#bg-search-more">
              <span class="sr-only">Dropdown</span>
            </button>
          </span>
        </div>
        <div class="collapse" id="bg-search-more">
          <div class="input-group input-group-sm mb-3">
            <select name="ext" id="search_ext" class="custom-select">
              <option value=""><?php echo $lang->get('All extensions'); ?></option>
              <?php foreach ($extRows as $key=>$value) { ?>
                <option value="<?php echo $value['attach_ext']; ?>"><?php echo $value['attach_ext']; ?></option>
              <?php } ?>
            </select>
            <select name="year" id="search_year" class="custom-select">
              <option value=""><?php echo $lang->get('All years'); ?></option>
              <?php foreach ($yearRows as $key=>$value) { ?>
                <option value="<?php echo $value['attach_year']; ?>"><?php echo $value['attach_year']; ?></option>
              <?php } ?>
            </select>
            <select name="month" id="search_month" class="custom-select">
              <option value=""><?php echo $lang->get('All months'); ?></option>
              <?php for ($iii = 1 ; $iii <= 12; ++$iii) {
                if ($iii < 10) {
                  $str_month = '0' . $iii;
                } else {
                  $str_month = $iii;
                } ?>
                <option value="<?php echo $str_month; ?>"><?php echo $str_month; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div class="tab-content">
      <div class="tab-pane active" id="pane_insert">
        <div id="attach_list" class="row"></div>
      </div>

      <div class="tab-pane" id="pane_upload">
        <?php include($tpl_ctrl . 'upload_form' . GK_EXT_TPL); ?>
      </div>

      <div class="tab-pane active" id="pane_article">
        <div id="attach_list_article" class="row"></div>
      </div>
    </div>

    <div class="clearfix">
      <div id="attach_page" class="float-right"></div>
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><?php echo $lang->get('Close', 'console.common'); ?></button>
  </div>

  <?php include($tpl_ctrl . 'upload_script' . GK_EXT_TPL); ?>

  <script type="text/javascript">
  var _thumbType = <?php echo $thumbType; ?>;

  function pageTpl(result, page, year, month, ext, key, article) {
    if (typeof page == 'undefined') {
      page = 1;
    }

    if (typeof year == 'undefined') {
      year = 0;
    }

    if (typeof month == 'undefined') {
      month = 0;
    }

    if (typeof ext == 'undefined') {
      ext = 0;
    }

    if (typeof key == 'undefined') {
      key = 0;
    }

    if (typeof article == 'undefined') {
      article = 0;
    }

    result.pageRow.page         = parseInt(result.pageRow.page);
    result.pageRow.first        = parseInt(result.pageRow.first);
    result.pageRow.final        = parseInt(result.pageRow.final);
    result.pageRow.prev         = parseInt(result.pageRow.prev);
    result.pageRow.next         = parseInt(result.pageRow.next);
    result.pageRow.group_begin  = parseInt(result.pageRow.group_begin);
    result.pageRow.group_end    = parseInt(result.pageRow.group_end);
    result.pageRow.group_prev   = parseInt(result.pageRow.group_prev);
    result.pageRow.group_next   = parseInt(result.pageRow.group_next);

    var _str_page = '<ul class="pagination pagination-sm mt-1 mb-2">';

      if (!isNaN(result.pageRow.first)) {
        _str_page += '<li class="page-item"><a href="javascript:void(0);" data-page="1" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" data-article="' + article + '" title="<?php echo $_lang_pageFirst; ?>" class="page-link"><?php echo $_lang_pageFirst; ?></a></li>';
      }

      if (!isNaN(result.pageRow.group_prev)) {
        _str_page += '<li class="page-item d-none d-lg-block"><a href="javascript:void(0);" data-page="' + (result.pageRow.p * 10) + '" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" data-article="' + article + '" title="<?php echo $_lang_pagePrevGroup; ?>" class="page-link">...</a></li>';
      }

      _str_page += '<li class="page-item';
      if (isNaN(result.pageRow.prev)) {
        _str_page += ' disabled';
      }
      _str_page += '">';
        if (isNaN(result.pageRow.prev)) {
          _str_page += '<span title="<?php echo $_lang_pagePrev; ?>" class="page-link"><span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span></span>';
        } else {
          _str_page += '<a href="javascript:void(0);" data-page="' + (result.pageRow.page - 1) + '" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" data-article="' + article + '" title="<?php echo $_lang_pagePrev; ?>" class="page-link"><span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span></a>';
        }
      _str_page += '</li>';

      for (_iii = result.pageRow.group_begin; _iii <= result.pageRow.group_end; ++_iii) {
        _str_page += '<li class="page-item d-none d-lg-block';
          if (_iii == result.pageRow.page) {
            _str_page += ' active';
          }
        _str_page += '">';
        if (_iii == result.pageRow.page) {
          _str_page += '<span class="page-link">' + _iii + '</span>';
        } else {
          _str_page += '<a href="javascript:void(0);" data-page="' + _iii + '" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" data-article="' + article + '" title="' + _iii + '" class="page-link">' + _iii + '</a>';
        }
        _str_page += '</li>';
      }

      _str_page += '<li class="page-item';
      if (isNaN(result.pageRow.next)) {
        _str_page += ' disabled';
      }
      _str_page += '">';
        if (isNaN(result.pageRow.next)) {
          _str_page += '<span title="<?php echo $_lang_pageNext; ?>" class="page-link"><span class="bg-icon"><?php include($tpl_icon . 'chevron-right' . BG_EXT_SVG); ?></span></span>';
        } else {
          _str_page += '<a href="javascript:void(0);" data-page="' + (result.pageRow.page + 1) + '" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" data-article="' + article + '" title="<?php echo $_lang_pageNext; ?>" class="page-link"><span class="bg-icon"><?php include($tpl_icon . 'chevron-right' . BG_EXT_SVG); ?></span></a>';
        }
      _str_page += '</li>';

      if (!isNaN(result.pageRow.group_next)) {
        _str_page += '<li class="page-item d-none d-lg-block"><a href="javascript:void(0);" data-page="' + _iii + '" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" data-article="' + article + '" title="<?php echo $_lang_pageNextGroup; ?>" class="page-link">...</a></li>';
      }

      if (!isNaN(result.pageRow.final)) {
        _str_page += '<li class="page-item"><a href="javascript:void(0);" data-page="' + result.pageRow.final + '" data-year="' + year + '" data-month="' + month + '" data-ext="' + ext + '" data-key="' + key + '" data-article="' + article + '" title="<?php echo $_lang_pageFinal; ?>" class="page-link"><?php echo $_lang_pageFinal; ?></a></li>';
      }
    _str_page += '</ul>';

    return _str_page;
  }

  function attachTpl(value) {
    var _str_appent = '<div class="col-4 col-lg-2 mb-3">' +
      '<div class="card h-100">' +
        '<a href="' + value.attach_url + '" class="h-100" target="_blank">' +
          '<img src="' + value.attach_thumb + '" alt="' + value.attach_name + '" class="card-img-top" alt="' + value.attach_name + '" title="' + value.attach_name + '">' +
        '</a>' +

        '<div class="card-body p-2">' +
          '<div class="text-truncate" title="' + value.attach_name + '"><small>' + value.attach_name + '</small></div>' +
        '</div>' +

        <?php switch ($search['target']) {
          case 'cate_cover':
          case 'article_cover':
          case 'album_cover':
          case 'spec_cover': ?>
            '<button type="button" class="btn btn-outline-success btn-block bg-btn-bottom attach_insert" data-src="' + value.attach_thumb + '" data-name="' + value.attach_name + '" data-id="' + value.attach_id + '" data-type="' + value.attach_type + '" data-ext="' + value.attach_ext + '">' +
              '<?php echo $lang->get('Select'); ?>' +
            '</button>' +
          <?php break;

          default: ?>
            '<div class="dropdown">' +
              '<button type="button" class="btn btn-outline-success btn-block bg-btn-bottom dropdown-toggle" data-toggle="dropdown">' +
                '<?php echo $lang->get('Insert'); ?>' +
              '</button>' +
              '<div class="dropdown-menu">' +
                '<button type="button" data-src="' + value.attach_url + '" data-name="' + value.attach_name + '" data-id="' + value.attach_id + '" data-type="' + value.attach_type + '" data-ext="' + value.attach_ext + '" class="dropdown-item attach_insert"><?php echo $lang->get('Insert original image'); ?></button>';

                if (value.attach_type == 'image') {
                  $.each(value.thumbRows, function(thumb_i, field_thumb){
                    _str_appent += '<a href="javascript:void(0);" data-src="' + field_thumb.thumb_url + '" data-name"' + value.attach_name + '" data-id="' + value.attach_id + '" data-type="' + value.attach_type + '" data-ext="' + value.attach_ext + '" class="dropdown-item attach_insert"><?php echo $lang->get('Insert'); ?>: ' + field_thumb.thumb_width + ' x ' + field_thumb.thumb_height + ' ' + _thumbType[field_thumb.thumb_type] + '</a>';
                  });
                }

                _str_appent += '<a href="' + value.attach_url + '" target="_blank" class="dropdown-item"><?php echo $lang->get('View original image'); ?></a>' +
              '</div>' +
            '</div>' +
          <?php break;
        } ?>
      '</div>' +
    '</div>';

    return _str_appent;
  }


  function reloadAttach(page, year, month, ext, key, article) {
    var _row_selector       = '#attach_list';
    var _str_appent_page    = '';
    var _str_appent_attach  = '';
    var _url                = '<?php echo $hrefRow['lists']; ?>';

    if (typeof page == 'undefined' || page < 1) {
      page = 1;
    }

    if (typeof year == 'undefined' || year.length < 1) {
      year = 0;
    }

    if (typeof month == 'undefined' || month.length < 1) {
      month = 0;
    }

    if (typeof ext == 'undefined' || ext.length < 1) {
      ext = 0;
    }

    if (typeof key == 'undefined' || key.length < 1) {
      key = 0;
    }

    if (typeof article == 'undefined' || article < 0) {
      article = 0;
    } else {
      _row_selector = '#attach_list_article';
    }

    _url = _url.replace('{:page}', page);
    _url = _url.replace('{:year}', year);
    _url = _url.replace('{:month}', month);
    _url = _url.replace('{:ext}', ext);
    _url = _url.replace('{:key}', key);
    _url = _url.replace('{:article}', article);

    $.getJSON(_url, function(result){
      _str_appent_page = pageTpl(result, page, year, month, ext, key, article);

      $('#attach_page').html(_str_appent_page);

      $.each(result.attachRows, function(key, value){
        _str_appent_attach += attachTpl(value);
      });

      $(_row_selector).html(_str_appent_attach);
    });

    _str_appent_attach = '';
  }

  function insertAttach(src, name, id, type, ext) {
    <?php switch ($search['target']) {
      case 'article_cover': ?>
        if (type == 'image') {
          $('#article_attach_id').val(id);
          $('#article_attach_src').val(src);
          $('#article_attach_img').html('<img src="' + src + '" class="img-fluid">');
        }
      <?php break;

      case 'album_cover': ?>
        if (type == 'image') {
          $('#album_attach_id').val(id);
          $('#album_attach_src').val(src);
          $('#album_attach_img').html('<img src="' + src + '" class="img-fluid">');
        }
      <?php break;

      case 'spec_cover': ?>
        if (type == 'image') {
          $('#spec_attach_id').val(id);
          $('#spec_attach_src').val(src);
          $('#spec_attach_img').html('<img src="' + src + '" class="img-fluid">');
        }
      <?php break;

      case 'cate_cover': ?>
        if (type == 'image') {
          $('#cate_attach_id').val(id);
          $('#cate_attach_src').val(src);
          $('#cate_attach_img').html('<img src="' + src + '" class="img-fluid">');
        }
      <?php break;

      default: ?>
        var _str = '';

        switch (type) {
          case 'image':
            _str = '<div class="bg-image-box"><a href="' + src + '" target="_blank" class="bg-image-link"><img src="' + src + '" data-id="' + id + '" class="img-fluid bg-image-img"></a></div>'
          break;

          default:
            _str = '<img src="{:DIR_STATIC}image/file_' + ext + '.png"> <a href="' + src + '">' + name + '</a>'
          break;
        }

        tinyMCE.execCommand('mceInsertContent', false, _str);
      <?php break;
    } ?>
  }

  $(document).ready(function(){
    reloadAttach(1);
    $('#btn_insert').on('shown.bs.tab', function(){
      reloadAttach(1);
      $('#attach_search').show();
      $('#attach_page').show();
    });
    $('#btn_article').on('shown.bs.tab', function(){
      var _article = $(this).data('article');
      reloadAttach(1, '', '', '', '', _article);
      $('#attach_search').hide();
      $('#attach_page').show();
    });
    $('#btn_upload').on('shown.bs.tab', function(){
      $('#attach_search').hide();
      $('#attach_page').hide();
    });
    $('#search_btn').click(function(){
      var _year   = $('#search_year').val();
      var _month  = $('#search_month').val();
      var _ext    = $('#search_ext').val();
      var _key    = $('#search_key').val();
      reloadAttach(1, _year, _month, _ext, _key);
    });
    $('#attach_page').on('click', '.page-link', function(){
      var _page       = $(this).data('page');
      var _year       = $(this).data('year');
      var _month      = $(this).data('month');
      var _ext        = $(this).data('ext');
      var _key        = $(this).data('key');
      var _article    = $(this).data('article');
      reloadAttach(_page, _year, _month, _ext, _key, _article);
    });
    $('#attach_list, #attach_list_article').on('click', '.attach_insert', function(){
      var _src    = $(this).data('src');
      var _name   = $(this).data('name');
      var _id     = $(this).data('id');
      var _type   = $(this).data('type');
      var _ext    = $(this).data('ext');
      insertAttach(_src, _name, _id, _type, _ext);
    });
  });
  </script>
