<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\ReturnAttributeFormatter;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\String_;
use PhpSpec\ObjectBehavior;

class ReturnAttributeFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ReturnAttributeFormatter::class);
    }

    function it_formats_without_description()
    {
        $context = new Context('MyNamespace', []);
        $this
            ->format(['string'], $context)
            ->shouldBeLike(['type' => new String_(), 'description' => '']);
    }

    function it_formats_with_description()
    {
        $context = new Context('MyNamespace', []);
        $this
            ->format(['integer Indicates the number of items.'], $context)
            ->shouldBeLike([
                'type' => new Integer(),
                'description' => 'Indicates the number of items.'
            ]);
    }
}
