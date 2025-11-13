<?php

namespace Database\Factories;

use App\Models\BienImmobilier;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BienImmobilierFactory extends Factory
{
    protected $model = BienImmobilier::class;

    public function definition(): array
    {
        return [
            'titre'           => fake()->catchPhrase(),
            'prix'            => fake()->numberBetween(50_000, 900_000),
            'adresse'         => fake()->address(),
            'type'            => fake()->randomElement(['MAISON', 'APPARTEMENT', 'VILLA', 'TERRAIN', 'COMMERCIAL']),
            'statut'          => fake()->randomElement(['disponible', 'loue', 'vendu', 'reserve']),
            'description'     => fake()->text(300),
            'date_creation'   => fake()->date(),
            'proprietaire_id' => User::where('role', 'proprietaire')->inRandomOrder()->first()->id ?? 1,
        ];
    }
}
