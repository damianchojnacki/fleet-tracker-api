<?php

namespace Tests\Feature\Models;

use App\Models\TripPoint;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\DocsController
 */
class TripPointTest extends TestCase
{
    public function testCalculatesDistanceBetweenTwoPoints(): void
    {
        $from = new TripPoint([
            'lat' => 52.2327,
            'lng' => 21.0141,
        ]);

        $to = new TripPoint([
            'lat' => 53.1222,
            'lng' => 17.9945,
        ]);

        $distance = $from->getDistanceTo($to);

        $this->assertEquals(226.3, round($distance, 1));

        $distance = $to->getDistanceTo($from);

        $this->assertEquals(226.3, round($distance, 1));
    }
}
