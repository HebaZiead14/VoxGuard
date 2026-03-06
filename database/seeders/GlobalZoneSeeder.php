<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zone;

class GlobalZoneSeeder extends Seeder
{
    public function run()
    {
        /*
        |==================================
        | Cairo Zones
        |==================================
        */
        Zone::create([
            'name' => 'Downtown Cairo',
            'category' => 'Commercial',
            'latitude' => 30.0444,
            'longitude' => 31.2357,
            'radius' => 800,
            'type' => 'moderate',
            'crowd_level' => 'high',
            'lighting' => 'medium',
            'is_automatic' => true
        ]);

        Zone::create([
            'name' => 'Zamalek',
            'category' => 'Residential',
            'latitude' => 30.0668,
            'longitude' => 31.2243,
            'radius' => 700,
            'type' => 'safe',
            'crowd_level' => 'medium',
            'lighting' => 'good',
            'is_automatic' => true
        ]);

        Zone::create([
            'name' => 'Maadi',
            'category' => 'Residential',
            'latitude' => 29.9653,
            'longitude' => 31.2761,
            'radius' => 900,
            'type' => 'safe',
            'crowd_level' => 'medium',
            'lighting' => 'good',
            'is_automatic' => true
        ]);

        Zone::create([
            'name' => 'New Cairo',
            'category' => 'Residential',
            'latitude' => 30.0169,
            'longitude' => 31.4607,
            'radius' => 1200,
            'type' => 'safe',
            'crowd_level' => 'low',
            'lighting' => 'good',
            'is_automatic' => true
        ]);

        Zone::create([
            'name' => 'Helwan Industrial Area',
            'category' => 'Industrial',
            'latitude' => 29.8448,
            'longitude' => 31.2961,
            'radius' => 1000,
            'type' => 'high_alert',
            'crowd_level' => 'low',
            'lighting' => 'poor',
            'is_automatic' => true
        ]);

        Zone::create([
            'name' => 'Ezbet El Haggana',
            'category' => 'High-Density',
            'latitude' => 30.0450,
            'longitude' => 31.2765,
            'radius' => 900,
            'type' => 'high_alert',
            'crowd_level' => 'high',
            'lighting' => 'poor',
            'is_automatic' => true
        ]);

        Zone::create([
            'name' => 'Garden City',
            'category' => 'Residential',
            'latitude' => 30.0465,
            'longitude' => 31.2342,
            'radius' => 600,
            'type' => 'safe',
            'crowd_level' => 'low',
            'lighting' => 'good',
            'is_automatic' => true
        ]);

        /*
        |==================================
        | Mansoura Zones
        |==================================
        */
        Zone::create([
            'name' => 'Mansoura Downtown',
            'category' => 'Commercial',
            'latitude' => 31.0404,
            'longitude' => 31.3785,
            'radius' => 700,
            'type' => 'moderate',
            'crowd_level' => 'high',
            'lighting' => 'medium',
            'is_automatic' => true
        ]);

        Zone::create([
            'name' => 'Mansoura University Area',
            'category' => 'Commercial',
            'latitude' => 31.0421,
            'longitude' => 31.3586,
            'radius' => 800,
            'type' => 'safe',
            'crowd_level' => 'high',
            'lighting' => 'good',
            'is_automatic' => true
        ]);

        Zone::create([
            'name' => 'Talkha Area',
            'category' => 'Residential',
            'latitude' => 31.0539,
            'longitude' => 31.3778,
            'radius' => 900,
            'type' => 'moderate',
            'crowd_level' => 'medium',
            'lighting' => 'medium',
            'is_automatic' => true
        ]);

        Zone::create([
            'name' => 'Industrial Mansoura',
            'category' => 'Industrial',
            'latitude' => 31.0565,
            'longitude' => 31.3630,
            'radius' => 1000,
            'type' => 'high_alert',
            'crowd_level' => 'low',
            'lighting' => 'poor',
            'is_automatic' => true
        ]);

        Zone::create([
            'name' => 'Mansoura Popular Area',
            'category' => 'High-Density',
            'latitude' => 31.0380,
            'longitude' => 31.3790,
            'radius' => 900,
            'type' => 'high_alert',
            'crowd_level' => 'high',
            'lighting' => 'poor',
            'is_automatic' => true
        ]);

        Zone::create([
            'name' => 'Mansoura Residential District',
            'category' => 'Residential',
            'latitude' => 31.0410,
            'longitude' => 31.3770,
            'radius' => 700,
            'type' => 'safe',
            'crowd_level' => 'medium',
            'lighting' => 'good',
            'is_automatic' => true
        ]);

    }
}
