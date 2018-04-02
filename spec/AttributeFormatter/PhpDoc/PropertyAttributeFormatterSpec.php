<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\PropertyAttributeFormatter;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\String_;
use PhpSpec\ObjectBehavior;

class PropertyAttributeFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PropertyAttributeFormatter::class);
    }

    function it_is_an_AttributeFormatter()
    {
        $this->shouldImplement(AttributeFormatter::class);
    }

    function it_formats_simple_internal_types()
    {
        $context = new Context('MyNamespace', []);
        $this
            ->format(['string $myProperty'], $context)
            ->shouldBeLike(['type' => new String_(), 'name' => '$myProperty', 'description' => '']);
    }

    function it_supports_descriptions()
    {
        $context = new Context('MyNamespace', []);
        $this
            ->format(['string $myProperty My description'], $context)
            ->shouldBeLike(['type' => new String_(), 'name' => '$myProperty', 'description' => 'My description']);
    }

    function it_normalizes_namespaces_of_types()
    {
        $context = new Context('MyNamespace', ['Foo' => 'MyNamespace\\Foo']);
        $this
            ->format(['Foo $myProperty'], $context)
            ->shouldBeLike(['type' => new Object_(new Fqsen('\\MyNamespace\\Foo')), 'name' => '$myProperty', 'description' => '']);
    }
}
