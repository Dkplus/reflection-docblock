<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock\AttributeFormatter\MultiTag;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\MultiTag\OneFormatterPerTagAttributeFormatter;
use phpDocumentor\Reflection\Types\ContextFactory;
use PhpSpec\ObjectBehavior;

class OneFormatterPerTagAttributeFormatterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(OneFormatterPerTagAttributeFormatter::class);
    }

    function it_uses_one_of_the_given_formatters_to_format_the_attributes_of_a_tag(AttributeFormatter $formatter)
    {
        $context = (new ContextFactory())->createForNamespace(__NAMESPACE__, '');
        $formatter->format(['with some attributes'], $context)->willReturn(['quantity' => 'some']);
        $this->beConstructedWith(['someTag' => $formatter]);
        $this->format('someTag', ['with some attributes'], $context)->shouldBe(['quantity' => 'some']);
    }

    function it_returns_the_given_attributes_if_no_formatter_is_registered_for_the_tag()
    {
        $context = (new ContextFactory())->createForNamespace(__NAMESPACE__, '');
        $this->beConstructedWith([]);
        $this->format('someTag', ['with some attributes'], $context)->shouldBe(['with some attributes']);
    }

    function it_ships_with_some_default_formatters()
    {
        $this->beConstructedThrough('forDefaultTags');
        $this->shouldHaveType(OneFormatterPerTagAttributeFormatter::class);
    }
}
