<?php
require(__DIR__ . "/../vendor/autoload.php");
require(__DIR__ . "/../utils/arrayFunctions.php");

use PHPUnit\Framework\TestCase;

class ArrayTests extends TestCase
{
    private array $singleDimensionArray = ['a', 4, 7, 100, 'ty', 17];
    private array $twoDimensionsArray = [
        ['k1' => 'v1',],
        ['k2' => 'v2',],
        ['k3' => 'v3',],
    ];
    public function test_it_filters_a_single_dimension_array()
    {

        $expectedArray = ['a', 'ty'];
        $decision = function ($item): bool {
            return is_string($item);
        };
        $this->assertSame(
            $expectedArray,
            filter($this->singleDimensionArray, $decision)
        );
    }
    public function test_it_filters_a_two_dimensions_array()
    {
        $expectedArray = [['k1' => 'v1']];
        $decision = function ($item): bool {
            if (isset($item['k1'])) {
                return $item['k1'] === 'v1';
            };
            return false;
        };
        $this->assertSame(
            $expectedArray,
            filter($this->twoDimensionsArray, $decision)
        );
    }
}
