# Config PHP

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tleckie/config.svg?style=flat-square)](https://packagist.org/packages/tleckie/config)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/teodoroleckie/config/badges/quality-score.png?b=main)](https://scrutinizer-ci.com/g/teodoroleckie/config/?branch=main)
[![Total Downloads](https://img.shields.io/packagist/dt/tleckie/config.svg?style=flat-square)](https://packagist.org/packages/tleckie/config)
[![Code Intelligence Status](https://scrutinizer-ci.com/g/teodoroleckie/config/badges/code-intelligence.svg?b=main)](https://scrutinizer-ci.com/code-intelligence)
[![Build Status](https://scrutinizer-ci.com/g/teodoroleckie/config/badges/build.png?b=main)](https://scrutinizer-ci.com/g/teodoroleckie/config/build-status/main)

## Installation

You can install the package via composer:

```bash
composer require tleckie/config
```

## Usage

```php
<?php

use Tleckie\Config\Config;

$data = [
    'user' => [
        'name' => 'John',
        'age' => 38,
        'friend' => [
            'name' => 'Mario',
            'age' => 25,
            'friend' => [
                'name' => 'Pedro',
                'age' => 48,
            ]
        ]
    ],
    'size' => '800x900'
];
$config = new Config($data);

var_dump($config->get('user')->get('friend')->get('friend')->get('name'));
var_dump($config->user->friend->friend->name);

$config->merge(['name' => 'Pedro']);
$config->merge(new Config(['name' => 'Pedro']));

```