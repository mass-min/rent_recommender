<?php

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamException;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;
use RentRecommender\Utility\HtmlDownloader;

class PageDownloaderTest extends TestCase
{
    const TEST_DIR_NAME = 'tests';
    const TMP_DIR_NAME = 'tmp';
    const FIXTURE_DIR_NAME = 'fixtures';

    /**
     * @throws vfsStreamException
     */
    public static function setUpBeforeClass(): void
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory(self::TEST_DIR_NAME));
        vfsStreamWrapper::getRoot()->addChild(vfsStream::newDirectory(self::TMP_DIR_NAME));
    }

    /**
     * @return string
     */
    public static function getTmpDirPath() {
        $originalTmpDirPath = self::TEST_DIR_NAME . '/' . self::TMP_DIR_NAME;
        return vfsStream::url($originalTmpDirPath);
    }

    /**
     * @test
     * ファイルがダウンロード出来ることを確認
     */
    public function testDownload()
    {
        $tmpDirPath = self::getTmpDirPath();
        // DL先のtmpディレクトリの中に、ファイルが何もないことを確認
        $this->assertSame([], glob($tmpDirPath . '/*'));

        // download()でファイルがDLされることを確認
        $downloadedFileName = $tmpDirPath . '/test.html';
        $this->assertTrue(
            HtmlDownloader::download(
                self::TEST_DIR_NAME . '/' . self::FIXTURE_DIR_NAME . '/sample.html',
                $downloadedFileName
            )
        );
        $this->assertTrue(file_exists($downloadedFileName));
    }

    /**
     * @test
     * ファイルが存在しなければダウンロードに失敗することを確認
     */
    public function testDownloadFailsWhenTargetFileNotExists()
    {
        $tmpDirPath = self::getTmpDirPath();
        // DL先のtmpディレクトリの中に、ファイルが何もないことを確認
        $this->assertSame([], glob($tmpDirPath . '/*'));

        // 存在しないファイルをダウンロードしようとするとfalseが返ることを確認
        $downloadedFileName = $tmpDirPath . '/test2.html';
        $this->assertFalse(
            @HtmlDownloader::download(
                self::TEST_DIR_NAME . '/' . self::FIXTURE_DIR_NAME . '/not_exist.html',
                $downloadedFileName
            )
        );
        // ファイルも作成されていないことを確認
        $this->assertFalse(file_exists($downloadedFileName));
    }
}