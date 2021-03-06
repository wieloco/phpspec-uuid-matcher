<?php

namespace spec\WieloCo\Matcha\Matcher;

use PhpSpec\Exception\Example\FailureException;
use PhpSpec\Matcher\Matcher;
use PhpSpec\ObjectBehavior;
use WieloCo\Matcha\Matcher\BeUuidMatcher;

class BeUuidMatcherSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(BeUuidMatcher::class);
        $this->shouldImplement(Matcher::class);
    }

    public function it_should_return_true_if_call_to_matcher_is_supported()
    {
        $this->supports(BeUuidMatcher::NAME, '', [])->shouldReturn(true);
    }

    public function it_should_return_false_if_call_to_matcher_is_not_supported()
    {
        $this->supports('itDoesNotLookLikeAnythingToMe', '', [])->shouldReturn(false);
    }

    public function it_should_succeed_on_positive_match()
    {
        $this->positiveMatch(BeUuidMatcher::NAME, '7f1052a7-45c1-4009-ad27-8a8648552cd0', [])->shouldReturn(null);
        $this->positiveMatch(BeUuidMatcher::NAME, '00000000-0000-0000-0000-000000000000', [])->shouldReturn(null);
    }

    public function it_should_throw_an_exception_for_failing_positive_match()
    {
        $this->shouldThrow(new FailureException('Expected UUID as response but got \'null\' instead.'))
             ->duringPositiveMatch(BeUuidMatcher::NAME, null, []);

        $array = [0];
        $type = gettype($array);
        $this->shouldThrow(new FailureException("Expected UUID as a string as response but got '{$type}' instead."))
             ->duringPositiveMatch(BeUuidMatcher::NAME, $array, []);

        $this->shouldThrow(new FailureException('Expected valid UUID as response but got \'not-an-uuid\' instead.'))
             ->duringPositiveMatch(BeUuidMatcher::NAME, 'not-an-uuid', []);
    }

    public function it_should_succeed_on_negative_match()
    {
        $this->negativeMatch(BeUuidMatcher::NAME, 'not-an-uuid', [])->shouldReturn(null);
        $this->negativeMatch(BeUuidMatcher::NAME, [0], [])->shouldReturn(null);
        $this->negativeMatch(BeUuidMatcher::NAME, 1, [])->shouldReturn(null);
    }

    public function it_should_throw_an_exception_for_failing_negative_match()
    {
        $this->shouldThrow(FailureException::class)->duringNegativeMatch(BeUuidMatcher::NAME, '7f1052a7-45c1-4009-ad27-8a8648552cd0', []);
        $this->shouldThrow(FailureException::class)->duringNegativeMatch(BeUuidMatcher::NAME, '00000000-0000-0000-0000-000000000000', []);
    }

    public function it_should_have_zero_priority()
    {
        $this->getPriority()->shouldReturn(0);
    }
}
