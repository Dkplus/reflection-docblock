<?php
declare(strict_types=1);

namespace Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\Generic\RegexAttributeFormatter;
use phpDocumentor\Reflection\Types\Context;

final class AuthorAttributeFormatter implements AttributeFormatter
{
    /** @var AttributeFormatter */
    private $formatter;

    public function __construct()
    {
        $this->formatter = new RegexAttributeFormatter('/(?P<name>[^<]+)(?:<(?P<emailAddress>[^>]+)>)?/');
    }

    public function format(array $attributes, Context $context): array
    {
        return $this->formatter->format($attributes, $context);
    }
}
