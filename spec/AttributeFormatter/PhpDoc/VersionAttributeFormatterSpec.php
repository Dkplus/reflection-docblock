<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\VersionAttributeFormatter;
use phpDocumentor\Reflection\Types\Context;
use PhpSpec\ObjectBehavior;

class VersionAttributeFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(VersionAttributeFormatter::class);
    }

    function it_is_an_AttributeFormatter()
    {
        $this->shouldImplement(AttributeFormatter::class);
    }

    function it_formats_the_tag_with_just_a_vector()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['1.0.0'], $context)
            ->shouldBe(['vector' => '1.0.0', 'description' => '']);
    }

    function it_formats_the_tag_with_just_a_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['Some description.'], $context)
            ->shouldBe(['description' => 'Some description.']);
    }

    function it_formats_the_tag_with_vector_and_description()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['1.0.0 Some description.'], $context)
            ->shouldBe(['vector' => '1.0.0', 'description' => 'Some description.']);
    }

    function it_formats_ids_from_vcs_systems()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['GIT: $Id$ In development. Very unstable.'], $context)
            ->shouldBe(['vector' => 'GIT: $Id$', 'description' => 'In development. Very unstable.']);
    }
}
