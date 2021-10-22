<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            //`addressable_id `evolved from `user_id`, this is to make the foreign id morph into
            // whatever table will need this table
            $table->integer('addressable_id');  
            $table->string('addressable_type');
            $table->string('address1');
            $table->string('address2');
            $table->string('suburb');
            $table->string('post_code');
            $table->string('city');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
