<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::dropIfExists('students');
        Schema::dropIfExists('categories'); // We'll recreate this with proper structure
    }

    public function down()
    {
        // No need to recreate these tables in rollback
    }
};
