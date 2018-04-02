<?php
declare(strict_types=1);

namespace Dkplus\Reflection\DocBlock\AttributeFormatter\MultiTag;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\Generic\FqsenAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\Generic\MethodAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\Generic\NamedAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\Generic\TypeAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\AuthorAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\DeprecatedAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\LicenseAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\LinkAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\ParamAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\PropertyAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\ReturnAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\SeeAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\SinceAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\ThrowsAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\UsesAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\VarAttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\VersionAttributeFormatter;
use Dkplus\Reflection\DocBlock\MultiTagAttributeFormatter;
use phpDocumentor\Reflection\FqsenResolver;
use phpDocumentor\Reflection\TypeResolver;
use phpDocumentor\Reflection\Types\Context;
use function array_map;

final class OneFormatterPerTagAttributeFormatter implements MultiTagAttributeFormatter
{
    /** @var array|AttributeFormatter[] */
    private $formattersByTag;

    public static function forDefaultTags(): self
    {
        $fqsenResolver = new FqsenResolver();
        $typeResolver = new TypeResolver($fqsenResolver);
        $justDescription = new NamedAttributeFormatter('description');
        return new self([
            'author' => new AuthorAttributeFormatter(),
            'copyright' => $justDescription,
            'deprecated' => new DeprecatedAttributeFormatter(),
            'ignore' => $justDescription,
            'internal' => $justDescription,
            'license' => new LicenseAttributeFormatter(),
            'link' => new LinkAttributeFormatter(),
            'method' => new TypeAttributeFormatter(new MethodAttributeFormatter(), $typeResolver),
            'package' => new NamedAttributeFormatter('name'),
            'param' => new ParamAttributeFormatter(),
            'property' => new PropertyAttributeFormatter(),
            'property-read' => new PropertyAttributeFormatter(),
            'property-write' => new PropertyAttributeFormatter(),
            'return' => new ReturnAttributeFormatter(),
            'see' => new SeeAttributeFormatter(),
            'since' => new SinceAttributeFormatter(),
            'subpackage' => new NamedAttributeFormatter('name'),
            'throws' => new ThrowsAttributeFormatter(),
            'todo' => $justDescription,
            'uses' => new UsesAttributeFormatter(),
            'var' => new VarAttributeFormatter(),
            'version' => new VersionAttributeFormatter(),
            'covers' => new FqsenAttributeFormatter(new NamedAttributeFormatter('fqsen'), $fqsenResolver),
        ]);
    }

    /** @param AttributeFormatter[] $formatters */
    public function __construct(array $formatters)
    {
        $this->formattersByTag = array_map(function (AttributeFormatter $formatter) {
            return $formatter;
        }, $formatters);
    }

    public function format(string $tag, array $attributes, Context $context): array
    {
        if (isset($this->formattersByTag[$tag])) {
            return $this->formattersByTag[$tag]->format($attributes, $context);
        }
        return $attributes;
    }
}
