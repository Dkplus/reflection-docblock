<?php
declare(strict_types=1);

namespace spec\Dkplus\Reflection\DocBlock;

use Dkplus\Reflection\DocBlock\AttributeFormatter;
use Dkplus\Reflection\DocBlock\MultiTagAttributeFormatter;
use phpDocumentor\Reflection\Types\ContextFactory;
use PhpSpec\ObjectBehavior;

class MultiTagAttributeFormatterSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith([]);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MultiTagAttributeFormatter::class);
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
        $this->shouldHaveType(MultiTagAttributeFormatter::class);
    }

    function its_default_tags_can_format_the_author_tag()
    {
        $context = (new ContextFactory())->createForNamespace(__NAMESPACE__, '');
        $this->beConstructedThrough('forDefaultTags');
        $this
            ->format('author', ['My Name <my.name@example.com>'], $context)
            ->shouldBe(['name' => 'My Name', 'emailAddress' => 'my.name@example.com']);
        $this
            ->format('author', ['My Name'], $context)
            ->shouldBe(['name' => 'My Name']);
    }

    function its_default_tags_can_format_the_copyright_tag()
    {

        $context = (new ContextFactory())->createForNamespace(__NAMESPACE__, '');
        $this->beConstructedThrough('forDefaultTags');
        $this
            ->format('copyright', ['1997-2005 The PHP Group'], $context)
            ->shouldBe(['description' => '1997-2005 The PHP Group']);
    }

    function its_default_tags_can_format_the_deprecated_tag()
    {
        $context = (new ContextFactory())->createForNamespace(__NAMESPACE__, '');
        $this->beConstructedThrough('forDefaultTags');
        $this
            ->format('deprecated', ['1.0.0'], $context)
            ->shouldBe(['version' => '1.0.0', 'description' => '']);
        $this
            ->format('deprecated', ['No longer used by internal code and not recommended.'], $context)
            ->shouldBe(['description' => 'No longer used by internal code and not recommended.']);
        $this
            ->format('deprecated', ['1.0.0 No longer used by internal code and not recommended.'], $context)
            ->shouldBe(['version' => '1.0.0', 'description' => 'No longer used by internal code and not recommended.']);
    }

    function its_default_tags_can_format_the_ignore_tag()
    {
        $context = (new ContextFactory())->createForNamespace(__NAMESPACE__, '');
        $this->beConstructedThrough('forDefaultTags');
        $this
            ->format('ignore', ['Some description'], $context)
            ->shouldBe(['description' => 'Some description']);
        $this
            ->format('ignore', [], $context)
            ->shouldBe(['description' => '']);
    }

    function its_default_tags_can_format_the_internal_tag()
    {
        $context = (new ContextFactory())->createForNamespace(__NAMESPACE__, '');
        $this->beConstructedThrough('forDefaultTags');
        $this
            ->format('internal', ['Some description'], $context)
            ->shouldBe(['description' => 'Some description']);
        $this
            ->format('internal', [], $context)
            ->shouldBe(['description' => '']);
    }

    function its_default_tags_can_format_the_license_tag()
    {
        $context = (new ContextFactory())->createForNamespace(__NAMESPACE__, '');
        $this->beConstructedThrough('forDefaultTags');
        $this
            ->format('license', ['GPL'], $context)
            ->shouldBe(['name' => 'GPL']);
        $this
            ->format('license', ['http://opensource.org/licenses/gpl-license.php GNU Public License'], $context)
            ->shouldBe(['url' => 'http://opensource.org/licenses/gpl-license.php', 'name' => 'GNU Public License']);
    }
}
