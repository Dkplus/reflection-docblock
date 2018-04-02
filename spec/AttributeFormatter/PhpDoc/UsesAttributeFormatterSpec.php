<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\UsesAttributeFormatter;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Context;
use PhpSpec\ObjectBehavior;

class UsesAttributeFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UsesAttributeFormatter::class);
    }

    function it_is_an_AttributeFormatter()
    {
        $this->shouldImplement(AttributeFormatter::class);
    }

    function it_formats_the_tag_without_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['MyClass::$items'], $context)
            ->shouldBeLike(['fqsen' => new Fqsen('\\MyNamespace\\MyClass::$items'), 'description' => '']);
    }

    function it_formats_the_tag_with_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['MyClass::$items to retrieve the count from.'], $context)
            ->shouldBeLike([
                'fqsen' => new Fqsen('\\MyNamespace\\MyClass::$items'),
                'description' => 'to retrieve the count from.'
            ]);
    }
}
