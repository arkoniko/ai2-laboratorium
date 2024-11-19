<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Weatherdata;

class MeasurementTest extends TestCase
{
    /**
     * Dostarcza dane do testu.
     *
     * @return array
     */
    public function dataGetFahrenheit(): array
    {
        return [
            [0, 32.0],         // 0°C -> 32°F
            [-100, -148.0],    // -100°C -> -148°F
            [100, 212.0],      // 100°C -> 212°F
            [0.5, 32.9],       // 0.5°C -> 32.9°F
            [-0.5, 31.1],      // -0.5°C -> 31.1°F
            [37, 98.6],        // 37°C -> 98.6°F (normalna temperatura ciała)
            [-40, -40.0],      // -40°C -> -40°F (jedyny punkt, gdzie C i F są równe)
            [20.3, 68.54],     // 20.3°C -> 68.54°F
            [15.6, 60.08],     // 15.6°C -> 60.08°F
            [50.5, 122.9],     // 50.5°C -> 122.9°F
        ];
    }

    /**
     * Testuje konwersję Celsjusza na Fahrenheita.
     *
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit($celsius, $expectedFahrenheit): void
    {
        $weatherData = new Weatherdata();
        $weatherData->setTemperatureCelsius($celsius);

        $this->assertEquals(
            $expectedFahrenheit,
            $weatherData->getFahrenheit(),
            sprintf('%f°C should be %f°F', $celsius, $expectedFahrenheit)
        );
    }
}
