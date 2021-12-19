<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 15.05.2021
 * Time: 00:01
 */

namespace App\Service;


use Gedmo\Sluggable\Util\Urlizer;
use League\Flysystem\FilesystemOperator;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    private FilesystemOperator $filesystem;

    private RequestStackContext $requestStackContext;

    private $uploadedAssetsBaseUrl;

    private string $publicAssetBaseUrl;

    /**
     * @param FilesystemOperator $publicUploadsFilesystem
     * @param RequestStackContext $requestStackContext
     * @param string $uploadedAssetsBaseUrl
     */
    public function __construct(FilesystemOperator $publicUploadsFilesystem, RequestStackContext $requestStackContext, string $uploadedAssetsBaseUrl)
    {
        $this->filesystem = $publicUploadsFilesystem;
        $this->requestStackContext = $requestStackContext;
        $this->publicAssetBaseUrl = $uploadedAssetsBaseUrl;
    }

    public function uploadPhenixFile(File $file): string
    {
        if ($file instanceof UploadedFile){
            $originalFilename = $file->getClientOriginalName();
        }else{
            $originalFilename = $file->getFilename();
        }

        $newFilename = Urlizer::urlize(pathinfo($originalFilename, PATHINFO_FILENAME)).'-'.uniqid('', true).'.'.$file->guessExtension();

        $stream = fopen($file->getPathname(), 'r');

        $result = $this->filesystem->writeStream(
            '/Phenix/'.$newFilename,
            $stream
        );

        if ($result === false) {
            throw new \Exception(sprintf('Could not write uploaded file "%s"', $newFilename));
        }

        if (is_resource($stream)) {
            fclose($stream);
        }


        /*$this->filesystem->write(
            '/Demonstration/'.$newFilename,
            file_get_contents($file->getPathname())
        );*/
        
        return $newFilename;
    }

    public function getImagePath(string $path): string
    {
        return $this->requestStackContext
                ->getBasePath().$this->publicAssetBaseUrl.'/'.$path;
    }
}