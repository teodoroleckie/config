<?php

namespace Tleckie\Config;

/**
 * Class Config
 *
 * @package Tleckie\Config
 * @author  Teodoro Leckie Westberg <teodoroleckie@gmail.com>
 */
class Config implements ConfigInterface
{
    /** @var mixed[] */
    protected array $data;

    /**
     * Config constructor.
     *
     * @param mixed[] $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $this->check($data);
    }

    /**
     * @param string     $key
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->offsetGet($key) ?? $default;
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        if (!isset($this->data[$offset])) {
            return null;
        }

        if (is_array($this->data[$offset])) {
            return new Config($this->data[$offset]);
        }

        return $this->data[$offset];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return $this->offsetExists($key);
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    /**
     * @param string $key
     * @param mixed  $value
     * @return ConfigInterface
     */
    public function set(string $key, mixed $value): ConfigInterface
    {
        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->data[$offset] = $value;
    }

    /**
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * @return array[]
     */
    public function toArray(): array
    {
        return json_decode(
            json_encode($this->data),
            true
        );
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function __get(string $key): mixed
    {
        return $this->offsetGet($key);
    }

    /**
     * @param string $key
     * @param mixed  $value
     */
    public function __set(string $key, mixed $value): void
    {
        $this->offsetSet($key, $value);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset(string $name): bool
    {
        return $this->offsetExists($name);
    }

    /**
     * @param string $name
     */
    public function __unset(string $name): void
    {
        $this->offsetUnset($name);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    /**
     * @param array|ConfigInterface $config
     * @return ConfigInterface
     */
    public function merge(array|ConfigInterface $config): ConfigInterface
    {
        $data = $config;
        if($config instanceof ConfigInterface){
            $data = $config->toArray();
        }

        $data = $this->check($data);
        $this->data = array_merge($this->data, $data);

        return $this;
    }

    /**
     * @param array $data
     * @return array
     */
    private function check(array $data): array
    {
        array_walk($data, static function (&$item) {
            $item = is_array($item) ? new Config($item) : $item;
        });

        return $data;
    }
}
