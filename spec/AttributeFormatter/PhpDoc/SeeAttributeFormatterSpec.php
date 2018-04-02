<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\SeeAttributeFormatter;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Context;
use PhpSpec\ObjectBehavior;

class SeeAttributeFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SeeAttributeFormatter::class);
    }

    function it_is_an_AttributeFormatter()
    {
        $this->shouldImplement(AttributeFormatter::class);
    }

    function it_formats_Fqsen_with_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['MyClass::$items For the property whose items are counted.'], $context)
            ->shouldBeLike([
                'fqsen' => new Fqsen('\\MyNamespace\\MyClass::$items'),
                'description' => 'For the property whose items are counted.'
            ]);
    }

    function it_formats_Fqsen_without_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['MyClass::$items'], $context)
            ->shouldBeLike([
                'fqsen' => new Fqsen('\\MyNamespace\\MyClass::$items'),
                'description' => ''
            ]);
    }

    function it_formats_Uris_with_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['http://example.com/my/bar Documentation of Foo.'], $context)
            ->shouldBeLike(['uri' => 'http://example.com/my/bar', 'description' => 'Documentation of Foo.']);
    }

    function it_formats_Uris_without_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['http://example.com/my/bar'], $context)
            ->shouldBeLike(['uri' => 'http://example.com/my/bar', 'description' => '']);
    }
}
