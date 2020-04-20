<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;
    /**
     * User can view their own profile no matter of public settings
     */
    public function testUserCanViewTheirProfile()
    {
        $privateUser = factory(User::class)->create([
            'public' => false,
        ]);

        $response = $this
            ->actingAs($privateUser)
            ->get($privateUser->getPersonalPageLink());

        $this->assertCommonData($response, $privateUser);


        $publicUser = factory(User::class)->create([
            'public' => true,
        ]);

        $response = $this
            ->actingAs($publicUser)
            ->get($publicUser->getPersonalPageLink());

        $this->assertCommonData($response, $publicUser);
    }


    public function testUserProfileCanBeViewedIfPublic() {
        $user = factory(User::class)->create([
            'public' => true,
        ]);
        $userObserver = factory(User::class)->create();


        // Acting as guest
        $response = $this->get($user->getPersonalPageLink());

        $response->assertStatus(Response::HTTP_OK);


        // Acting as another user
        $response = $this->actingAs($userObserver)
            ->get($user->getPersonalPageLink());

        $response->assertStatus(Response::HTTP_OK);
    }

    public function testUserProfileCanNotBeViewedIfPrivate() {
        $user = factory(User::class)->create([
            'public' => false,
        ]);
        $userObserver = factory(User::class)->create();

        // Acting as guest
        $response = $this->get($user->getPersonalPageLink());

        $response->assertStatus(Response::HTTP_NOT_FOUND);


        // Acting as another user
        $response = $this->actingAs($userObserver)
            ->get($user->getPersonalPageLink());

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function assertCommonData($response, $user) {
        $response->assertStatus(Response::HTTP_OK)
            ->assertSeeText($user->name)
            ->assertDontSeeText($user->email);
    }
}
