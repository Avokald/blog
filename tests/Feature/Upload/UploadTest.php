<?php

namespace Tests\Feature;

use App\Http\Controllers\Web\UploadController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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

        $filepath = explode('uploads', json_decode($response->getContent())->url);
        $this->print_r([$filepath, public_path('')]);
        $realPath = public_path('/uploads' . $filepath[1]);
        if (is_file($realPath)) {
            $this->print_r('Here');
            $this->print_r(Storage::delete($realPath));
            unlink($realPath);
        }
    }
}
