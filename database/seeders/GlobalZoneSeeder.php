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
        | 1. Cairo & Giza Zones (Previously Added + New)
        |==================================
        */
        $cairoZones = [
            ['name' => 'Downtown Cairo', 'category' => 'Commercial', 'latitude' => 30.0444, 'longitude' => 31.2357, 'radius' => 800, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'medium', 'is_automatic' => true],
            ['name' => 'Zamalek', 'category' => 'Residential', 'latitude' => 30.0626, 'longitude' => 31.2197, 'radius' => 900, 'type' => 'safe', 'crowd_level' => 'medium', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Maadi', 'category' => 'Residential', 'latitude' => 29.9653, 'longitude' => 31.2761, 'radius' => 900, 'type' => 'safe', 'crowd_level' => 'medium', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'New Cairo', 'category' => 'Residential', 'latitude' => 30.0169, 'longitude' => 31.4607, 'radius' => 1200, 'type' => 'safe', 'crowd_level' => 'low', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Helwan Industrial Area', 'category' => 'Industrial', 'latitude' => 29.8448, 'longitude' => 31.2961, 'radius' => 1000, 'type' => 'high_alert', 'crowd_level' => 'low', 'lighting' => 'poor', 'is_automatic' => true],
            ['name' => 'Ezbet El Haggana', 'category' => 'High-Density', 'latitude' => 30.0450, 'longitude' => 31.2765, 'radius' => 900, 'type' => 'high_alert', 'crowd_level' => 'high', 'lighting' => 'poor', 'is_automatic' => true],
            ['name' => 'Garden City', 'category' => 'Residential', 'latitude' => 30.0385, 'longitude' => 31.2312, 'radius' => 850, 'type' => 'safe', 'crowd_level' => 'medium', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Ain Shams', 'category' => 'Residential', 'latitude' => 30.1270, 'longitude' => 31.3300, 'radius' => 1100, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'moderate', 'is_automatic' => true],
            ['name' => 'El Marg', 'category' => 'Residential', 'latitude' => 30.1606, 'longitude' => 31.3386, 'radius' => 1200, 'type' => 'high_alert', 'crowd_level' => 'medium', 'lighting' => 'poor', 'is_automatic' => true],
            ['name' => 'El Matareya', 'category' => 'Residential', 'latitude' => 30.1217, 'longitude' => 31.3133, 'radius' => 1000, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'moderate', 'is_automatic' => true],
            ['name' => 'Abbasia', 'category' => 'Commercial', 'latitude' => 30.0727, 'longitude' => 31.2778, 'radius' => 900, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Mokattam', 'category' => 'Residential', 'latitude' => 30.0107, 'longitude' => 31.3035, 'radius' => 1100, 'type' => 'moderate', 'crowd_level' => 'medium', 'lighting' => 'moderate', 'is_automatic' => true],
            ['name' => 'Basateen', 'category' => 'Residential', 'latitude' => 29.9850, 'longitude' => 31.2770, 'radius' => 1000, 'type' => 'high_alert', 'crowd_level' => 'medium', 'lighting' => 'poor', 'is_automatic' => true],
            ['name' => 'Shubra El Kheima', 'category' => 'Industrial', 'latitude' => 30.1220, 'longitude' => 31.2450, 'radius' => 1200, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'moderate', 'is_automatic' => true],
            ['name' => 'Tahrir Square', 'category' => 'Commercial', 'latitude' => 30.0444, 'longitude' => 31.2357, 'radius' => 800, 'type' => 'moderate', 'crowd_level' => 'very_high', 'lighting' => 'good', 'is_automatic' => true],
        ];

        /*
        |==================================
        | 2. Mansoura Zones
        |==================================
        */
        $mansouraZones = [
            ['name' => 'Mansoura Downtown', 'category' => 'Commercial', 'latitude' => 31.0404, 'longitude' => 31.3785, 'radius' => 700, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'medium', 'is_automatic' => true],
            ['name' => 'Mansoura University Area', 'category' => 'Commercial', 'latitude' => 31.0421, 'longitude' => 31.3586, 'radius' => 800, 'type' => 'safe', 'crowd_level' => 'high', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Talkha Area', 'category' => 'Residential', 'latitude' => 31.0539, 'longitude' => 31.3778, 'radius' => 900, 'type' => 'moderate', 'crowd_level' => 'medium', 'lighting' => 'medium', 'is_automatic' => true],
            ['name' => 'Industrial Mansoura', 'category' => 'Industrial', 'latitude' => 31.0565, 'longitude' => 31.3630, 'radius' => 1000, 'type' => 'high_alert', 'crowd_level' => 'low', 'lighting' => 'poor', 'is_automatic' => true],
            ['name' => 'Mansoura Popular Area', 'category' => 'High-Density', 'latitude' => 31.0380, 'longitude' => 31.3790, 'radius' => 900, 'type' => 'high_alert', 'crowd_level' => 'high', 'lighting' => 'poor', 'is_automatic' => true],
            ['name' => 'Mansoura Residential District', 'category' => 'Residential', 'latitude' => 31.0410, 'longitude' => 31.3770, 'radius' => 700, 'type' => 'safe', 'crowd_level' => 'medium', 'lighting' => 'good', 'is_automatic' => true],
        ];

        /*
        |==================================
        | 3. El Mahalla El Kubra Zones (New)
        |==================================
        */
        $mahallaZones = [
            ['name' => 'Al Gomhoria Street', 'category' => 'Commercial', 'latitude' => 30.9744, 'longitude' => 31.1697, 'radius' => 700, 'type' => 'moderate', 'crowd_level' => 'medium', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Ghazl El Mahalla Stadium Area', 'category' => 'Commercial', 'latitude' => 30.9606, 'longitude' => 31.1728, 'radius' => 800, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Abu Rady Residential Area', 'category' => 'Residential', 'latitude' => 30.9782, 'longitude' => 31.1701, 'radius' => 700, 'type' => 'safe', 'crowd_level' => 'medium', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'El Bahr Street', 'category' => 'Commercial', 'latitude' => 30.9719, 'longitude' => 31.1675, 'radius' => 900, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Al Shoun Square', 'category' => 'Commercial', 'latitude' => 30.9707, 'longitude' => 31.1651, 'radius' => 650, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Shoukry El Koutli Street', 'category' => 'Commercial', 'latitude' => 30.9725, 'longitude' => 31.1681, 'radius' => 700, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Midan El Bandar', 'category' => 'Commercial', 'latitude' => 30.9712, 'longitude' => 31.1668, 'radius' => 650, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Nouman El Aasar Street', 'category' => 'Commercial', 'latitude' => 30.9730, 'longitude' => 31.1647, 'radius' => 700, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'moderate', 'is_automatic' => true],
            ['name' => 'Mahalla Central Hospital Area', 'category' => 'Commercial', 'latitude' => 30.9721, 'longitude' => 31.1705, 'radius' => 800, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'El Nasr Street', 'category' => 'Commercial', 'latitude' => 30.9749, 'longitude' => 31.1698, 'radius' => 700, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Talat Harb Street', 'category' => 'Commercial', 'latitude' => 30.9726, 'longitude' => 31.1682, 'radius' => 750, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Al Mahjoub Residential Lanes', 'category' => 'Residential', 'latitude' => 30.9751, 'longitude' => 31.1718, 'radius' => 550, 'type' => 'moderate', 'crowd_level' => 'low', 'lighting' => 'moderate', 'is_automatic' => true],
            ['name' => 'Al Mahalla Secondary School Area', 'category' => 'Residential', 'latitude' => 30.9769, 'longitude' => 31.1684, 'radius' => 600, 'type' => 'safe', 'crowd_level' => 'medium', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Al Zahraa Residential Block', 'category' => 'Residential', 'latitude' => 30.9798, 'longitude' => 31.1687, 'radius' => 650, 'type' => 'safe', 'crowd_level' => 'low', 'lighting' => 'moderate', 'is_automatic' => true],
            ['name' => 'El Ragby Crowded Area', 'category' => 'Residential', 'latitude' => 30.9728, 'longitude' => 31.1733, 'radius' => 750, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'poor', 'is_automatic' => true],
            ['name' => 'Abu Ali Street Market', 'category' => 'Commercial', 'latitude' => 30.9712, 'longitude' => 31.1701, 'radius' => 850, 'type' => 'high_alert', 'crowd_level' => 'high', 'lighting' => 'poor', 'is_automatic' => true],
            ['name' => 'Souq El Gomaa Street Market', 'category' => 'Commercial', 'latitude' => 30.9731, 'longitude' => 31.1685, 'radius' => 900, 'type' => 'high_alert', 'crowd_level' => 'high', 'lighting' => 'poor', 'is_automatic' => true],
            ['name' => 'El Abbasy District', 'category' => 'Residential', 'latitude' => 30.9756, 'longitude' => 31.1714, 'radius' => 750, 'type' => 'safe', 'crowd_level' => 'medium', 'lighting' => 'good', 'is_automatic' => true],
            ['name' => 'Manshiyet El Bakry', 'category' => 'Residential', 'latitude' => 30.9746, 'longitude' => 31.1721, 'radius' => 750, 'type' => 'moderate', 'crowd_level' => 'high', 'lighting' => 'moderate', 'is_automatic' => true],
            ['name' => 'El Sheshtawy Area', 'category' => 'Residential', 'latitude' => 30.9763, 'longitude' => 31.1710, 'radius' => 700, 'type' => 'moderate', 'crowd_level' => 'medium', 'lighting' => 'good', 'is_automatic' => true],
        ];

        // Merge all zones and insert
        $allZones = array_merge($cairoZones, $mansouraZones, $mahallaZones);

        foreach ($allZones as $zoneData) {
            Zone::create($zoneData);
        }
    }
}