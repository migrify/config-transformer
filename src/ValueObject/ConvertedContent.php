<?php

declare (strict_types=1);
namespace ConfigTransformer202107154\Symplify\ConfigTransformer\ValueObject;

use ConfigTransformer202107154\Symplify\SmartFileSystem\SmartFileInfo;
final class ConvertedContent
{
    /**
     * @var string
     */
    private $convertedContent;
    /**
     * @var \Symplify\SmartFileSystem\SmartFileInfo
     */
    private $originalFileInfo;
    public function __construct(string $convertedContent, \ConfigTransformer202107154\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo)
    {
        $this->convertedContent = $convertedContent;
        $this->originalFileInfo = $originalFileInfo;
    }
    public function getConvertedContent() : string
    {
        return $this->convertedContent;
    }
    public function getOriginalFilePathWithoutSuffix() : string
    {
        return $this->originalFileInfo->getRealPathWithoutSuffix();
    }
}
