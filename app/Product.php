<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	use \Dimsav\Translatable\Translatable;

	public $translatedAttributes = ['name', 'description'];
	protected $guarded = [];

	protected $appends = ['image_path', 'profite_percent'];

	public function category() {
		return $this->belongsTo(Category::class);
	}

	public function getImagePathAttribute() {
		return asset('/uploads/product_images/' . $this->image);
	}

	public function getProfitePercentAttribute() {
		$profite = $this->sale_price - $this->purchase_price;
		$profite_percent = $profite * 100 / $this->purchase_price;

		return number_format($profite_percent, 2);
	}
}
