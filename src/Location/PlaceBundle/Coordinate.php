<?php

namespace Location\PlaceBundle;

class Coordinate
{
    public function getDistance($begin, $end, $unit = false)
    {   
        $result = round(2 * asin(sqrt( pow(sin(deg2rad( ($begin['lat']-$end['lat']) / 2)), 2) + cos(deg2rad($begin['lat'])) * cos(deg2rad($end['lat'])) * pow(sin(deg2rad(($begin['lng']- $end['lng']) / 2)), 2))) * 6378245);
        if($unit == 'km'){
           $result = round($result/1000, 1);
        }
        return $result;
    }

}
