<?php

namespace Tests\Feature\Livewire;

use App\Livewire\UserForm;
use App\Models\UserDetails;
use App\Models\Files;
use Faker\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Livewire\WithFileUploads;
use Tests\TestCase;

class UserFormTest extends TestCase
{
    /** @test */
    public function test_form_submission()
    {

        $testData = [
            'firstname' => 'Ivanov',
            'lastname' => 'Ivan',
            'surname' => 'Ivanovich',
            'birthdate' => '1980-01-01',
            'email' => 'ivanov@example.com',
            'phoneOrEmailFilled' => true,
            'selectedstatus' => '1',
            'aboutme' => 'Some information about me',
            'agreement' => 1,
            'files' => [],
            'phonenumbers' => [
                ["countrycode" => "+375", "phone" => "22-222-22-22"],
                ["countrycode" => "+7", "phone" => "3333-333-333"]
            ]
        ];

        $component = Livewire::test(UserForm::class)
            ->set($testData);

        $component->call('submit');

        $component->assertSee('Форма успешно отправлена!');

    }
}
