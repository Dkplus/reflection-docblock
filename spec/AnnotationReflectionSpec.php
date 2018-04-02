<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock;

use Dkplus\Reflection\DocBlock\AnnotationReflection;
use PhpSpec\ObjectBehavior;

class AnnotationReflectionSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedThrough('unqualified', ['ignore', []]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(AnnotationReflection::class);
    }

    function it_can_be_unqualified()
    {
        $this->isFullyQualified()->shouldBe(false);
    }

    function it_can_be_fullyQualified()
    {
        $this->beConstructedThrough('fullyQualified', ['MyNamespace\\MyAnnotation', []]);
        $this->isFullyQualified()->shouldBe(true);
    }

    function it_has_a_tag()
    {
        $this->tag()->shouldBe('ignore');
    }

    function it_has_attributes()
    {
        $this->beConstructedThrough('unqualified', ['since', ['version' => '1.0.0']]);
        $this->attributes()->shouldBe(['version' => '1.0.0']);
    }

    function its_tag_is_its_FQCN_if_its_fully_qualified()
    {
        $this->beConstructedThrough('fullyQualified', ['MyNamespace\\MyAnnotation', []]);
        $this->tag()->shouldBe('MyNamespace\\MyAnnotation');
    }

    function it_has_attached_annotations_that_also_include_the_attached_annotations_of_the_attached_annotations()
    {
        $attachedToAttached = AnnotationReflection::unqualified('ignore', []);
        $attached = AnnotationReflection::fullyQualified('MyNamespace\\AnotherAnnotation', [], $attachedToAttached);
        $this->beConstructedThrough('fullyQualified', [
            'MyNamespace\\MyAnnotation',
            [],
            $attached
        ]);
        $this->attached()->shouldIterateAs([$attached, $attachedToAttached]);
    }

    function it_can_be_casted_to_string_for_debugging_purposes()
    {
        $this->beConstructedThrough('fullyQualified', [
            'MyNamespace\\MyAnnotation',
            ['type' => 'string', 'values' => ['foo', 'bar', 'baz']],
            AnnotationReflection::unqualified('ignore', [])
        ]);
        $this->__toString()->shouldBeString();
    }
}
