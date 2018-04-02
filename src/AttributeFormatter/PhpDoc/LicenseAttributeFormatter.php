<?php
declare(strict_types=1);

namespace Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\Generic\RegexAttributeFormatter;
use phpDocumentor\Reflection\Types\Context;

final class LicenseAttributeFormatter implements AttributeFormatter
{
    /** @var AttributeFormatter */
    private $formatter;

    public function __construct()
    {
        $this->formatter = new RegexAttributeFormatter(
            '/(?P<url>(?:ftp|https?):\/\/[^\s]+)\s*(?P<name>.*)/',
            '/(?P<name>.*)/'
        );
    }

    public function format(array $attributes, Context $context): array
    {
        return $this->formatter->format($attributes, $context);
    }
}
