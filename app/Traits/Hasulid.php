<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Symfony\Component\Uid\Ulid;
use Illuminate\Database\Eloquent\Model;

trait hasulid
{
    public static function boothasulid(): void
    {
        static::creating(function (Model $model): void {
            /** @phpstan-ignore-next-line */
            if (! $model->ulid) {
                $model->ulid = (string) Str::ulid();
            }
        });
    }

    public function getRouteKeyName(): string
    {
        return 'ulid';
    }
}
