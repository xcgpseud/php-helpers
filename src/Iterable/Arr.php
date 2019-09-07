<?php

namespace Helpers\Iterable;

class Arr
{
    /** @var array */
    private $array;

    /**
     * Arr constructor.
     * @param array $array
     */
    private function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * @param array $array
     * @return Arr
     */
    public static function with(array $array): self
    {
        return new self($array);
    }

    /**
     * @return array
     */
    public function getArray(): array
    {
        return $this->array;
    }

    /**
     * Run the callable on each value of the array (not recursive)
     *
     * @param callable $callback
     * @param bool $retainKeys Keep the same keys
     * @return Arr
     */
    public function map(callable $callback, bool $retainKeys = true)
    {
        $output = array_map($callback, $this->array);
        return $retainKeys ? self::with($output) : self::with(array_values($output));
    }

    /**
     * Run the callback on each value of the array (recursively)
     *
     * @param callable $callback
     * @param bool $retainKeys
     * @return Arr
     */
    public function mapRecursive(callable $callback, bool $retainKeys = true): self
    {
        $output = [];
        foreach ($this->array as $key => $value) {
            $toAdd = is_array($value)
                ? self::with($value)->map($callback, $retainKeys)->getArray()
                : call_user_func($callback, $value);

            if ($retainKeys) {
                $output[$key] = $toAdd;
            } else {
                $output[] = $toAdd;
            }
        }
        return self::with($output);
    }
}