<?php

namespace Tests\ArrTests;

use Helpers\Iterable\Arr;
use PHPUnit\Framework\TestCase;

final class FilterTest extends TestCase
{
    public function testFilterWithRetainKeys(): void
    {
        // Arrange
        $input = [
            4 => 1, 8 => 2,
        ];
        $expected = [
            8 => 2,
        ];

        // Act
        $output = Arr::with($input)->filter(function ($value) {
            return $value % 2 == 0;
        }, true)->getArray();

        // Assert
        $this->assertEquals($expected, $output);
    }

    public function testFilterWithoutRetainKeys(): void
    {
        // Arrange
        $input = [
            4 => 1, 8 => 2,
        ];
        $expected = [
            0 => 2,
        ];

        // Act
        $output = Arr::with($input)->filter(function ($value) {
            return $value % 2 == 0;
        }, false)->getArray();

        // Assert
        $this->assertEquals($expected, $output);
    }

    public function testFilterRecursiveWithRetainKeys(): void
    {
        // Arrange
        $input = [
            4 => [
                4 => [
                    4 => 1, 8 => 2,
                ],
                8 => [
                    4 => 3, 8 => 4,
                ],
            ],
            8 => [
                8 => [
                    8 => 2, 4 => 1,
                ],
            ],
        ];
        $expected = [
            4 => [
                4 => [
                    8 => 2,
                ],
                8 => [
                    8 => 4,
                ],
            ],
            8 => [
                8 => [
                    8 => 2,
                ],
            ],
        ];

        // Act
        $output = Arr::with($input)->filterRecursive(function ($value) {
            return $value % 2 == 0;
        }, true)->getArray();

        // Assert
        $this->assertEquals($expected, $output);
    }

    public function testFilterRecursiveWithoutRetainKeys(): void
    {
        // Arrange
        $input = [
            4 => [
                4 => [
                    4 => 1, 8 => 2,
                ],
                8 => [
                    4 => 3, 8 => 4,
                ],
            ],
            8 => [
                8 => [
                    8 => 2, 4 => 1,
                ],
            ],
        ];
        $expected = [
            0 => [
                0 => [
                    0 => 2,
                ],
                1 => [
                    0 => 4,
                ],
            ],
            1 => [
                0 => [
                    0 => 2,
                ],
            ],
        ];

        // Act
        $output = Arr::with($input)->filterRecursive(function ($value) {
            return $value % 2 == 0;
        }, false)->getArray();

        // Assert
        $this->assertEquals($expected, $output);
    }
}