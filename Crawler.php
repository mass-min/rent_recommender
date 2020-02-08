<?php

class Crawler
{
    const INDEX_URL = 'https://suumo.jp/jj/chintai/ichiran/FR301FC005/?ar=030&bs=040&ta=13&sc=13110&cb=0.0&ct=9999999&mb=0&mt=9999999&et=9999999&cn=9999999&shkr1=03&shkr2=03&shkr3=03&shkr4=03&sngz=&po1=25&po2=99&pc=100';

    /**
     * function executed before executing run()
     */
    public function beforeAction()
    {
        echo "--- Crawler start ---\n";
        if (!file_exists('tmp')) {
            echo "There is no tmp directory. Creating it ... ";
            mkdir('tmp');
            echo "Complete to creating tmp directory.\n";
        }
    }

    /**
     * @return void
     */
    public function run () {
        self::beforeAction();

        $indexPage = file_get_contents(self::INDEX_URL);
        $file = fopen('tmp/index.html', 'w');
        fwrite($file, $indexPage);
        fclose($file);

        self::afterAction();
    }

    /**
     * function executed after executing run()
     */
    public function afterAction () {
        echo "--- Crawler Finish ---\n";
    }
}

$crawler = new Crawler();
$crawler->run();