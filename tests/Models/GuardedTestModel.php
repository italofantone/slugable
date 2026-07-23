<?php

namespace Italofantone\Sluggable\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Italofantone\Sluggable\Sluggable;

class GuardedTestModel extends Model
{
    use Sluggable;

    protected $table = 'test_models';

    protected $guarded = [];
}
