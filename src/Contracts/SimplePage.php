<?php

namespace Kurious7\SimplePages\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface SimplePage
{
    public function scopeVisibleInMenu(Builder $query): Builder;

    public function scopePublished(Builder $query): Builder;
}
