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
     * Run the callable on each value of the array (not recursive).
     *
     * @param callable $callback
     * @param bool $retainKeys Keep the same keys
     * @return Arr
     */
    public function map(callable $callback, bool $retainKeys = true): self
    {
        $output = array_map($callback, $this->array);
        return $retainKeys ? self::with($output) : self::with(array_values($output));
    }

    /**
     * Run the callback on each value of the array (recursively).
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
                ? self::with($value)->mapRecursive($callback, $retainKeys)->getArray()
                : call_user_func($callback, $value);

            if ($retainKeys) {
                $output[$key] = $toAdd;
            } else {
                $output[] = $toAdd;
            }
        }
        return self::with($output);
    }

    /**
     * Get only the values which return true with the callback (not recursive).
     *
     * @param callable $callback
     * @param bool $retainKeys
     * @return Arr
     */
    public function filter(callable $callback, bool $retainKeys = true): self
    {
        $output = array_filter($this->array, $callback);
        return $retainKeys ? self::with($output) : self::with(array_values($output));
    }

    /**
     * Get only the values which return true within the callback. This is recursive, filtering on sub-arrays.
     *
     * @param callable $callback
     * @param bool $retainKeys
     * @return Arr
     */
    public function filterRecursive(callable $callback, bool $retainKeys = true): self
    {
        $output = [];

        foreach ($this->array as $key => $value) {
            if (is_array($value)) {
                $output[$key] = self::with($value)->filterRecursive($callback, $retainKeys)->getArray();
            } else {
                if (call_user_func($callback, $value) === true) {
                    $output[$key] = $value;
                }
            }
        }

        return $retainKeys ? self::with($output) : self::with(array_values($output));
    }

    /**
     * Flatten an array
     *
     * @param bool $retainKeys
     * @return Arr
     */
    public function flatten(bool $retainKeys = false): self
    {
        $output = [];

        return self::with($this->flattenArray($this->array, $output, $retainKeys));
    }

    private function flattenArray(array $input, array $output, bool $retainKeys): array
    {
        foreach ($input as $key => $value) {
            if (is_array($value)) {
                $output = self::flattenArray($value, $output, $retainKeys);
            } else {
                if ($retainKeys) {
                    $output[$key] = $value;
                } else {
                    $output[] = $value;
                }
            }
        }
        return $output;
    }
}