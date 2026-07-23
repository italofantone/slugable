<?php

namespace Italofantone\Sluggable\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Italofantone\Sluggable\Sluggable;

class UuidTestModel extends Model
{
    use Sluggable;

    protected $table = 'uuid_test_models';

    protected $primaryKey = 'uuid';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = ['uuid', 'title'];
}
