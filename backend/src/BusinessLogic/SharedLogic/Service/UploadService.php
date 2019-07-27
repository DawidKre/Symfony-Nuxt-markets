<?php

namespace App\BusinessLogic\SharedLogic\Service;

use Symfony\Component\Filesystem\Filesystem;

/**
 * Class UploadService.
 */
class UploadService
{
    /** @var Filesystem */
    private $filesystem;

    /** @var string */
    private $uploadPath;

    /**
     * SlackService constructor.
     *
     * @param Filesystem $filesystem
     * @param string     $uploadPath
     */
    public function __construct(Filesystem $filesystem, string $uploadPath)
    {
        $this->filesystem = $filesystem;
        $this->uploadPath = $uploadPath;
    }

    /**
     * @param string $fileName
     * @param string $content
     *
     * @return string
     */
    public function uploadFile(string $fileName, string $content): string
    {
        $path = $this->uploadPath.DIRECTORY_SEPARATOR.$fileName;
        $this->filesystem->appendToFile($path, $content);

        return $path;
    }
}
