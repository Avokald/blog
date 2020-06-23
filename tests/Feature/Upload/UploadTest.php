<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\UploadController;
use Illuminate\Http\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UploadTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testImageUpload()
    {
        $file = new UploadedFile(resource_path('test/image/butterfly.png'), 'buttefly.png', 'image/png', null, true);

        $response = $this->postJson(route(UploadController::IMAGE_PATH_NAME), [
            'file' => $file,
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertSee('url');
    }
}
