<?php

namespace App\Tests\Entity;

use App\Entity\Weather;
use PHPUnit\Framework\TestCase;

class WeatherTest extends TestCase
{
//    public function testTempToFahrenheit(): void
//    {
//        $weather = new Weather();
//        $value = $weather->tempToFahrenheit(20);
//        $this->assertSame(68.0, $value);
//    }


    /**
     * @dataProvider provideTempToFahrenheitData
     */
    public function testTempToFahrenheitDataProvider($expectedResult, $input): void
    {
        self::assertSame($expectedResult, $input);
    }

    public function provideTempToFahrenheitData(): array
    {
        $weather = new Weather();

        return [
            [68.0, $weather->tempToFahrenheit(20)],
            [50.0, $weather->tempToFahrenheit(10.0)],
            [32.0, $weather->tempToFahrenheit(0)],
            [32.0, $weather->tempToFahrenheit(null)],
            [14.0, $weather->tempToFahrenheit(-10)],
            [-4.0, $weather->tempToFahrenheit(-20)],
            [0.0, $weather->tempToFahrenheit(-17.8)],
        ];
    }
}
