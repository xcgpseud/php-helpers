<?php

namespace Tests\ArrTests;

use Helpers\Iterable\Arr;
use PHPUnit\Framework\TestCase;

final class FlattenTest extends TestCase
{
    public function testFlattenWithRetainKeys(): void
    {
        // Arrange
        $input = [
            2 => [
                2 => 1, 4 => 2,
            ],
            4 => [
                6 => 3, 8 => 4,
            ],
        ];
        $expected = [
            2 => 1,
            4 => 2,
            6 => 3,
            8 => 4,
        ];

        // Act
        $output = Arr::with($input)->flatten(true)->getArray();

        // Assert
        $this->assertEquals($expected, $output);
    }

    public function testFlattenWithoutRetainKeys(): void
    {
        // Arrange
        $input = [
            [
                1, 2, 3, 4,
            ], [
                5, 6, 7, 8,
            ], [
                9,
            ], [
                10,
            ]
        ];
        $expected = [
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
        ];

        // Act
        $output = Arr::with($input)->flatten(false)->getArray();

        // Assert
        $this->assertEquals($expected, $output);
    }
}