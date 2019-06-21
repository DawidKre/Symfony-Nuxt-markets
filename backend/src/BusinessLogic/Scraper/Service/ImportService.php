<?php

namespace App\BusinessLogic\Scraper\Service;

use App\Entity\Category;
use App\Entity\Market;
use ArrayIterator;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;
use SplTempFileObject;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class ImportService
 */
class ImportService
{

    private $projectDir;
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * CsvService constructor.
     * 
     * @param $projectDir
     * @param Filesystem $filesystem
     */
    public function __construct($projectDir, Filesystem $filesystem)
    {
        $this->projectDir = $projectDir;
        $this->filesystem = $filesystem;
    }

    public function importFromFile()
    {
        
    }
}