<?php

namespace App\Contract;

use Illuminate\Database\Eloquent\Collection;

interface APIContract {
    public function all() : Collection;
}