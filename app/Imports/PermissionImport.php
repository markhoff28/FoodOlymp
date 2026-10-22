<?php

namespace App\Imports;

use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Spatie\Permission\Models\Permission;

class PermissionImport implements ToModel
{
    public function model(array $row): ?Model
    {
        return new Permission([
            'name' => $row[0],
            'guard_name' => $row[1],
            'group_name' => $row[2],
        ]);
    }
}
