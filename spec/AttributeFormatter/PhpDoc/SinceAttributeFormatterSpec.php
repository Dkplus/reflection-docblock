<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\SinceAttributeFormatter;
use phpDocumentor\Reflection\Types\Context;
use PhpSpec\ObjectBehavior;

class SinceAttributeFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SinceAttributeFormatter::class);
    }

    function it_is_an_AttributeFormatter()
    {
        $this->shouldImplement(AttributeFormatter::class);
    }

    function it_formats_the_tag_with_just_a_version()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['1.0.1'], $context)
            ->shouldBe(['version' => '1.0.1', 'description' => '']);
    }

    function it_formats_the_tag_with_version_and_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['1.0.1 First time this was introduced.'], $context)
            ->shouldBe(['version' => '1.0.1', 'description' => 'First time this was introduced.']);
    }
}
