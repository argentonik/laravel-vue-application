<?php

namespace App\Components;

class Formatting
{
    public static function formatDate($date)
    {
        return $date->format('H:i d/m/y');
    }

    public static function formatDescriptionLength($description)
    {
        $cutDescription = mb_substr($description, 0, 255);
        $cutDescription = mb_strlen($description) > 255 ? $cutDescription . '...' : $cutDescription;
        return $cutDescription;
    }

    public static function formatImagePath($image)
    {
        return $image ? '/storage/images/' . $image : '/storage/images/default.png';
    }

}