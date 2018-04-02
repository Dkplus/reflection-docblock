<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\VarAttributeFormatter;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Types\String_;
use PhpSpec\ObjectBehavior;

class VarAttributeFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(VarAttributeFormatter::class);
    }

    function it_formats_without_name_and_description()
    {
        $context = new Context('MyNamespace', []);
        $this
            ->format(['string'], $context)
            ->shouldBeLike(['type' => new String_(), 'description' => '']);
    }

    function it_formats_with_name_but_without_description()
    {
        $context = new Context('MyNamespace', []);
        $this
            ->format(['string $name'], $context)
            ->shouldBeLike([
                'type' => new String_(),
                'name' => '$name',
                'description' => ''
            ]);
    }

    function it_formats_with_description_but_without_name()
    {
        $context = new Context('MyNamespace', []);
        $this
            ->format(['string Should contain a description'], $context)
            ->shouldBeLike([
                'type' => new String_(),
                'description' => 'Should contain a description'
            ]);
    }

    function it_formats_with_name_and_description()
    {
        $context = new Context('MyNamespace', []);
        $this
            ->format(['string $name Should contain a description'], $context)
            ->shouldBeLike([
                'type' => new String_(),
                'name' => '$name',
                'description' => 'Should contain a description'
            ]);
    }
}
