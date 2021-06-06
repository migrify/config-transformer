<?php

declare (strict_types=1);
namespace ConfigTransformer20210606\Symplify\ConfigTransformer\ValueObject;

use ConfigTransformer20210606\Symplify\SmartFileSystem\SmartFileInfo;
final class ConvertedContent
{
    /**
     * @var string
     */
    private $convertedContent;
    /**
     * @var SmartFileInfo
     */
    private $originalFileInfo;
    public function __construct(string $convertedContent, \ConfigTransformer20210606\Symplify\SmartFileSystem\SmartFileInfo $originalFileInfo)
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
