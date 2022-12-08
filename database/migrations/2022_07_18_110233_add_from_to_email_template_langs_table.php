<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFromToEmailTemplateLangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('email_template_langs', function (Blueprint $table) {
           $table->string('from')->nullable()->after('subject');
        });
    }


    public function down()
    {
        Schema::table('email_template_langs', function (Blueprint $table) {
            //
        });
    }
}
