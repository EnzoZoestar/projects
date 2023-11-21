<?php

require "index.phtml";

class Utils
{
    public static function getRandomColor()
    {
        $red = mt_rand(0, 255);
        $green = mt_rand(0, 255);
        $blue = mt_rand(0, 255);


        $hexRed = str_pad(dechex($red), 2, '0', STR_PAD_LEFT);
        $hexGreen = str_pad(dechex($green), 2, '0', STR_PAD_LEFT);
        $hexBlue = str_pad(dechex($blue), 2, '0', STR_PAD_LEFT);
        $hexColor = '#' . $hexRed . $hexGreen . $hexBlue;

        return $hexColor;
    }
}

class Avatar
{
    public $size;
    public $ColorArray;

    public function __construct()
    {
        $this->ColorArray = [];
    }

    public function setSize($size = 6)
    {
        return $this->size = $size;
    }

    public function defineColors($numColors = 4)
    {


        for ($index = 0; $index < $numColors; $index++) {
            $utils = new Utils();
            $color = $utils::getRandomColor();

            array_push($this->ColorArray, $color);
        }
    }

    public function getRandom()
    {
        $length = count($this->ColorArray);

        // var_dump($length);

        $randomIndex = mt_rand(0, $length - 1);

        return $this->ColorArray[$randomIndex];
    }
}
$avatar = new Avatar();

if (
    isset($_GET["size"]) && !empty($_GET["size"])
    && isset($_GET["colors"]) && !empty($_GET["colors"])
) {
    $size = $avatar->setSize($_GET["size"]);
    $avatar->defineColors($_GET["colors"]);
} else {
    $size = $avatar->setSize();
    $avatar->defineColors();
}

$matrix = new Matrix();
// var_dump($matrix->generateMatrix($size, $avatar));

class Matrix
{
    public $matrice = [];

    public function generateMatrix($size, $avatar)
    {
        for ($row = 0; $row < $size; $row++) {
            $this->matrice[$row] = [];
            for ($col = 0; $col < $size / 2; $col++) {
                $symmetricColor = $avatar->getRandom();
                $this->matrice[$row][$col] = $symmetricColor;
                $this->matrice[$row][$size - $col - 1] = $symmetricColor;
            }
        }

        return $this->matrice;
    }
}

class CrossMatrix extends Matrix
{
    public function generateCrossMatrix($size, $avatar)
    {
        for ($row = 0; $row < $size; $row++) {
            $this->matrice[$row] = [];
            for ($col = 0; $col < $size; $col++) {


                if ($col == $row || $col == $size - $row - 1) {
                    $this->matrice[$row][$col] = $avatar->getRandom();
                } else {
                    $this->matrice[$row][$col] = '#FFFFFF';
                }
            }
        }

        return $this->matrice;
    }
}
