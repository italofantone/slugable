<?php

namespace Italofantone\Slugable;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

trait Slugable
{
    public static function bootSlugable()
    {
        static::creating(function (Model $model) {
            $model->generateSlug();            
        });

        static::updating(function (Model $model) {
            $model->generateSlug();
        });
    }

    protected function generateSlug(): void
    {
        $field = $this->getSlugSourceField();

        if (!$this->isFillableField($field)) {
            throw new InvalidArgumentException("The field [{$field}] is not fillable.");
        }

        $slug = Str::slug($this->{$field}, config('slugable.separator'));
        $originalSlug = $slug;

        $count = 1;

        while ($this->slugAlreadyExists($slug)) {
            $slug = $originalSlug . '-' . $count++;
        }

        $this->slug = $slug;
    }

    protected function slugAlreadyExists(string $slug): bool
    {
        return static::where('slug', $slug)
            ->where('id', '!=', $this->id)
            ->exists();
    }

    protected function getSlugSourceField(): string
    {
        return property_exists($this, 'slugSourceField') ? $this->slugSourceField : 'title';
    }

    protected function isFillableField(string $field): bool
    {
        return in_array($field, $this->getFillable(), true);
    }
}