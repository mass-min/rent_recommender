<?php

use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamException;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;
use PHPUnit\Framework\TestCase;
use RentRecommender\Utility\DocumentInitializer;
use RentRecommender\Utility\HtmlDownloader;

class PageDownloaderTest extends TestCase
{
    const TEST_DIR_NAME = 'tests';
    const TMP_DIR_NAME = 'tmp';
    const FIXTURE_DIR_NAME = 'fixtures';

    private $tmpDirPath;

    /**
     * @throws vfsStreamException
     */
    public static function setUpBeforeClass(): void
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory(self::TEST_DIR_NAME));
        vfsStreamWrapper::getRoot()->addChild(vfsStream::newDirectory(self::TMP_DIR_NAME));
    }

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->tmpDirPath = self::getTmpDirPath();
    }

    /**
     * @return string
     */
    public static function getTmpDirPath(): string
    {
        $originalTmpDirPath = self::TEST_DIR_NAME . '/' . self::TMP_DIR_NAME;
        return vfsStream::url($originalTmpDirPath);
    }

    /**
     * @test
     * ファイルがダウンロード出来ることを確認
     */
    public function testDownload()
    {
        // DL先のtmpディレクトリの中に、ファイルが何もないことを確認
        $this->assertSame([], glob($this->tmpDirPath . '/*'));

        // download()でファイルがDLされることを確認
        $downloadedFilePath = $this->tmpDirPath . '/test.html';
        $this->assertTrue(
            HtmlDownloader::download(
                self::TEST_DIR_NAME . '/' . self::FIXTURE_DIR_NAME . '/sample.html',
                $downloadedFilePath
            )
        );
        $this->assertTrue(file_exists($downloadedFilePath));

        $doc = DocumentInitializer::createDocumentWithHtml($downloadedFilePath);

        $this->assertSame('sample.html', $doc->find('h1')->text());
    }

    /**
     * @test
     * ファイルが存在しなければダウンロードに失敗することを確認
     */
    public function testDownloadFailsWhenTargetFileNotExists()
    {
        // DL先のtmpディレクトリの中に、ファイルが何もないことを確認
        $this->assertSame([], glob($this->tmpDirPath . '/*'));

        // 存在しないファイルをダウンロードしようとするとfalseが返ることを確認
        $downloadedFilePath = $this->tmpDirPath . '/test2.html';
        $this->assertFalse(
            @HtmlDownloader::download(
                self::TEST_DIR_NAME . '/' . self::FIXTURE_DIR_NAME . '/not_exist.html',
                $downloadedFilePath
            )
        );
        // ファイルも作成されていないことを確認
        $this->assertFalse(file_exists($downloadedFilePath));
    }
}