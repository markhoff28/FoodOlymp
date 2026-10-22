<?php

namespace Tests\Feature;

use App\Exports\PermissionExport;
use App\Imports\PermissionImport;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PermissionSpreadsheetTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'database.default' => 'spreadsheet_testing',
            'database.connections.spreadsheet_testing' => [
                'driver' => 'sqlite',
                'database' => ':memory:',
                'prefix' => '',
            ],
            'cache.default' => 'array',
        ]);

        Schema::create('permissions', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('guard_name');
            $table->string('group_name')->nullable();
            $table->timestamps();
            $table->unique(['name', 'guard_name']);
        });
    }

    public function test_permissions_can_be_exported_to_xlsx_and_imported_again(): void
    {
        Permission::create([
            'name' => 'course.view',
            'guard_name' => 'web',
            'group_name' => 'Course',
        ]);

        $content = Excel::raw(new PermissionExport, ExcelFormat::XLSX);
        $file = UploadedFile::fake()->createWithContent('permissions.xlsx', $content);
        Permission::query()->delete();

        Excel::import(new PermissionImport, $file);

        $this->assertDatabaseCount('permissions', 1);
        $this->assertDatabaseHas('permissions', [
            'name' => 'course.view',
            'guard_name' => 'web',
            'group_name' => 'Course',
        ]);
    }

    public function test_permissions_can_still_be_imported_from_csv(): void
    {
        $file = UploadedFile::fake()->createWithContent('permissions.csv', "course.view,web,Course\n");

        Excel::import(new PermissionImport, $file);

        $this->assertDatabaseHas('permissions', [
            'name' => 'course.view',
            'group_name' => 'Course',
        ]);
    }
}
