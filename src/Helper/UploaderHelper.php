<?php
/**
 * Created by PHPstorm.
 * User: Marwane Tchassama
 * Date: 15.05.2021
 * Time: 00:01
 */

namespace App\Helper;


use Gedmo\Sluggable\Util\Urlizer;
use League\Flysystem\Filesystem;
use Symfony\Component\Asset\Context\RequestStackContext;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    public const BUS_PLAN_DOC_NAME = '_business_plan_document';

    public const DET_EXTRA_DOC_NAME = '_detail_extra_document';

    public const ID_PATH_NAME = '_id_document';

    public const ID_DOC_PATH_NAME = '_id_doc_document'; // A revoir

    public const SAVING_DOC_NAME = '_saving_document'; // A revoir

    public const USER_ID_DOC_PATH_NAME = '_user_id_doc_document'; // A revoir

    public const USER_ID_PATH_NAME = '_user_id_document';

    private Filesystem $filesystem;

    private RequestStackContext $requestStackContext;

    private $uploadedAssetsBaseUrl;

    private string $publicAssetBaseUrl;

    /**
     * @param Filesystem $publicUploadsFilesystem
     * @param RequestStackContext $requestStackContext
     * @param string $uploadedAssetsBaseUrl
     */
    public function __construct(Filesystem $publicUploadsFilesystem, RequestStackContext $requestStackContext, string $uploadedAssetsBaseUrl)
    {
        $this->filesystem = $publicUploadsFilesystem;
        $this->requestStackContext = $requestStackContext;
        $this->publicAssetBaseUrl = $uploadedAssetsBaseUrl;
    }

    public function uploadPhenixFile(File $file, ?string $newFileName): string
    {
        if ($file instanceof UploadedFile){
            $originalFilename = $file->getClientOriginalName();
        }else{
            $originalFilename = $file->getFilename();
        }

        $originalFilename = $newFileName ?? $originalFilename;

        $newFilename = $originalFilename.'.'.$file->guessExtension();

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

        return $newFilename;
    }

    public function getFilePath(string $path, ?string $subDirectory = ''): string
    {
        return $this->requestStackContext
                ->getBasePath().$this->publicAssetBaseUrl.'/'.$subDirectory.$path;
    }

    public function getDownloadPath(string $path, ?string $subDirectory = 'uploads/Phenix/'): string
    {
        return $this->requestStackContext->getBasePath().$subDirectory.$path;
    }
}