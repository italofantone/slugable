<?php

namespace Italofantone\Sluggable;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

trait Sluggable
{
    public static function bootSluggable(): void
    {
        static::saving(function (Model $model) {
            if ($model->shouldGenerateSlug()) {
                $model->generateSlug();
            }
        });
    }

    protected function generateSlug(): void
    {
        $field = $this->getSlugSourceField();

        if (! array_key_exists($field, $this->getAttributes())) {
            throw new InvalidArgumentException("The field [{$field}] does not exist on the model.");
        }

        $separator = config('sluggable.separator', '-');
        $slug = Str::slug($this->{$field}, $separator);
        $originalSlug = $slug;

        $count = 1;

        while ($this->slugAlreadyExists($slug)) {
            $slug = $originalSlug . $separator . $count++;
        }

        $this->slug = $slug;
    }

    protected function slugAlreadyExists(string $slug): bool
    {
        $query = static::where('slug', $slug);

        if ($this->getKey() !== null) {
            $query->where($this->getKeyName(), '!=', $this->getKey());
        }

        return $query->exists();
    }

    protected function getSlugSourceField(): string
    {
        return property_exists($this, 'slugSourceField') ? $this->slugSourceField : 'title';
    }

    protected function shouldGenerateSlug(): bool
    {
        $field = $this->getSlugSourceField();

        return ! $this->exists
            || $this->isDirty($field)
            || blank($this->slug);
    }
}
