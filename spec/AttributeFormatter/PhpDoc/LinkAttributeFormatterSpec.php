<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\LinkAttributeFormatter;
use phpDocumentor\Reflection\Types\Context;
use PhpSpec\ObjectBehavior;

class LinkAttributeFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LinkAttributeFormatter::class);
    }

    function it_is_an_AttributeFormatter()
    {
        $this->shouldImplement(AttributeFormatter::class);
    }

    function it_formats_the_tag_with_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['http://example.com/my/bar Documentation of Foo.'], $context)
            ->shouldBe(['uri' => 'http://example.com/my/bar', 'description' => 'Documentation of Foo.']);
    }

    function it_formats_the_tag_without_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['http://example.com/my/bar'], $context)
            ->shouldBe(['uri' => 'http://example.com/my/bar', 'description' => '']);
    }
}
