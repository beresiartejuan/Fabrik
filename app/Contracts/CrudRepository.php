<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;

interface CrudRepository
{
    public function create(array $data): Model;

    public function read();

    public function update();

    public function delete();
}
