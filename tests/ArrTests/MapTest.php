<?php

namespace Tests\ArrTests;

use Helpers\Iterable\Arr;
use PHPUnit\Framework\TestCase;

final class MapTest extends TestCase
{
    public function testMapWithRetainKeys(): void
    {
        // Arrange
        $input = [
            4 => 1, 8 => 2,
        ];
        $expected = [
            4 => 2, 8 => 4,
        ];

        // Act
        $output = Arr::with($input)->map(function ($value) {
            return $value * 2;
        }, true)->getArray();

        // Assert
        $this->assertEquals($expected, $output);
    }

    public function testMapWithoutRetainKeys(): void
    {
        // Arrange
        $input = [
            4 => 1, 8 => 2,
        ];
        $expected = [
            0 => 2, 1 => 4,
        ];

        // Act
        $output = Arr::with($input)->map(function ($value) {
            return $value * 2;
        }, false)->getArray();

        // Assert
        $this->assertEquals($expected, $output);
    }

    public function testMapRecursiveWithRetainKeys(): void
    {
        // Arrange
        $input = [
            4 => [
                4 => 1, 8 => 2,
            ],
            8 => [
                2 => 3, 3 => 4,
            ],
        ];
        $expected = [
            4 => [
                4 => 2, 8 => 4,
            ],
            8 => [
                2 => 6, 3 => 8,
            ],
        ];

        // Act
        $output = Arr::with($input)->mapRecursive(function ($value) {
            return $value * 2;
        }, true)->getArray();

        // Assert
        $this->assertEquals($expected, $output);
    }

    public function testMapRecursiveWithoutRetainKeys(): void
    {
        // Arrange
        $input = [
            4 => [
                4 => 1, 8 => 2,
            ],
            8 => [
                2 => 3, 3 => 4,
            ],
        ];
        $expected = [
            0 => [
                0 => 2, 1 => 4,
            ],
            1 => [
                0 => 6, 1 => 8,
            ],
        ];

        // Act
        $output = Arr::with($input)->mapRecursive(function ($value) {
            return $value * 2;
        }, false)->getArray();

        // Assert
        $this->assertEquals($expected, $output);
    }
}