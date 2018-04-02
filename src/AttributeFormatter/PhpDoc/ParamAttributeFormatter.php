<?php
declare(strict_types=1);

namespace Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\Generic\RegexAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\Generic\TypeAttributeFormatter;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context;

final class ParamAttributeFormatter implements AttributeFormatter
{
    /** @var AttributeFormatter */
    private $formatter;

    public function __construct()
    {
        $this->formatter = new TypeAttributeFormatter(
            new RegexAttributeFormatter('/(?P<type>[\S]+)\s*(?P<name>[\S]+)\s*(?P<description>.*)/'),
            new TypeResolver()
        );
    }

    public function format(array $attributes, Context $context): array
    {
        return $this->formatter->format($attributes, $context);
    }
}
