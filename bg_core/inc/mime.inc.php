<?php
/*-----------------------------------------------------------------
！！！！警告！！！！
以下为系统文件，请勿修改
-----------------------------------------------------------------*/

//不能非法包含或直接执行
if (!defined('IN_BAIGO')) {
    exit('Access Denied');
}

/*-------------------------通用-------------------------*/
return array(
    'gif' => array(
        'image/gif'
    ),
    'jpg' => array(
        'image/jpeg',
        'image/pjpeg'
    ),
    'jpeg' => array(
        'image/jpeg',
        'image/pjpeg'
    ),
    'jpe' => array(
        'image/jpeg',
        'image/pjpeg'
    ),
    'png' => array(
        'image/png',
        'image/x-png'
    ),
    'bmp' => array(
        'image/bmp',
        'image/x-bmp',
        'image/x-bitmap',
        'image/x-xbitmap',
        'image/x-win-bitmap',
        'image/x-windows-bmp',
        'image/ms-bmp',
        'image/x-ms-bmp',
        'application/bmp',
        'application/x-bmp',
        'application/x-win-bitmap'
    ),
    'tif' => array(
        'image/tiff'
    ),
    'tiff' => array(
        'image/tiff'
    ),
    'doc' => array(
        'application/msword',
        'application/vnd.ms-office'
    ),
    'xls' => array(
        'application/vnd.ms-excel',
        'application/msexcel',
        'application/x-msexcel',
        'application/x-ms-excel',
        'application/x-excel',
        'application/x-dos_ms_excel',
        'application/xls',
        'application/x-xls',
        'application/excel',
        'application/download',
        'application/vnd.ms-office',
        'application/msword'
    ),
    'ppt' => array(
        'application/powerpoint',
        'application/vnd.ms-powerpoint',
        'application/vnd.ms-office',
        'application/msword'
    ),
    'docx' => array(
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/zip',
        'application/msword',
        'application/x-zip'
    ),
    'xlsx' => array(
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/zip',
        'application/vnd.ms-excel',
        'application/msword',
        'application/x-zip'
    ),
    'pptx' =>  array(
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'application/x-zip',
        'application/zip'
    ),
    'pdf' => array(
        'application/pdf',
        'application/force-download',
        'application/x-download',
        'binary/octet-stream',
    ),
    'zip' => array(
        'application/x-zip',
        'application/zip',
        'application/x-zip-compressed',
        'application/s-compressed',
        'multipart/x-zip'
    ),
    'rar' => array(
        'application/x-rar',
        'application/rar',
        'application/x-rar-compressed'
    ),
    'txt' => array(
        'text/plain',
    ),
    'rtf' => array(
        'text/rtf',
    ),
    'svg' => array(
        'image/svg+xml',
        'application/xml',
        'text/xml'
    ),
);
