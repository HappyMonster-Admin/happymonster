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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('hmb');
            $table->tinyInteger('pa');
            $table->integer('reference')->unique();
            $table->string('article_name', 60)->unique();
            $table->string('documentation')->nullable();
            $table->string('notes', 100)->nullable();
            $table->boolean('turn_over')->default(false);
            $table->boolean('gross_profit')->default(false);
            $table->boolean('bti')->default(false);
            $table->boolean('new')->default(false);
            $table->string('barcode')->nullable()->default(null);
            $table->boolean('sustainable')->default(false);
            $table->string('sustainable_message', 60)->nullable();
            $table->string('image')->nullable();
            $table->tinyInteger('article_length')->nullable();
            $table->tinyInteger('article_width')->nullable();
            $table->tinyInteger('article_height')->nullable();
            $table->tinyInteger('article_diameter')->nullable();
            $table->text('short_description')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->unique();
            $table->boolean('is_visible')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->enum('type', ['deliverable', 'downloadable']) ->default('deliverable');
            $table->string('style_group')->nullable();
            $table->string('designer_unicode')->nullable();
            $table->enum('margin', ['High', 'Medium', 'Low', 'N/A']) ->default('N/A');
            $table->enum('price_level', ['High', 'Medium', 'Low', 'BTI', 'N/A']) ->default('N/A');
            $table->decimal('price', 10, 4);
            $table->decimal('local_price', 10, 4)->nullable();
            $table->date('sales_start_date');
            $table->date('sales_end_date')->nullable();
            $table->tinyInteger('available_stock')->nullable();
            $table->tinyInteger('article_per_package');
            $table->tinyInteger('customer_pack_length')->nullable();
            $table->tinyInteger('customer_pack_width')->nullable();
            $table->tinyInteger('customer_pack_height')->nullable();
            $table->tinyInteger('customer_pack_diameter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
