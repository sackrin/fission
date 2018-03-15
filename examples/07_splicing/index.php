<?php

/**
 * 07. NUCLEUS SPLICING
 */

use Fission\Hydrate\Reactor;
use Fission\Import\ArrayImport;
use Fission\Schema\Sanitizer\GUMPSanitizer;
use Fission\Schema\Validator\GUMPValidator;
use Fission\Support\Press;
use Fission\Walker\Splice;
use Fission\Walker\Validator;
use Fission\Walker\Values;

include('../../vendor/autoload.php');

$import = [
    'machine' => 'person',
    'roles' => ['guest','owner','administrator','user'],
    'scope' => ['r','w'],
    'nuclei' => [
        [
            'machine' => 'first_name',
            'label' => 'First Name',
            'type' => 'string',
            'formatters' => [
                ['type' => 'default', 'options' => 'string']
            ],
            'sanitizers' => [
                ['type' => 'default', 'options' => 'trim|sanitize_string']
            ],
            'validators' => [
                ['type' => 'default', 'options' => 'required|min_len,5']
            ],
            'policies' => [
                'type' => 'default',
                'items' => [
                    ['type' => 'deny', 'for' => '*', 'scope' => 'r,w'],
                    ['type' => 'allow', 'for' => ['administrator','owner'], 'scope' => 'r,w'],
                    ['type' => 'allow', 'for' => 'user', 'scope' => 'r'],
                ]
            ]
        ],
        [
            'machine' => 'last_name',
            'label' => 'Last Name',
            'type' => 'string',
            'formatters' => [
                ['type' => 'default', 'options' => 'string']
            ],
            'sanitizers' => [
                ['type' => 'default', 'options' => 'trim|sanitize_string']
            ],
            'validators' => [
                ['type' => 'default', 'options' => 'required|min_len,5']
            ],
            'policies' => [
                'type' => 'default',
                'items' => [
                    ['type' => 'deny', 'for' => '*', 'scope' => 'r,w'],
                    ['type' => 'allow', 'for' => ['administrator','owner'], 'scope' => 'r,w'],
                    ['type' => 'allow', 'for' => 'user', 'scope' => 'r'],
                ]
            ]
        ],
        [
            'machine' => 'emails',
            'label' => 'Email Addresses',
            'type' => 'collection',
            'policies' => [
                ['type' => 'deny', 'for' => '*', 'scope' => 'r,w'],
                ['type' => 'allow', 'for' => 'user', 'scope' => 'r,w'],
            ],
            'nuclei' => [
                [
                    'machine' => 'label',
                    'label' => 'Label',
                    'type' => 'string',
                    'formatters' => [
                        ['type' => 'default', 'options' => 'string']
                    ],
                    'sanitizers' => [
                        ['type' => 'default', 'options' => 'trim|sanitize_string']
                    ],
                    'validators' => [
                        ['type' => 'default', 'options' => 'required|min_len,5']
                    ],
                    'policies' => [
                        'type' => 'default',
                        'items' => [
                            ['type' => 'deny', 'for' => '*', 'scope' => 'r,w'],
                            ['type' => 'allow', 'for' => ['administrator','owner'], 'scope' => 'r,w'],
                            ['type' => 'allow', 'for' => 'user', 'scope' => 'r'],
                        ]
                    ]
                ],
                [
                    'machine' => 'address',
                    'label' => 'Address',
                    'type' => 'string',
                    'formatters' => [
                        ['type' => 'default', 'options' => 'string']
                    ],

                    'sanitizers' => [
                        ['type' => 'default', 'options' => 'trim|sanitize_email']
                    ],
                    'validators' => [
                        ['type' => 'default', 'options' => 'required|valid_email']
                    ],
                    'policies' => [
                        'type' => 'default',
                        'items' => [
                            ['type' => 'deny', 'for' => '*', 'scope' => 'r,w'],
                            ['type' => 'allow', 'for' => ['administrator','owner'], 'scope' => 'r,w'],
                            ['type' => 'allow', 'for' => 'user', 'scope' => 'r'],
                        ]
                    ]
                ]
            ]
        ]
    ]
];

$atom = ArrayImport::from($import);

Splice::using($atom)->merge('sanitizers', [
    GUMPSanitizer::using('ms_word_characters')
])->at('first_name');

Splice::using($atom)->merge('sanitizers', [
    GUMPSanitizer::using('ms_word_characters')
])->and('validators', [
    GUMPValidator::against('valid_name')
])->at('last_name');

Splice::using($atom)->merge('validators', [
    GUMPValidator::against('max_len,255')
])->at('emails.label');

$isotopes = Reactor::using($atom)
    ->roles(['guest','owner', 'user'])
    ->scope(['w'])
    ->with(Press::values([
        'first_name' => ' Johnny ',
        'last_name' => 'Smithy',
        'emails' => [
            [
                'label' => 'primary',
                'address' => 'johnny@example.com'
            ],
            [
                'label' => 'backup',
                'address' => 'johnny.smithy@example.com'
            ]
        ]
    ]));

$validator = Validator::validate($isotopes);

if ($validator->hasErrors()) {
    echo "Oh No, Failed Validation!";
    $errors = $validator->errors();
    var_dump($errors);
} else {
    echo "Everything Validated!";
    $values = Values::gather($isotopes)->all();
    var_dump($values);
}
