<?php
declare(strict_types=1);

namespace Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\Generic\RegexAttributeFormatter;
use phpDocumentor\Reflection\Types\Context;

final class VersionAttributeFormatter implements AttributeFormatter
{
    /** @var AttributeFormatter */
    private $formatter;

    public function __construct()
    {
        $this->formatter = new RegexAttributeFormatter(
            '/^(?P<vector>[a-zA-Z]+:\s*\$.+\$)\s*(?P<description>.*)/',
            '/^(?P<description>(?!\d\S+).*)/',
            '/(?P<vector>\d\S+)?\s*(?P<description>.*)/'
        );
    }

    public function format(array $attributes, Context $context): array
    {
        return $this->formatter->format($attributes, $context);
    }
}
