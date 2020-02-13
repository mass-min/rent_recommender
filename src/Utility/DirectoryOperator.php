<?php

namespace RentRecommender\Utility;

use Carbon\Carbon;

class DirectoryOperator
{
    const TMP_DIR_PATH = 'tmp';

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

    /**
     * @param string $date
     * @return string
     */
    public static function getIndexHtmlDirPath(string $date): string
    {
        return  self::TMP_DIR_PATH . '/indexHtml/' . self::getDateDirPath($date);
    }

    /**
     * @param string $date
     * @return string
     */
    public static function getDetailHtmlDirPath(string $date): string
    {
        return self::TMP_DIR_PATH . '/detailHtml/' . self::getDateDirPath($date);
    }

    /**
     * @param string $date
     * @return string
     */
    public static function getDetailCsvDirPath(string $date): string
    {
        return self::TMP_DIR_PATH . '/detailLinks/' . self::getDateDirPath($date);
    }

    /**
     * @param string $date
     * @return string
     */
    public static function getDateDirPath (string $date): string
    {
        return Carbon::create($date)->format('Y/m/d');
    }
}