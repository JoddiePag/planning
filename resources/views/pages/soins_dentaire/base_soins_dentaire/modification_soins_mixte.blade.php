@extends('pages.soins_dentaire.base_soins_dentaire.base_soins')


@php
    $imagePath = 'images/DentMixte.png';
    $mapAreas = [
        ['shape' => 'rect', 'coords' => '10,80,65,240', 'alt' => 'Dent 18', 'data-dent' => '18'],
        ['shape' => 'rect', 'coords' => '65,70,120,240', 'alt' => 'Dent 17', 'data-dent' => '17'],
        ['shape' => 'rect', 'coords' => '120,70,175,240', 'alt' => 'Dent 16', 'data-dent' => '16'],
        ['shape' => 'rect', 'coords' => '175,70,230,240', 'alt' => 'Dent 15', 'data-dent' => '15'],
        ['shape' => 'rect', 'coords' => '230,70,270,240', 'alt' => 'Dent 14', 'data-dent' => '14'],
        ['shape' => 'rect', 'coords' => '270,70,310,240', 'alt' => 'Dent 13', 'data-dent' => '13'],
        ['shape' => 'rect', 'coords' => '310,70,345,240', 'alt' => 'Dent 12', 'data-dent' => '12'],
        ['shape' => 'rect', 'coords' => '345,70,390,240', 'alt' => 'Dent 11', 'data-dent' => '11'],
      
        // ... toutes les autres coordonnées pour les dents permanentes

    ];
@endphp