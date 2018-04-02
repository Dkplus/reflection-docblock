<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\ThrowsAttributeFormatter;
use phpDocumentor\Reflection\Fqsen;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Types\Object_;
use PhpSpec\ObjectBehavior;

class ThrowsAttributeFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ThrowsAttributeFormatter::class);
    }

    function it_is_an_AttributeFormatter()
    {
        $this->shouldImplement(AttributeFormatter::class);
    }

    function it_formats_without_description()
    {
        $context = new Context('MyNamespace', []);
        $this
            ->format(['\Exception'], $context)
            ->shouldBeLike(['type' => new Object_(new Fqsen('\\Exception')), 'description' => '']);
    }

    function it_formats_with_description()
    {
        $context = new Context('MyNamespace', []);
        $this
            ->format(['InvalidArgumentException if the provided argument is not of type \'array\'.'], $context)
            ->shouldBeLike([
                'type' => new Object_(new Fqsen('\\MyNamespace\\InvalidArgumentException')),
                'description' => 'if the provided argument is not of type \'array\'.'
            ]);
    }
}
