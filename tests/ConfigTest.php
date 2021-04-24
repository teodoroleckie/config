<?php

namespace Tleckie\Config\Tests;

use PHPUnit\Framework\TestCase;
use Tleckie\Config\Config;

class ConfigTest extends TestCase
{
    /** @var Config */
    private Config $config;

    private array $data = [
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

    private array $moreData = [
        'other' => [
            'width' => 300,
            'height' => 120
        ]
    ];

    public function setUp(): void
    {
        $this->config = new Config($this->data);
    }

    /**
     * @test
     */
    public function get(): void
    {
        static::assertEquals('Pedro', $this->config->get('user')->friend->get('friend')->name);
        static::assertEquals('Mario', $this->config->get('user')->friend->name);
    }

    /**
     * @test
     */
    public function getDefault(): void
    {
        static::assertEquals('default', $this->config->get('user')->friend->get('friend', 'other-value')->get('NOT-EXIST', 'default'));
    }

    /**
     * @test
     */
    public function has(): void
    {
        static::assertTrue($this->config->get('user')->friend->get('friend')->has('name'));
        static::assertFalse($this->config->get('user')->friend->get('friend')->has('NOT-EXIST'));
    }

    /**
     * @test
     */
    public function set(): void
    {
        static::assertEquals('800x900', $this->config->size);
        $this->config->set('newValue', $this->moreData);
        static::assertEquals(300, $this->config->newValue->other->width);
    }

    /**
     * @test
     */
    public function jsonSerialize(): void
    {
        static::assertEquals($this->data, $this->config->jsonSerialize());
    }

    /**
     * @test
     */
    public function values(): void
    {
        static::assertEquals('800x900', $this->config->size);
        $this->config->newValue = $this->moreData;

        static::assertEquals(300, $this->config->newValue->other->width);

        static::assertTrue(isset($this->config->newValue->other->width));

        unset($this->config->user->name);

        static::assertNull($this->config->user->name);
    }

    /**
     * @test
     */
    public function merge(): void
    {
        $expected = array_merge($this->data, $this->moreData);

        static::assertEquals($expected, $this->config->merge($this->moreData)->toArray());
        static::assertEquals($expected, $this->config->merge(new Config($this->moreData))->toArray());
    }
}
