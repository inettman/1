<?php

namespace Location\PlaceBundle;

class Coordinate
{
    public function getDistance($begin, $end, $unit = false, $round = 0)
    {   
        $result = round(2 * asin(sqrt( pow(sin(deg2rad( ($begin['lat']-$end['lat']) / 2)), 2) + cos(deg2rad($begin['lat'])) * cos(deg2rad($end['lat'])) * pow(sin(deg2rad(($begin['lng']- $end['lng']) / 2)), 2))) * 6378245);
        if($unit == 'km'){
           $result = round($result/1000, $round);
        }
        return $result;
    }
    
    public function getWeather($lat, $lng, $lang)
    {   
        $result = array();
        $api_key = 'eef557a0a4fbb5cc7602fd24d2e8f5f9';
        //$wind_short_names = array("N","NNE","NE","ENE","E","ESE", "SE", "SSE","S","SSW","SW","WSW","W","WNW","NW","NNW");
        
        $current = json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/weather?lat='.$lat.'&lon='.$lng.'&units=metric&lang='.$lang.'&APPID='.$api_key), TRUE);
        
        if (empty($current['main']['temp'])){
            $result['current']['temp'] = '...';
        } else {
            $result['current']['temp'] = round($current['main']['temp']);
        }
 
        $result['current']['description'] = $current['weather'][0]['description'];
        $result['current']['icon'] = 'http://openweathermap.org/img/w/'.$current['weather'][0]['icon'].'.png';
        $result['current']['date'] = $current['dt'];
        $result['current']['pressure'] = $current['main']['pressure'];
        $result['current']['humidity'] = $current['main']['humidity'];
        $result['current']['wind_deg'] = $current['wind']['deg'];
        $result['current']['wind_speed'] = $current['wind']['speed'];
        $result['current']['wind_side'] = round(($current['wind']['deg'] -11.25) / 22.5);

        $hourly = json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/forecast?lat='.$lat.'&lon='.$lng.'&units=metric&lang='.$lang.'&APPID='.$api_key.'&cnt=8'), TRUE);

        foreach ($hourly['list'] as $key => $item) {
            $result['hourly'][$key]['temp'] = round($item['main']['temp']);
            $result['hourly'][$key]['description'] = $item['weather'][0]['description'];
            $result['hourly'][$key]['icon'] = 'http://openweathermap.org/img/w/'.$item['weather'][0]['icon'].'.png';
            $result['hourly'][$key]['date'] = $item['dt'];
            $result['hourly'][$key]['pressure'] = $item['main']['pressure'];
            $result['hourly'][$key]['humidity'] = $item['main']['humidity'];
            $result['hourly'][$key]['wind_deg'] = $item['wind']['deg'];
            $result['hourly'][$key]['wind_speed'] = $item['wind']['speed'];
            $result['hourly'][$key]['wind_side'] = round(($item['wind']['deg'] -11.25) / 22.5);
        }

        //$result['daily'] = json_decode(file_get_contents('http://api.openweathermap.org/data/2.5/forecast/daily?lat=35&lon=139&cnt=16&mode=json&lat='.$lat.'&lon='.$lng.'&units=metric&lang='.$lang.'&APPID='.$api_key), TRUE);
        
        $result['key'] = $api_key;
        
        return $result;
    }

}
