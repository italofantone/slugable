<?php

namespace Italofantone\Slugable\Tests\Models;

use Italofantone\Slugable\Slugable;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use Slugable;

    protected $fillable = ['title'];

    // ...
}