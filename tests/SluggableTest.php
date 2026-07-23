<?php

namespace Italofantone\Sluggable\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Italofantone\Sluggable\Tests\Models\GuardedTestModel;
use Italofantone\Sluggable\Tests\Models\TestModel;
use Italofantone\Sluggable\Tests\Models\UuidTestModel;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class SluggableTest extends TestCase
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

    public function test_it_keeps_slug_when_unrelated_attributes_change()
    {
        $model = TestModel::create([
            'title' => 'Stable Title',
            'body' => 'Original body',
        ]);

        $originalSlug = $model->slug;

        $model->body = 'Updated body';
        $model->save();

        $this->assertSame($originalSlug, $model->slug);
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
    
    public function test_it_generates_slug_when_source_field_is_guarded()
    {
        $model = GuardedTestModel::create([
            'title' => 'Guarded Title',
        ]);

        $this->assertEquals(Str::slug('Guarded Title'), $model->slug);
    }

    public function test_it_generates_slug_with_custom_separator_on_create()
    {
        Config::set('sluggable.separator', '+');

        $title = 'My First Model';

        $model = TestModel::create(['title' => $title]);

        $this->assertEquals(Str::slug($title, '+'), $model->slug);
    }

    public function test_it_generates_unique_slug_with_custom_primary_key()
    {
        UuidTestModel::create([
            'uuid' => 'uuid-1',
            'title' => 'Shared Title',
        ]);

        $model = UuidTestModel::create([
            'uuid' => 'uuid-2',
            'title' => 'Other Title',
        ]);

        $model->title = 'Shared Title';
        $model->save();

        $this->assertSame('shared-title-1', $model->slug);
    }
}
