<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\AttributeFormatter\PhpDoc\AuthorAttributeFormatter;
use phpDocumentor\Reflection\Types\Context;
use PhpSpec\ObjectBehavior;

class AuthorAttributeFormatterSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(AuthorAttributeFormatter::class);
    }

    function it_is_an_AttributeFormatter()
    {
        $this->shouldImplement(AttributeFormatter::class);
    }

    function it_formats_the_tag_with_emailAddress()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['My Name <my.name@example.com>'], $context)
            ->shouldBe(['name' => 'My Name', 'emailAddress' => 'my.name@example.com']);
    }

    function it_formats_the_tag_without_emailAddress()
    {
        $context = new Context('MyNamespace');
        $this
            ->format(['My Name'], $context)
            ->shouldBe(['name' => 'My Name']);
    }
}
