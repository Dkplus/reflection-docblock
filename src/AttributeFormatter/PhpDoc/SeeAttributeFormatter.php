<?php
declare(strict_types=1);

namespace Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\Generic\FqsenAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\Generic\RegexAttributeFormatter;
use phpDocumentor\Reflection\FqsenResolver;
use phpDocumentor\Reflection\Types\Context;

final class SeeAttributeFormatter implements AttributeFormatter
{
    /** @var AttributeFormatter */
    private $formatter;

    public function __construct()
    {
        $this->formatter = new FqsenAttributeFormatter(new RegexAttributeFormatter(
            '/(?P<uri>(?:ftp|https?):\/\/[\S]+)\s*(?P<description>.*)/',
            '/(?P<fqsen>[^\s]+\s?)\s*(?P<description>.*)/'
        ), new FqsenResolver());
    }

    public function format(array $attributes, Context $context): array
    {
        return $this->formatter->format($attributes, $context);
    }
}
