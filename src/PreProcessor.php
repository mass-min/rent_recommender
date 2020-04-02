<?php

namespace RentRecommender;

use RentRecommender\Utility\DirectoryOperator;
use SplFileObject;

require_once "vendor/autoload.php";

class PreProcessor
{
    private $detailDataDirPath;

    /**
     * IndexPageCrawler constructor.
     * @param $date
     */
    public function __construct($date)
    {
        $this->detailDataDirPath = DirectoryOperator::getDetailDataCsvDirPath($date);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function execute(): void
    {
        // データ格納ディレクトリが存在しなかったらエラー
        DirectoryOperator::findOrFail($this->detailDataDirPath);

        $file = new SplFileObject($this->detailDataDirPath . '/data.csv');
        $file->setFlags(SplFileObject::READ_CSV);

        foreach ($file as $index => $line) {
            if ($index === 0 || !$file->valid()) {
                continue;
            }
            $data['name'] = $line[0];
            $data['rent'] = $this->convertPriceFromStringToInt($line[1]);
            $data['commonServiceFee'] = $this->convertPriceFromStringToInt($line[2]);
            $data['securityDeposit'] = $this->convertPriceFromStringToInt($line[3]);
            $data['gratuityFee'] = $this->convertPriceFromStringToInt($line[3]);
            $data['guaranteeDeposit'] = $this->convertPriceFromStringToInt($line[3]);
            $data['repayment'] = $this->convertPriceFromStringToInt($line[3]);
            $data['age'] = $this->convertAgeFromStringToInt($line[11]);

            // 詳細ページのスクレイピング結果をCSVに吐き出し
            $csvPath = 'data.csv';

            $csvFile = new SplFileObject($csvPath, 'a+');
            $csvFile->seek(PHP_INT_MAX);
            if ($csvFile->key() == 0) {
                $csvFile->fputcsv(array_keys($data));
            }
            $csvFile->fputcsv(array_values($data));
        }
    }

    /**
     * @param $priceStr
     * @return int|null
     */
    public function convertPriceFromStringToInt($priceStr)
    {
        if ($priceStr === null || $priceStr === '') {
            return null;
        } else {
            if (preg_match('/^.*万円$/', $priceStr)) {
                return (int)(explode('万円', $priceStr)[0] * 10000);
            } else {
                return (int)(explode('円', $priceStr)[0]);
            }
        }
    }

    /**
     * @param $ageStr
     * @return int|null
     */
    public function convertAgeFromStringToInt($ageStr)
    {
        if ($ageStr === null || $ageStr === '') {
            return null;
        } else {
            if (preg_match('/^築[0-9]*年$/', $ageStr)) {
                preg_match('/^築(\d+)年$/', $ageStr, $age);
                return (int)$age[1];
            }
        }
    }
}

$prePro = new PreProcessor('2020-02-12');
$prePro->execute();