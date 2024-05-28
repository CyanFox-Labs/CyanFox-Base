<?php

namespace Tests\Feature;

use App\Facades\Utils\UnsplashManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UnsplashTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_get_unsplash_picture()
    {
        $picture = UnsplashManager::getRandomUnsplashImage();

        if (setting('unsplash_api_key', true) == null || setting('unsplash_api_key', true) == '') {
            $this->markTestSkipped('Unsplash API key is not set.');
        }

        if ($picture == null) {
            $this->markTestSkipped('Unsplash is not available.');
        }

        $this->assertIsArray($picture);
    }

    #[Test]
    public function can_get_utm()
    {
        $utm = UnsplashManager::getUTM();

        if ($utm === null) {
            $this->markTestSkipped('UTM is not available.');
        }

        $this->assertIsString($utm);
    }

    #[Test]
    public function can_get_css()
    {
        $css = UnsplashManager::returnBackground();

        if (setting('unsplash_api_key', true) == null || setting('unsplash_api_key', true) == '') {
            $this->markTestSkipped('Unsplash API key is not set.');
        }

        if ($css['error']) {
            $this->fail($css['error']);
        }

        if ($css['photo'] !== null) {
            $this->assertIsString($css['photo']);
        }

        $this->assertIsArray($css);
    }
}
