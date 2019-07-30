<?php
return [
    'template' => [
        'header' => TEMPLATE_PATH . 'header.php',
        'nav' => TEMPLATE_PATH . 'nav.php',
        'wrapper_start' => TEMPLATE_PATH . 'wrapperstart.php',
        ':view' => ':action_view',
        'wrapper_end' => TEMPLATE_PATH . 'wrapperend.php',
    ],
    'header_resources' => [
        'css' => [
            'bootstrap' => CSS . 'bootstrap.min.css',
            'fawsome' => CSS . 'all.css',
            'main' => CSS . 'style.css',
        ],
        'js' => [
            'jquery' => JS . 'jquery.min.js',
            'ckeditor' => JS . 'ckeditor/ckeditor.js',
            'ckeditork' => JS . 'ckeditor/adapters/jquery.js',
            'bootstrap.min.js' => JS . 'bootstrap.min.js',



        ],
    ],
    'footer_resources' => [
        'helper' => JS . 'helper.js',
        'datatables' => JS . 'datatables' . $_SESSION['lang'] . '.js',
        'main' => JS . 'main.js'

    ]
];

