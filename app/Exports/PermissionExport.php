<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Spatie\Permission\Models\Permission;

class PermissionExport implements FromCollection
{
    public function collection(): Collection
    {
        return Permission::select('name', 'guard_name', 'group_name')->get();
    }
}
