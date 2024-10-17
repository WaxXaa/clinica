<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class empleados extends Model
{
    //
    public function users(): BelongsTo {
        return $this->beloingsTo(User::class);
    }

}
