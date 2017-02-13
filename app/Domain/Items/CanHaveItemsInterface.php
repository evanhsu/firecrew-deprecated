<?php

namespace App\Domain\Items;

interface CanHaveItemsInterface {
	public function items();
	public function getFullNameAttribute();
}

