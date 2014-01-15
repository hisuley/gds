<?php
error_reporting(0);
//定义本系统的相对路径根部
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}
function translateAirline($code)
{
    $xml = simplexml_load_file(ABSPATH . 'static/airline.xml');
    $matches = $xml->xpath('//AirlineInfoEntity[AirLine="' . $code . '"]');
    return (string)$matches[0]->ShortName;
}

function translateAirport($code)
{
    $xml = simplexml_load_file(ABSPATH . 'static/airport.xml');
    $matches = $xml->xpath('//AirportInfoEntity[AirPort="' . $code . '"]');
    return (string)$matches[0]->AirPortName;
}

function translateCity($code)
{
    $xml = simplexml_load_file(ABSPATH . 'static/city.xml');
    $matches = $xml->xpath('//CityDetail[CityCode="' . $code . '"]');
    return (string)$matches[0]->CityName;
}

function findCity($name)
{
    $xml = simplexml_load_file(ABSPATH . 'static/city.xml');
    $matches = $xml->xpath('//CityDetail[CityName="' . $name . '"]');
    return (string)$matches[0]->CityCode;
}

function translateCraft($code)
{
    $xml = simplexml_load_file(ABSPATH . 'static/craft.xml');
    $matches = $xml->xpath('//CraftInfoEntity[CraftType="' . $code . '"]');
    if (isset($matches[0]))
        return (string)$matches[0]->CTName;
    else
        return $code;
}

function translateClass($code)
{
    switch ($code) {
        case 'Y':
            $result = '经济舱';
            break;
        case 'F':
            $result = '头等舱';
            break;
        default:
            $result = '经济舱';
            break;
    }
    return $result;
}

?>