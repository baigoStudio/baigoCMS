  <script type="text/javascript">
  var opts_wu = {
    //附加表单数据
    formData: {
      <?php echo $token['name']; ?>: '<?php echo $token['value']; ?>'
    },
    server: '<?php echo $hrefRow['upload']; ?>', //文件接收服务端
    pick: '#upload_select', //选择按钮
    fileVal: 'attach_files', //设置 file 域的 name
    //允许的 mime
    accept: {
      title: 'file',
      extensions: '<?php echo $allow_exts; ?>',
      mimeTypes: '<?php echo $allow_mimes; ?>'
    },
    fileNumLimit: <?php echo $config['var_extra']['upload']['limit_count']; ?>, //队列限制
    fileSingleSizeLimit: <?php echo $limit_size; ?>, //单个尺寸限制
    resize: false, //不压缩 image
    compress: false //不压缩 image
  };

  var opts_dialog = {
    btn_text: {
      ok: '<?php echo $lang->get('OK', 'console.common'); ?>'
    }
  };

  function queuedTpl(_key, _file, _msg) {
    var _str_tpl = '<div id="GK_' + _key + '" class="alert alert-info alert-dismissible">' +
      '<div class="media">' +
        '<img src="" class="mr-3 bg-img">' +
        '<div class="media-body text-truncate">' +
          '<div class="text-truncate">' + _file + '</div>' +
          '<div>' +
            '<span class="bg-icon bg-fw"><?php include($tpl_icon . 'cloud-upload-alt' . BG_EXT_SVG); ?></span>' +
            '<span class="bg-msg">' + _msg + '</span>' +
          '</div>' +
        '</div>' +
      '</div>' +
      '<div class="progress bg-progress mt-3">' +
        '<div class="progress-bar progress-bar-info progress-bar-striped active" style="width: 10%"></div>'+
      '</div>' +
      '<button type="button" class="close remove-this" data-id="' + _key + '" data-dismiss="alert">' +
        '&times;' +
      '</button>' +
    '<div>';

    return _str_tpl;
  }

  function queuedProcess(_key, _class, _icon, _msg) {
    $('#GK_' + _key).removeClass('alert-info alert-danger alert-success');
    $('#GK_' + _key).addClass(_class);
    $('#GK_' + _key + ' .bg-icon').html(_icon);
    $('#GK_' + _key + ' .bg-msg').html(_msg);
  }

  $(document).ready(function(){
    var obj_dialog = $.baigoDialog(opts_dialog);

    if (!WebUploader.Uploader.support()) {
      obj_dialog.alert('<?php echo $lang->get('Uploading requires HTML5 support, please upgrade your browser'); ?>');
    }

    var obj_wu = new WebUploader.Uploader(opts_wu);

    $('#upload_begin').click(function(){
      var _formData = obj_wu.option('formData');

      if (typeof _formData['attach_album_ids[0]'] == 'undefined') {
        _formData['attach_album_ids[0]'] = '';
      }

      $('.attach_album_ids').each(function(key, value){
        _formData['attach_album_ids[' + key + ']'] = $(value).val();
      });

      //console.log(_formData);

      obj_wu.option('formData', _formData);

      obj_wu.upload();
    });

    obj_wu.on('fileQueued', function(file){
      _str_tpl = queuedTpl(file.id, file.name, '<?php echo $lang->get('Waiting'); ?>');

      $('#upload_list').append(_str_tpl);
      $('#GK_' + file.id + ' .bg-progress').hide();

      obj_wu.makeThumb(file, function(error, src) {
        if (error) {
          $('img.bg-img').hide();
        }

        $('#GK_' + file.id + ' img.bg-img').attr('src', src);
      }, 60, 60);
    });

    obj_wu.on('error', function(error, size, file){
      //console.log(file);
      switch(error) {
        case 'F_EXCEED_SIZE':
          obj_dialog.alert(file.name + ' <?php echo $lang->get('File size exceeds {:size}', '', $_arr_langReplace); ?>');
        break;

        case 'Q_EXCEED_NUM_LIMIT':
          obj_dialog.alert(file.name + ' <?php echo $lang->get('File count exceeds {:count}', '', $_arr_langReplace); ?>');
        break;

        case 'Q_TYPE_DENIED':
          obj_dialog.alert(file.name + ' <?php echo $lang->get('Type denied'); ?>');
        break;
      }
    });

    obj_wu.on('uploadProgress', function(file, percentage){
      queuedProcess(file.id, 'alert-info', '<span class="spinner-grow spinner-grow-sm"></span>', '<?php echo $lang->get('Uploading'); ?>');

      $('#GK_' + file.id + ' .bg-progress').show();
      $('#GK_' + file.id + ' .bg-progress .progress-bar').text(percentage * 100 + '%');
      $('#GK_' + file.id + ' .bg-progress .progress-bar').css('width', percentage * 100 + '%');
    });

    obj_wu.on('uploadSuccess', function(file, result){
      if (typeof result.msg == 'undefined') {
        result.msg = '<?php echo $lang->get('Unknown'); ?>';
      }

      if (result.rcode == 'y070401') {
        queuedProcess(file.id, 'alert-success', '<?php include($tpl_icon . 'check-circle' . BG_EXT_SVG); ?>', result.msg);

        <?php if (isset($cfg['script_insert'])) { ?>
          insertAttach(result.attach_url, result.attach_name, result.attach_id, result.attach_type, result.attach_ext);
        <?php } ?>
      } else {
        queuedProcess(file.id, 'alert-danger', '<?php include($tpl_icon . 'times-circle' . BG_EXT_SVG); ?>', result.msg);
      }
    });

    obj_wu.on('uploadError', function(file, result){
      queuedProcess(file.id, 'alert-danger', '<?php include($tpl_icon . 'times-circle' . BG_EXT_SVG); ?>', 'Error&nbsp;status:&nbsp;' + result);
    });

    obj_wu.on('uploadComplete', function(file){
      $('#GK_' + file.id + ' .bg-progress').slideUp('slow');

      setTimeout(function(){
        $('#GK_' + file.id).slideUp('slow');
      }, 2000);
    });

    $('#upload_list').on('click', '.close', function() {
      var _id = $(this).data('id');
      obj_wu.removeFile(_id, true);
    });
  });
  </script>
