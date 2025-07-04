<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('dentistes', function (Blueprint $table) {
        $table->string('avatar')->nullable()->after('numero');
    });
}

public function down()
{
    Schema::table('dentistes', function (Blueprint $table) {
        $table->dropColumn('avatar');
    });
}
    
};
