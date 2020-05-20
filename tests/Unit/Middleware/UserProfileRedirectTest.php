<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UserProfileRedirectTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_is_url_incorrect()
    {
        $user = new \stdClass();
        $user->slug = 'hello';

        $middleware = new \App\Http\Middleware\UserProfileSlugRedirect;

        $this->assertTrue($middleware->isUrlIncorrect(null, null));

        $this->assertTrue($middleware->isUrlIncorrect([], null));

        $this->assertTrue($middleware->isUrlIncorrect([1], null));

        $this->assertTrue($middleware->isUrlIncorrect([1, 'hello'], null));

        $this->assertTrue($middleware->isUrlIncorrect([1, 123], $user));

        $this->assertFalse($middleware->isUrlIncorrect([1, 'hello'], $user));
    }
}
