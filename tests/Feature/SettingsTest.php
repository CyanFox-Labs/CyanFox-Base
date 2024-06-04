<?php

namespace Tests\Feature;

use App\Facades\Utils\SettingsManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SettingsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function can_set_and_get_setting(): void
    {
        SettingsManager::setSetting('test', 'value');
        if (SettingsManager::getSetting('test') === 'value') {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    #[Test]
    public function can_set_and_get_encrypted_setting(): void
    {
        SettingsManager::setSetting('test', 'value', true);
        if (SettingsManager::getSetting('test', true) === 'value') {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    #[Test]
    public function can_update_setting(): void
    {
        SettingsManager::setSetting('test', 'value');
        SettingsManager::updateSetting('test', 'new_value');
        if (SettingsManager::getSetting('test') === 'new_value') {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    #[Test]
    public function can_update_encrypted_setting(): void
    {
        SettingsManager::setSetting('test', 'value', true);
        SettingsManager::updateSetting('test', 'new_value', true);
        if (SettingsManager::getSetting('test', true) === 'new_value') {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }

    #[Test]
    public function can_delete_setting(): void
    {
        SettingsManager::setSetting('test', 'value');
        SettingsManager::deleteSetting('test');
        if (SettingsManager::getSetting('test') === null) {
            $this->assertTrue(true);
        } else {
            $this->fail();
        }
    }
}
