<?php
return [
  'exception_handling' => [
    'value' => [
      'debug' => true,
      'log' => [
        'class_name' => 'Bex\Monolog\ExceptionHandlerLog',
        'settings' => ['logger' => 'default']
      ]
    ],
    'readonly' => false
  ],
  'monolog' => [
    'value' => [
      'handlers' => [
        'event_log' => [
          'class' => 'BitrixMonolog\Handler\EventLog',
          'level' => 'INFO'
        ],
        'debug_log' => [
          'class' => 'Monolog\Handler\StreamHandler',
          'level' => 'DEBUG',
          'stream' => $_SERVER['DOCUMENT_ROOT'].'/debug.log'
        ]
      ],
      'loggers' => [
        'default' => [
          'handlers' => ['event_log', 'debug_log']
        ]
      ]
    ],
    'readonly' => false
  ]
];