<?php
return array(
    'base' => array(
        'title' => 'Base settings',
        'lists' => array(
            'site_name' => array(
                'title'     => 'Site name',
                'type'      => 'text',
                'require'   => 'true',
            ),
            'site_date' => array(
                'title'      => 'Date format',
                'type'       => 'select_input',
                'note'       => 'Select or type the format parameter of the <code>date</code> function',
                'require'    => 'true',
                'date_param' => 'true',
                'option'     => array(
                    'Y-m-d'     => '{:Y-m-d}',
                    'y-m-d'     => '{:y-m-d}',
                    'M. d, Y'   => '{:M. d, Y}',
                ),
            ),
            'site_date_short' => array(
                'title'      => 'Short date format',
                'type'       => 'select_input',
                'note'       => 'Select or type the format parameter of the <code>date</code> function',
                'require'    => 'true',
                'date_param' => 'true',
                'option'     => array(
                    'm-d'    => '{:m-d}',
                    'M. d'   => '{:M. d}',
                ),
            ),
            'site_time' => array(
                'title'      => 'Time format',
                'type'       => 'select_input',
                'note'       => 'Select or type the format parameter of the <code>date</code> function',
                'require'    => 'true',
                'date_param' => 'true',
                'option'     => array(
                    'H:i:s'     => '{:H:i:s}',
                    'h:i:s A'   => '{:h:i:s A}',
                ),
            ),
            'site_time_short' => array(
                'title'      => 'Short time format',
                'type'       => 'select_input',
                'note'       => 'Select or type the format parameter of the <code>date</code> function',
                'require'    => 'true',
                'date_param' => 'true',
                'option'     => array(
                    'H:i'    => '{:H:i}',
                    'h:i A'  => '{:h:i A}',
                ),
            ),
            'site_thumb_default' => array(
                'title'     => 'Default thumbnail',
                'type'      => 'select',
                'require'   => 'false',
                'option'    => array(),
            ),
        ),
    ),
    'upload' => array(
        'title' => 'Upload settings',
    ),
    'visit' => array(
        'title' => 'Visit settings',
        'lists' => array(
            'visit_type' => array(
                'title'      => 'Visit type',
                'type'       => 'radio',
                'require'    => 'true',
                'option' => array(
                    'default'   => array(
                        'value'    => 'Default',
                        'note'     => 'Example: {:visit_default}',
                    ),
                    'pstatic'   => array(
                        'value'    => 'Pseudo-static',
                        'note'     => 'Example: {:visit_pstatic}',
                    ),
                    'static'    => array(
                        'value'    => 'Static',
                        'note'     => 'Example: {:visit_static}',
                    ),
                ),
            ),
            'visit_file' => array(
                'title'     => 'Extension of web page',
                'type'      => 'select_input',
                'note'      => 'Select or type the extension name',
                'require'   => 'true',
                'option' => array(
                    'html'  => 'html',
                    'shtml' => 'shtml',
                ),
            ),
            'visit_pagecount' => array(
                'title'      => 'Page count of static page',
                'type'       => 'text',
                'format'     => 'int',
                'require'    => 'true',
                'note'       => 'Page count of generate static page, the remaining pages will be displayed via dynamic page',
            ),
            'count_associate' => array(
                'title'     => 'Count of associated articles',
                'type'      => 'text',
                'format'    => 'int',
                'require'   => 'true',
            ),
            'count_tag' => array(
                'title'     => 'Count of article tags',
                'type'      => 'text',
                'format'    => 'int',
                'require'   => 'true',
            ),
            'perpage_spec' => array(
                'title'     => 'Special topic count per page',
                'type'      => 'text',
                'format'    => 'int',
                'require'   => 'true',
            ),
            'perpage_in_spec' => array(
                'title'     => 'Article count per page in the special topic',
                'type'      => 'text',
                'format'    => 'int',
                'require'   => 'true',
            ),
            'perpage_in_cate' => array(
                'title'     => 'Article count per page in the category',
                'type'      => 'text',
                'format'    => 'int',
                'require'   => 'true',
            ),
            'perpage_in_tag' => array(
                'title'     => 'Article count per page in the tag',
                'type'      => 'text',
                'format'    => 'int',
                'require'   => 'true',
            ),
            'perpage_in_search' => array(
                'title'     => 'Article count per page in the search',
                'type'      => 'text',
                'format'    => 'int',
                'require'   => 'true',
            ),
            'perpage_in_ajax' => array(
                'title'     => 'Article count per page in the ajax search',
                'type'      => 'text',
                'format'    => 'int',
                'require'   => 'true',
            ),
            'perpage_in_api' => array(
                'title'     => 'Article count per page in the API',
                'type'      => 'text',
                'format'    => 'int',
                'require'   => 'true',
            ),
            'perpage_album' => array(
                'title'     => 'Album count per page',
                'type'      => 'text',
                'format'    => 'int',
                'require'   => 'true',
            ),
            'perpage_in_album' => array(
                'title'     => 'Image count per page in the album',
                'type'      => 'text',
                'format'    => 'int',
                'require'   => 'true',
            ),
        ),
    ),
    'sso' => array(
        'title' => 'SSO Settings',
        'lists' => array(
            'base_url' => array(
                'title'     => 'Base url',
                'type'      => 'str',
                'format'    => 'url',
                'require'   => 'true',
            ),
            'app_id' => array(
                'title'     => 'App ID',
                'type'      => 'str',
                'format'    => 'int',
                'require'   => 'true',
            ),
            'app_key' => array(
                'title'     => 'App Key',
                'type'      => 'str',
                'format'    => 'text',
                'require'   => 'true',
            ),
            'app_secret' => array(
                'title'     => 'App Secret',
                'type'      => 'str',
                'format'    => 'text',
                'require'   => 'true',
            ),
        ),
    ),
    'dbconfig' => array(
        'title' => 'Database settings',
    ),
    'chkver' => array(
        'title' => 'Check for updates',
    ),
);