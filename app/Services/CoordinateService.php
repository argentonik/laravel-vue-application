<?php

namespace App\Services;

use App\Models\Bulletin;
use App\Models\Coordinate;

class CoordinateService
{
    public function store($data)
    {
        if ($data['latitude'] && $data['longitude']) {
            Coordinate::create($data);
        }
    }

    public function update($bulletinId, $data)
    {
        if ($data['latitude'] && $data['longitude']) {
            $data['bulletin_id'] = $bulletinId;

            $oldVersionBulletin = Bulletin::with('coordinate')->find($bulletinId);

            if ($oldVersionBulletin->coordinate) {
                Coordinate::find($oldVersionBulletin->coordinate->id)->update($data);
            } else {
                Coordinate::create($data);
            }           
        }
    }
}