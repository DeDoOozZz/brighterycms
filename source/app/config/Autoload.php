<?php

return [

    'libraries' => ['Database', 'Permissions', 'Menu', 'Assets', 'Settings', 'Module', 'Crud'],

    'helpers' => [],

    'language' => ['global'],

    'assets' => [
        'management' => [
            'js' => [
                [
                    'storage' => 'local',
                    'file' => 'jquery-1.11.1.min.js'
                ],
                [
                    'storage' => 'local',
                    'file' => 'deleteMsg/deleteMsg.js'
                ],
                [
                    'storage' => 'local',
                    'file' => 'addResumeMsg/addResumeMsg.js'
                ],
//                array(
//                    'storage' => 'local',
//                    'file' => 'validationEngine/jquery.validationEngine-en.js'
//                ),
//                array(
//                    'storage' => 'local',
//                    'file' => 'validationEngine/jquery.validationEngine.js'
//                ),
                [
                    'storage' => 'local',
                    'file' => 'datepicker/bootstrap-datepicker.js'
                ],
                [
                    'storage' => 'local',
                    'file' => 'select2/select2.min.js'
                ],
                [
                    'storage' => 'local',
                    'file' => 'timepicker/bootstrap-timepicker.min.js'
                ],
                [
                    'storage' => 'local',
                    'file' => 'toastr/toastr.min.js'
                ]
            ],
            'css' => [
                [
                    'storage' => 'local',
                    'file' => 'fonts/linecons/css/linecons.css'
                ],
                [
                    'storage' => 'local',
                    'file' => 'fonts/fontawesome/css/font-awesome.min.css'
                ],
                [
                    'storage' => 'local',
                    'file' => 'bootstrap.css'
                ],
                [
                    'storage' => 'local',
                    'file' => 'xenon-core.css'
                ],
                [
                    'storage' => 'local',
                    'file' => 'xenon-forms.css'
                ],
                [
                    'storage' => 'local',
                    'file' => 'xenon-components.css'
                ],
                [
                    'storage' => 'local',
                    'file' => 'xenon-skins.css'
                ],
                [
                    'storage' => 'local',
                    'file' => 'custom.css'
                ],
                [
                    'storage' => 'local',
                    'file' => 'newstyle.css'
                ],
                [
                    'storage' => 'local',
                    'file' => 'select2/select2.css'
                ],
                [
                    'storage' => 'local',
                    'file' => 'select2/select2-bootstrap.css'
                ],
                [
                    'storage' => 'local',
                    'file' => 'multiselect/css/multi-select.css'
                ],
                [
                    'storage' => 'local',
                    'file' => 'file_upload/css/jquery.fileupload.css'
                ],
                [
                    'storage' => 'local',
                    'file' => 'file_upload/css/jquery.fileupload-ui.css'
                ],
            ],
        ],
    ]
];
