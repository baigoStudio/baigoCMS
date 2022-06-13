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
    <button type="button" class="close pb-2" data-dismiss="modal">&times;</button>
  </div>

  <div class="modal-body">
    <div class="clearfix" id="album_search">
      <div class="float-right">
        <div class="input-group input-group-sm mb-3">
          <input type="text" name="search_key" id="search_key" placeholder="<?php echo $lang->get('Keyword'); ?>" class="form-control">
          <span class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="search_btn">
              <span class="bg-icon"><?php include($tpl_icon . 'search' . BG_EXT_SVG); ?></span>
            </button>
          </span>
        </div>
      </div>
    </div>

    <div id="album_list" class="row"></div>

    <div class="clearfix">
      <div id="album_page" class="float-right"></div>
    </div>
  </div>

  <div class="modal-footer">
    <button type="button" class="btn btn-outline-secondary btn-sm" data-dismiss="modal"><?php echo $lang->get('Close', 'console.common'); ?></button>
  </div>

  <script type="text/javascript">
  function pageTpl(result, page, key) {
    if (typeof page == 'undefined') {
      page = '';
    }

    if (typeof key == 'undefined') {
      key = '';
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
      _str_page += '<li class="page-item"><a href="javascript:void(0);" data-page="1" data-key="' + key + '" title="<?php echo $_lang_pageFirst; ?>" class="page-link"><?php echo $_lang_pageFirst; ?></a></li>';
    }

    if (!isNaN(result.pageRow.group_prev)) {
      _str_page += '<li class="page-item d-none d-lg-block"><a href="javascript:void(0);" data-page="' + (result.pageRow.p * 10) + '" data-key="' + key + '" title="<?php echo $_lang_pagePrevGroup; ?>" class="page-link">...</a></li>';
    }

    _str_page += '<li class="page-item';
    if (isNaN(result.pageRow.prev)) {
      _str_page += ' disabled';
    }
    _str_page += '">';
      if (isNaN(result.pageRow.prev)) {
        _str_page += '<span title="<?php echo $_lang_pagePrev; ?>" class="page-link"><span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span></span>';
      } else {
        _str_page += '<a href="javascript:void(0);" data-page="' + (result.pageRow.page - 1) + '" data-key="' + key + '" title="<?php echo $_lang_pagePrev; ?>" class="page-link"><span class="bg-icon"><?php include($tpl_icon . 'chevron-left' . BG_EXT_SVG); ?></span></a>';
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
        _str_page += '<a href="javascript:void(0);" data-page="' + _iii + '" data-key="' + key + '" title="' + _iii + '" class="page-link">' + _iii + '</a>';
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
        _str_page += '<a href="javascript:void(0);" data-page="' + (result.pageRow.page + 1) + '" data-key="' + key + '" title="<?php echo $_lang_pageNext; ?>" class="page-link"><span class="bg-icon"><?php include($tpl_icon . 'chevron-right' . BG_EXT_SVG); ?></span></a>';
      }
    _str_page += '</li>';

    if (!isNaN(result.pageRow.group_next)) {
      _str_page += '<li class="page-item d-none d-lg-block"><a href="javascript:void(0);" data-page="' + _iii + '" data-key="' + key + '" title="<?php echo $_lang_pageNextGroup; ?>" class="page-link">...</a></li>';
    }

    if (!isNaN(result.pageRow.final)) {
      _str_page += '<li class="page-item"><a href="javascript:void(0);" data-page="' + result.pageRow.total + '" data-key="' + key + '" title="<?php echo $_lang_pageFinal; ?>" class="page-link"><?php echo $_lang_pageFinal; ?></a></li>';
    }
    _str_page += '</ul>';

    return _str_page;
  }

  function albumTpl(value) {
    var _str_appent = '<div class="col-4 col-lg-2 mb-3">' +
      '<div class="card h-100">' +
        '<a href="' + value.album_url.url + '" class="h-100" target="_blank">' +
          '<img src="' + value.attachRow.attach_thumb + '" alt="' + value.album_name + '" class="card-img-top" alt="' + value.album_name + '" title="' + value.album_name + '">' +
        '</a>' +

        '<div class="card-body p-2">' +
          '<div class="text-truncate" title="' + value.album_name + '"><small>' + value.album_name + '</small></div>' +
        '</div>' +

        '<div>' +
          '<button type="button" class="btn btn-outline-success btn-block bg-btn-bottom album_insert" data-url="' + value.album_url.url + '" data-thumb="' + value.attachRow.attach_thumb + '" data-name="' + value.album_name + '" data-id="' + value.album_id + '">'+
            '<?php echo $lang->get('Insert album'); ?>' +
          '</button>' +
        '</div>' +
      '</div>' +
    '</div>';

    return _str_appent;
  }

  function reloadAlbum(page, key) {
    var _row_selector       = '#album_list';
    var _str_appent_page    = '';
    var _str_appent_album   = '';
    var _url                = '<?php echo $hrefRow['lists']; ?>';

    if (typeof page == 'undefined' || page < 1) {
      page = 1;
    }

    if (typeof key == 'undefined') {
      key = 0;
    }

    _url = _url.replace('{:page}', page);
    _url = _url.replace('{:key}', key);

    $.getJSON(_url, function(result){
      _str_appent_page = pageTpl(result, page, key);

      $('#album_page').html(_str_appent_page);

      $.each(result.albumRows, function(key, value){
        _str_appent_album += albumTpl(value);
      });

      $(_row_selector).html(_str_appent_album);
    });
  }

  function insertAlbum(id, url, thumb, name) {
    var _str = '<div class="bg-album-box"><div class="bg-album-main"><a href="' + url + '" target="_blank" class="bg-album-link"><img src="' + thumb + '" data-id="' + id + '" class="img-fluid bg-album-thumb"></a></div><div class="bg-album-title">' + name + '</div></div>';

    tinyMCE.execCommand('mceInsertContent', false, _str);
  }

  $(document).ready(function(){
    reloadAlbum(1);
    $('#search_btn').click(function(){
      var _key    = $('#search_key').val();
      reloadAlbum(1, _key);
    });
    $('#album_page').on('click', '.page-link', function(){
      var _page       = $(this).data('page');
      var _key        = $(this).data('key');
      reloadAlbum(_page, _key);
    });
    $('#album_list').on('click', '.album_insert', function(){
      var _url    = $(this).data('url');
      var _thumb  = $(this).data('thumb');
      var _name   = $(this).data('name');
      var _id     = $(this).data('id');

      insertAlbum(_id, _url, _thumb, _name);
    });
  });
  </script>
