<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrate data
        $designs = \Illuminate\Support\Facades\DB::table('designs')->get();
        foreach ($designs as $design) {
            \Illuminate\Support\Facades\DB::table('design_design_category')->insert([
                'design_id' => $design->id,
                'design_category_id' => $design->design_category_id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Schema::table('designs', function (Blueprint $table) {
            $table->dropForeign(['design_category_id']);
            $table->dropColumn('design_category_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designs', function (Blueprint $table) {
            $table->foreignId('design_category_id')->nullable()->constrained('design_categories')->cascadeOnDelete();
        });

        // Migrate data back
        $pivots = \Illuminate\Support\Facades\DB::table('design_design_category')->get();
        foreach ($pivots as $pivot) {
            \Illuminate\Support\Facades\DB::table('designs')->where('id', $pivot->design_id)->update(['design_category_id' => $pivot->design_category_id]);
        }
    }
};
