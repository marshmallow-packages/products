<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Marshmallow\HelperFunctions\Traits\MigrationHelper;

class CreateProductTable extends Migration
{
    use MigrationHelper;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('products')) {
            $this->createTable();
        } else {
            $this->updateTable();
        }
    }

    protected function createTable()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    protected function updateTable()
    {
        $this->createColumnIfDoesntExist(
            'products', 'name', function (Blueprint $table) {
                $table->string('name')->after('id')->nullable()->default(null);
            }
        );

        $this->createColumnIfDoesntExist(
            'products', 'slug', function (Blueprint $table) {
                $table->string('slug')->unique()->after('name')->nullable()->default(null);
            }
        );

        $this->createColumnIfDoesntExist(
            'products', 'description', function (Blueprint $table) {
                $table->text('description')->after('slug')->nullable()->default(null);
            }
        );

        $this->createColumnIfDoesntExist(
            'products', 'deleted_at', function (Blueprint $table) {
                $table->softDeletes();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
