<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateProductOcsTable.
 */
class CreateProductOcsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('Product_oc', function(Blueprint $table) {
			//$uuid = DB::raw('(UUID())');
            $table->char('sku', 30);
            $table->char('ocno', 15);
            $table->date('oc_date')->nullable(true);
			$table->date('oc_date_required')->nullable(true);
			$table->decimal('qty', 19,5)->nullable(true);

            $table->timestamps();

			$table->primary([
				'sku',
				'ocno'
			]);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('product_ocs');
	}
}
