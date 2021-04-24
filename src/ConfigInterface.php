<?php

namespace Tleckie\Config;

use ArrayAccess;
use JsonSerializable;

/**
 * Interface ConfigInterface
 *
 * @package Tleckie\Config
 * @author  Teodoro Leckie Westberg <teodoroleckie@gmail.com>
 */
interface ConfigInterface extends ArrayAccess, JsonSerializable
{
    /**
     * @param string     $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed;

    /**
     * @param string $key
     * @param mixed  $value
     * @return ConfigInterface
     */
    public function set(string $key, mixed $value): ConfigInterface;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * @return array
     */
    public function jsonSerialize(): array;

    /**
     * @param string $key
     * @return mixed
     */
    public function __get(string $key): mixed;

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function __set(string $key, mixed $value): void;

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool;

    /**
     * @param string $name
     */
    public function __unset(string $name): void;

    /**
     * @param array|ConfigInterface $config
     * @return ConfigInterface
     */
    public function merge(array|ConfigInterface $config): ConfigInterface;

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool;

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed;

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet(mixed $offset, mixed $value): void;

    /**
     * @param mixed $offset
     */
    public function offsetUnset(mixed $offset): void;
}
