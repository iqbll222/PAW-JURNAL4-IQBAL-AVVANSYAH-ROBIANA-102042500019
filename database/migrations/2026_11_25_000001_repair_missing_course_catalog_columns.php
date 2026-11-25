<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('courses')) {
            return;
        }

        $missingColumns = [];

        foreach (['deskripsi', 'sks', 'semester'] as $column) {
            if (!Schema::hasColumn('courses', $column)) {
                $missingColumns[] = $column;
            }
        }

        if ($missingColumns === []) {
            return;
        }

        Schema::table('courses', function (Blueprint $table) use ($missingColumns) {
            if (in_array('deskripsi', $missingColumns, true)) {
                $table->text('deskripsi')->nullable()->after('nama_mk');
            }

            if (in_array('sks', $missingColumns, true)) {
                $table->unsignedTinyInteger('sks')->default(3)->after('deskripsi');
            }

            if (in_array('semester', $missingColumns, true)) {
                $table->string('semester', 50)->default('Belum Ditentukan')->after('sks');
            }
        });
    }

    public function down(): void
    {
        // These columns are part of the base schema on fresh installations, so rollback must not remove them.
    }
};
