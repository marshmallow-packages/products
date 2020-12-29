<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewProductDefaultColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createColumnIfDoesntExist(
            'products', 'intro', function (Blueprint $table) {
                $table->text('intro')->nullable()->default(null)->after('slug');
            }
        );

        $this->createColumnIfDoesntExist(
            'products', 'images', function (Blueprint $table) {
                $table->json('images')->nullable()->default(null)->after('description');
            }
        );

        $this->createColumnIfDoesntExist(
            'products', 'mpn', function (Blueprint $table) {
                $table->string('mpn')->nullable()->default(null)->after('slug');
            }
        );

        $this->createColumnIfDoesntExist(
            'products', 'gtin', function (Blueprint $table) {
                $table->string('gtin')->nullable()->default(null)->after('slug');
            }
        );

        $this->createColumnIfDoesntExist(
            'products', 'active', function (Blueprint $table) {
                $table->boolean('active')->default(true)->after('images');
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
        	$table->dropColumn('intro');
        	$table->dropColumn('images');
        	$table->dropColumn('mpn');
        	$table->dropColumn('gtin');
            $table->dropColumn('active');
        });
    }
}
