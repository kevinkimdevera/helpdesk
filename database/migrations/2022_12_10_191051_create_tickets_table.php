<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->longText('title');

            $table->longText('summary')->nullable();

            $table->longText('remarks')->nullable();

            $table->integer('rating')->default(0);

            $table->foreignId('category_id')
              ->nullable()
              ->references('id')
              ->on('ticket_categories')
              ->nullOnDelete();

            $table->foreignId('category_type_id')
              ->nullable()
              ->references('id')
              ->on('ticket_category_types')
              ->nullOnDelete();

            $table->longText('other_details')->nullable();

            $table->foreignId('priority_id')
              ->nullable()
              ->references('id')
              ->on('ticket_priorities')
              ->nullOnDelete();

            $table->foreignId('assigned_to_group_id')
              ->nullable()
              ->references('id')
              ->on('groups')
              ->nullOnDelete();

            $table->timestamps();

            $table->foreignId('created_by_user_id')
              ->references('id')
              ->on('users')
              ->cascadeOnDelete();

            $table->dateTime('rated_at')
              ->nullable();

            $table->dateTime('marked_as_spam_at')
              ->nullable();

            $table->foreignId('marked_as_spam_by_user_id')
              ->references('id')
              ->on('users')
              ->cascadeOnDelete();

            $table->softDeletes();

            $table->foreignId('deleted_by_user_id')
              ->references('id')
              ->on('users')
              ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
