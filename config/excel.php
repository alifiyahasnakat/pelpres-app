<?php

return [
    'exports' => [
        'chunk_size'             => 1000,
        'precalculate_formulas'  => false,
        'strict_null_comparison' => false,
        'csv'                    => [
            'delimiter'              => ',',
            'enclosure'              => '"',
            'line_ending'            => "\n",
            'use_bom'                => false,
            'include_separator_line' => false,
            'excel_compatibility'    => false,
        ],
        'properties' => [
            'creator'        => '',
            'lastModifiedBy' => '',
            'title'          => '',
            'description'    => '',
            'subject'        => '',
            'keywords'       => '',
            'category'       => '',
            'manager'        => '',
            'company'        => '',
        ],
    ],

    'imports'            => [
        'read_only' => true,
        'heading'   => 'slugged',
        'csv'       => [
            'delimiter'        => ',',
            'enclosure'        => '"',
            'escape_character' => '\\',
            'contiguous'       => false,
            'input_encoding'   => 'UTF-8',
        ],
        'properties' => [
            'creator'        => '',
            'lastModifiedBy' => '',
            'title'          => '',
            'description'    => '',
            'subject'        => '',
            'keywords'       => '',
            'category'       => '',
            'manager'        => '',
            'company'        => '',
        ],
    ],

    'extension_detector' => [
        'xlsx'     => 'Xlsx',
        'xlsm'     => 'Xlsx',
        'xltx'     => 'Xlsx',
        'xltm'     => 'Xlsx',
        'xls'      => 'Xls',
        'xlt'      => 'Xls',
        'ods'      => 'Ods',
        'ots'      => 'Ods',
        'slk'      => 'Slk',
        'xml'      => 'Xml',
        'gnumeric' => 'Gnumeric',
        'htm'      => 'Html',
        'html'     => 'Html',
        'csv'      => 'Csv',
        'tsv'      => 'Csv',
    ],

    'value_binder' => [
        'default' => Maatwebsite\Excel\DefaultValueBinder::class,
    ],

    'cache' => [
        'driver'     => 'memory',
        'batch'      => [
            'memory_limit' => 60000,
        ],
    ],

    'temporary_files' => [
        'local_path'          => storage_path('framework/laravel-excel'),
        'remote_disk'         => null,
        'remote_prefix'       => null,
        'force_resync_remote' => null,
    ],
];
