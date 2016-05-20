<?php
return "<a name=\"list\"></a>
    <h3>所有附件</h3>
    <p>
        点左侧菜单“附件管理“，进入如下界面，可以对已上传的文件进行删除操作。点击“上传按钮“，可以上传文件。上传受上传设置和附件类型的限制，详见 <a href=\"{BG_URL_HELP}ctl.php?mod=admin&act_get=opt#upload\">上传设置</a>、<a href=\"#mime\">附件类型</a>。
    </p>

    <p>
        点击“清理附件“，可以将未在本系统使用的附件放至回收站（请谨慎操作，有些附件可能会在其他系统被使用）。进入回收站后，还可以将附件放回原处，如果确定不再使用，可以清空回收站。
    </p>

    <p>
        <img src=\"{images}attach_list.jpg\" class=\"img-responsive thumbnail\">
    </p>

    <hr>

    <a name=\"mime\"></a>
    <h3>附件类型</h3>
    <p>
        点左侧子菜单“附件类型“，进入如下界面，可以对允许上传的文件类型进行删除操作。
    </p>

    <p>
        <img src=\"{images}mime_list.jpg\" class=\"img-responsive thumbnail\">
    </p>

    <p>左侧表单可以创建允许上传的文件类型。表单下方的选框是常用的 MIME 类型，选择自动填写表单。</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text-info\">允许上传的 MIME</h4>
            <p>允许上传的 MIME 类型。MIME 全称：多用途互联网邮件扩展（MIME，Multipurpose Internet Mail Extensions）是一个互联网标准，它扩展了电子邮件标准。详见 <a href=\"http://www.baike.com/wiki/MIME\" target=\"_blank\">互动百科</a></p>

            <h4 class=\"text-info\">扩展名</h4>
            <p>与 MIME 类型相对应的扩展名。</p>

            <h4 class=\"text-info\">备注</h4>
            <p>备注。</p>
        </div>
    </div>

    <hr>

    <a name=\"thumb\"></a>
    <h3>缩略图</h3>
    <p>
        点左侧子菜单“缩略图“，进入如下界面，可以对系统自动生成的缩略图进行删除、更新缓存等操作，100 X 100 为系统默认缩略图，无法删除，调用键名主要用于模板开发。
    </p>
    <p>
        进入编辑缩略图后，可以点击“重新生成缩略图“，系统会将根据该尺寸，对系统内的所有图片重新生成缩略图，重新生成将耗费非常长的时间（视系统内图片的数量），同时也将耗费大量系统资源，请谨慎操作。此操作一般应用于更改了缩略图尺寸，或者新增了缩略图以后。因更改尺寸，系统内原该尺寸的缩略图会失效，新尺寸的缩略图尚未生成。新增缩略图类似，增加缩略图前上传的图片，将没有改尺寸的缩略图。
    </p>
    <p>
        <img src=\"{images}thumb_list.jpg\" class=\"img-responsive thumbnail\">
    </p>

    <p>左侧表单可以创建自动生成的缩略图的尺寸。</p>

    <div class=\"panel panel-default\">
        <div class=\"panel-heading\">填写说明</div>
        <div class=\"panel-body\">
            <h4 class=\"text-info\">最大宽度（像素）</h4>
            <p>生成缩略图是的最大宽度，根据缩略图类型不同，此参数会有所不同，当缩略图类型为比例时，图片的宽度有可能小于此参数，为裁切时，图片宽度等于此参数。</p>

            <h4 class=\"text-info\">最大高度（像素）</h4>
            <p>生成缩略图是的最大高度，根据缩略图类型不同，此参数会有所不同，当缩略图类型为比例时，图片的高度有可能小于此参数，为裁切时，图片高度等于此参数。</p>

            <h4 class=\"text-info\">缩略图类型</h4>
            <p>
                比例：图片按照上述两项参数的规定，按比例缩放，裁切：图片按照上述两项参数的规定，缩放图片，超出部分将被裁掉。下图是缩略图类型的说明，以最大宽度150，最大高度150为例，左侧为比例，右侧为裁切。
            </p>
            <p>
                <img src=\"{images}thumb_note.jpg\" class=\"img-responsive thumbnail\">
            </p>
        </div>
    </div>";