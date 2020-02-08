<?php

class Crawler
{
    const INDEX_URL = 'https://suumo.jp/jj/chintai/ichiran/FR301FC005/?ar=030&bs=040&ta=13&sc=13110&cb=0.0&ct=9999999&mb=0&mt=9999999&et=9999999&cn=9999999&shkr1=03&shkr2=03&shkr3=03&shkr4=03&sngz=&po1=25&po2=99&pc=100';

    /**
     * @return bool
     */
    public function run () {
        $indexPage = file_get_contents(self::INDEX_URL);
        if (!file_exists('tmp')) {
            mkdir('tmp');
        }
        $file = fopen('tmp/index.html', 'w');
        fwrite($file, $indexPage);
        fclose($file);

        return true;
    }
}

$crawler = new Crawler();
$crawler->run();