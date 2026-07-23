# About Sluggable

Is a PHP library designed to simplify and automate the creation of URL-friendly slugs based on Laravel.

### Installation

You can install the sluggable package via composer. Run the following command:

```
composer require italofantone/sluggable
```

### Usage

1. Add the trait to your model:

To use the Sluggable functionality, include the Sluggable trait in your Eloquent model. Here's an example:

```
<?php

namespace App\Models;

use Italofantone\Sluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use Sluggable;

    protected $fillable = ['title', 'body'];
}
```

The slug is generated on create and recalculated only when the source field changes.

**Migration example**: You need to create the slug field.

```
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body');

            $table->timestamps();
        });
    }

    // ...
};
```

2. Customize the separator: Run the following command.

```
php artisan vendor:publish --tag=sluggable-config
```

You can customize the slug separator in the `config/sluggable.php` file. For example:

```
<?php

return [
    
    /**
     * Separator used when generating slugs.
     * e.g. 'my title' becomes 'my-title' by default.
     */

    'separator' => '-',

];
```

This will change the default separator used in generated slugs.

3. Customizing the slug source field:

You can customize which attribute is used to generate the slug by setting the protected `$slugSourceField` property in your model.

**Example**:

To use the name attribute instead of the default attribute (like title), do the following:

```
<?php

namespace App\Models;

use Italofantone\Sluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use Sluggable;

    protected $fillable = ['name', 'body'];

    protected $slugSourceField = 'name';
}
```

With this configuration, the slug will be generated based on the `name` attribute.

## Contact

- **Email**: [hola@italofantone.com](mailto:hola@italofantone.com).
- **LinkedIn**: [italofantone](https://linkedin.com/in/italofantone).

## Donations

If you find this project useful and would like to support its development, you can make a donation via PayPal:

- **PayPal:** [Donate via PayPal](https://paypal.me/italofantone)

Thank you for your support!
