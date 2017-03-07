<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Domain\People\Person::class, function (Faker\Generator $faker) {

    return [
        'name'			=> $faker->name,
        'iqcs_number' 	=> $faker->unique()->randomNumber,
        'first_name'	=> $faker->firstName,
        'last_name'		=> $faker->lastName,
        'bio'			=> $faker->paragraph(4),
        'has_purchase'_card => $faker->boolean,
        'created_at'	=> $faker->dateTimeThisYear(),
        'updated_at'	=> $faker->dateTimeThisMonth(),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Domain\Items\Item::class, function (Faker\Generator $faker) {

	$accountableCategories = [
		'BK Radio',
		'Belt Buckle',
		'Binoculars',
		'Computer',
		'GPS (Handheld)',
		'Headlamp',
		'Line Gear',
		'STIHL Chainsaw',
		'Sleeping Bag',
		'Tent',
		'Yale Key',
	];

	$bulkCategories = [
		'Blue Tarp',
		'Camp Cup',
		'Compass',
		'Hardhat',
		'Packout Bag',
		'Signal Mirror',
		'Sling Psychrometer',
	];


	$type = $faker->randomElement(['accountable', 'bulk']);
	$size = $faker->randomElement(['small', 'md', 'lg', 'xl', '34-38 Reg']);
	$condition = $faker->randomElement(['new 2016', 'loose connections', 'needs service']);

	switch($type) {

		case 'accountable':
		    return [
		        'crew_id'				=> 1,
		        'parent_id' 			=> null
		        'serial_number'			=> $faker->bothify('src-###'),
		        'quantity'				=> null,
		        'type'					=> $type,
		        'category'				=> $faker->randomElement($accountableCategories),
		        'color'					=> $faker->safeColorName,
		        'size'					=> $faker->size,
		        'description' 			=> $faker->sentence(9),
		        'checked_out_to_id'		=> null,
		        'checked_out_to_type'	=> null,
		        'note'					=> $faker->sentence(4),
		        'usable'				=> $faker->boolean,
		        'restock_trigger'		=> null,
		        'restock_to_quantity'	=> null,
		        'source'				=> $faker->url,
		        'condition'				=> $condition,
		        'created_at'			=> $faker->dateTimeThisYear(),
		        'updated_at'			=> $faker->dateTimeThisMonth(),
		    ];
		    break;

		case 'bulk':
			return [
				'crew_id'				=> 1,
		        'parent_id' 			=> null,
		        'serial_number'			=> null,
		        'quantity'				=> $faker->numberBetween(0, 30)
		        'type'					=> $type,
		        'category'				=> $faker->randomElement($bulkCategories),
		        'color'					=> $faker->safeColorName,
		        'size'					=> $faker->size,
		        'description' 			=> $faker->sentence(9),
		        'checked_out_to_id'		=> null,
		        'checked_out_to_type'	=> null,
		        'note'					=> $faker->sentence(4),
		        'usable'				=> $faker->boolean,
		        'restock_trigger'		=> $faker->numberBetween(0, 5),
		        'restock_to_quantity'	=> $faker->numberBetween(10, 30),
		        'source'				=> $faker->url,
		        'condition'				=> $condition,
		        'created_at'			=> $faker->dateTimeThisYear(),
		        'updated_at'			=> $faker->dateTimeThisMonth(),
			];
			break;
	}
});
