<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\DeprecatedAttributeFormatter;
use phpDocumentor\Reflection\Types\Context;
use PhpSpec\ObjectBehavior;

class DeprecatedAttributeFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(DeprecatedAttributeFormatter::class);
    }

    function it_is_an_AttributeFormatter()
    {
        $this->shouldImplement(AttributeFormatter::class);
    }

    function it_formats_the_tag_with_just_a_version()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['1.0.0'], $context)
            ->shouldBe(['version' => '1.0.0', 'description' => '']);
    }

    function it_formats_the_tag_with_just_a_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['No longer used by internal code and not recommended.'], $context)
            ->shouldBe(['description' => 'No longer used by internal code and not recommended.']);
    }

    function it_formats_the_tag_with_version_and_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['1.0.0 No longer used by internal code and not recommended.'], $context)
            ->shouldBe(['version' => '1.0.0', 'description' => 'No longer used by internal code and not recommended.']);
    }
}
