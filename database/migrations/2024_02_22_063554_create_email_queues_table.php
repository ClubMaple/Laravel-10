<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailQueuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_queues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('linkable_id');
            $table->string('linkable_type', 50);
            $table->string('subject', 150);
            $table->string('email', 100);
            $table->string('view', 50);
            $table->json('params');
            $table->enum('status', ['pending', 'processing', 'completed', 'failed']);
            $table->timestamps(); 
            $table->dateTime('sent')->nullable(); 
            $table->unsignedSmallInteger('attempt');
        });
    }

    /**
     * Revertir las migraciones
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('email_queues');
    }
}
