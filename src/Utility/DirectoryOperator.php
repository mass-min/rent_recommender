<?php

namespace RentRecommender\Utility;

class DirectoryOperator
{
    /**
     * @param string $path
     * @return string
     */
    public static function findOrCreate(string $path): string
    {
        if (!file_exists($path)) {
            echo "There is no $path directory. Creating it ... ";
            mkdir($path, 0777, true);
            echo "Finish creating $path directory.\n";
        }
        return $path;
    }
}