# About Slugable

Is a PHP library designed to simplify and automate the creation of URL-friendly slugs based on Laravel.

> ⚠️ This code was used for educational purposes [...]

### Installation

You can install the slugable package via composer. Run the following command:

```
composer require italofantone/slugable
```

### Usage

1. Add the trait to your model:

To use the Slugable functionality, include the Slugable trait in your Eloquent model. Here's an example:

```
<?php

namespace App\Models;

use Italofantone\Slugable\Slugable;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use Slugable;

    protected $fillable = ['title', 'body'];
}
```

2. Customize the separator:

You can customize the slug separator in the `config/slugable.php` file. For example:

```
<?php

return [
    
    /**
     * The field that will be used to generate the slug.
     * e.g. 'my title' will be converted to 'my-title'.
     * 
     * Default: '-'.
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

use Italofantone\Slugable\Slugable;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use Slugable;

    protected $fillable = ['name', 'body'];

    protected $slugSourceField = 'name';
}
```

With this configuration, the slug will be generated based on the `name` attribute.