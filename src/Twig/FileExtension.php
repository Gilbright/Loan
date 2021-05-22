<?php

namespace App\Twig;

use App\Service\UploaderHelper;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FileExtension extends AbstractExtension
{
    /** @var UploaderHelper $uploaderHelper */
    private $uploaderHelper;
    /**
     * FileExtension constructor.
     * @param UploaderHelper $uploaderHelper
     */
    public function __construct(UploaderHelper $uploaderHelper)
    {
        $this->uploaderHelper = $uploaderHelper;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('uploaded_asset', [$this, 'getUploadedAssetPath']),
        ];
    }

    public function getUploadedAssetPath(string $path): string
    {
       return $this->uploaderHelper->getImagePath($path);
    }
}
