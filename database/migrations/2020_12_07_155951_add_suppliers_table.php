<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Marshmallow\HelperFunctions\Traits\MigrationHelper;

class AddSuppliersTable extends Migration
{
    use MigrationHelper;

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        $this->createColumnIfDoesntExist(
            'products', 'supplier_id', function (Blueprint $table) {
                $table->unsignedBigInteger('supplier_id')->nullable()->default(null)->after('product_category_id');
                $table->foreign('supplier_id')->references('id')->on('suppliers');
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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('supplier_id');
        });
    }
}
