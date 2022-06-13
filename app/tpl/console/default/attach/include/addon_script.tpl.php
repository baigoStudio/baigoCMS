  <script type="text/javascript">
  function albumAdd(album_id, album_name) {
    if ($('#album_item_' + album_id).length < 1) {
      var _album_list_html = '<div class="input-group mb-2" id="album_item_' + album_id + '">' +
        '<div class="input-group-prepend">' +
          '<div class="input-group-text border-success">' +
            '<input type="hidden" name="attach_album_ids[]" value="' + album_id + '" class="attach_album_ids">' +
            '<span class="bg-icon text-primary"><?php include($tpl_icon . 'check-circle' . BG_EXT_SVG); ?></span>' +
          '</div>' +
        '</div>' +
        '<input type="text" class="form-control border-success bg-transparent" readonly value="' + album_name + '">' +
        '<div class="input-group-append">' +
          '<button type="button" class="btn btn-success album_del" data-id="' + album_id + '">' +
            '<span class="bg-icon"><?php include($tpl_icon . 'trash-alt' . BG_EXT_SVG); ?></span>' +
          '</button>' +
        '</div>' +
      '</div>';

      $('#album_list').append(_album_list_html);
    }
  }

  function albumDel(id) {
    $('#album_item_' + id).remove();
  }

  $(document).ready(function(){
    var albumsData = new Bloodhound({
      datumTokenizer: Bloodhound.tokenizers.whitespace,
      queryTokenizer: Bloodhound.tokenizers.whitespace,
      remote: {
        url: '<?php echo $hrefRow['album-typeahead']; ?>%KEY',
        wildcard: '%KEY'
      }
    });

    albumsData.initialize();

    var _obj_album = $('#album_key').typeahead(
      {
        highlight: true
      },
      {
        source: albumsData.ttAdapter(),
        display: 'album_name'
      }
    );

    _obj_album.bind('typeahead:select', function(ev, suggestion) {
      albumAdd(suggestion.album_id, suggestion.album_name);
      $('#album_key').typeahead('val', '');
    });

    $('#album_list').on('click', '.album_del', function(){
      var _id  = $(this).data('id');
      albumDel(_id);
    });
  });
  </script>
