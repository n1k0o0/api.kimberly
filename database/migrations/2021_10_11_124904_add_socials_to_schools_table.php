<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSocialsToSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->string('inst_link')->nullable()->after('branch_count');
            $table->string('youtube_link')->nullable()->after('inst_link');
            $table->string('vk_link')->nullable()->after('youtube_link');
            $table->string('diagram_link')->nullable()->after('vk_link');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['inst_link', 'youtube_link', 'vk_link', 'diagram_link']);
        });
    }
}
