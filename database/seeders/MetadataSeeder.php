<?php

namespace Cmdtaz\Metadata\Database\Seeders;

use Cmdtaz\Metadata\Models\Metadata;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class MetadataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        Metadata::create([
            'name' => $faker->word,
        ]);
    }
}
