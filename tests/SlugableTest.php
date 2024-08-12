<?php

namespace Italofantone\Slugable\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Italofantone\Slugable\Tests\Models\TestModel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class SlugableTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_generates_slug_on_create()
    {
        $title = 'My First Model';
        
        $model = TestModel::create(['title' => $title]);

        $this->assertEquals(Str::slug($title), $model->slug);
    }

    public function test_it_updates_slug_on_update()
    {
        $model = TestModel::create(['title' => 'Old Title']);

        $newTitle = 'Updated Title';
        $model->title = $newTitle;
        $model->save();

        $this->assertEquals(Str::slug($newTitle), $model->slug);
    }

    public function test_it_generates_unique_slug_on_create()
    {
        $title = 'Unique Title';
        $model_1 = TestModel::create(['title' => $title]);

        $model_2 = TestModel::create(['title' => $title]);

        $this->assertEquals(Str::slug($title), $model_1->slug);

        $this->assertEquals(Str::slug($title) . '-1', $model_2->slug);
    }

    public function test_it_generates_unique_slug_on_update()
    {
        $model = TestModel::create(['title' => 'Initial Title']);

        $existingTitle = 'Existing Title';
        TestModel::create(['title' => $existingTitle]);

        $model->title = $existingTitle;
        $model->save();

        $expectedSlug = Str::slug($existingTitle) . '-1';
        $this->assertEquals($expectedSlug, $model->slug);
    }  
    
    public function test_it_throws_exception_if_slug_source_field_is_not_fillable()
    {
        $model = new class extends TestModel {
            protected $slugSourceField = 'non_existent_field';

            public function generateSlug(): void
            {
                parent::generateSlug();
            }
        };

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("The field [non_existent_field] is not fillable.");

        $model->generateSlug();
    }

    public function test_it_generates_slug_with_custom_separator_on_create()
    {
        Config::set('slugable.separator', '+');

        $title = 'My First Model';

        $model = TestModel::create(['title' => $title]);

        $this->assertEquals(Str::slug($title, '+'), $model->slug);
    }
}