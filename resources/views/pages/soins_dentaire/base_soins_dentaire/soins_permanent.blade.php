@extends('pages.soins_dentaire.base_soins_dentaire.base_soins')

@php
    $imagePath = 'images/dent_modifier1.png'; // Votre image de dentition permanente
      
    $mapAreas = [
        // Quadrant 1 (Maxillaire Supérieur Droit)
        
        ['shape' => 'rect', 'coords' => '10,80,65,240', 'alt' => 'Dent 18', 'data-dent' => '18'],
        ['shape' => 'rect', 'coords' => '65,70,120,240', 'alt' => 'Dent 17', 'data-dent' => '17'],
        ['shape' => 'rect', 'coords' => '120,70,175,240', 'alt' => 'Dent 16', 'data-dent' => '16'],
        ['shape' => 'rect', 'coords' => '175,70,230,240', 'alt' => 'Dent 15', 'data-dent' => '15'],
        ['shape' => 'rect', 'coords' => '230,70,270,240', 'alt' => 'Dent 14', 'data-dent' => '14'],
        ['shape' => 'rect', 'coords' => '270,70,310,240', 'alt' => 'Dent 13', 'data-dent' => '13'],
        ['shape' => 'rect', 'coords' => '310,70,345,240', 'alt' => 'Dent 12', 'data-dent' => '12'],
        ['shape' => 'rect', 'coords' => '345,70,390,240', 'alt' => 'Dent 11', 'data-dent' => '11'],

        // Quadrant 2 (Maxillaire Supérieur Gauche)
        ['shape' => 'rect', 'coords' => '390,70,427,240', 'alt' => 'Dent 21', 'data-dent' => '21'],
        ['shape' => 'rect', 'coords' => '427,70,470,240', 'alt' => 'Dent 22', 'data-dent' => '22'],
        ['shape' => 'rect', 'coords' => '470,70,510,240', 'alt' => 'Dent 23', 'data-dent' => '23'],
        ['shape' => 'rect', 'coords' => '510,70,548,240', 'alt' => 'Dent 24', 'data-dent' => '24'],
        ['shape' => 'rect', 'coords' => '548,70,592,240', 'alt' => 'Dent 25', 'data-dent' => '25'],
        ['shape' => 'rect', 'coords' => '592,70,650,240', 'alt' => 'Dent 26', 'data-dent' => '26'],
        ['shape' => 'rect', 'coords' => '650,70,705,240', 'alt' => 'Dent 27', 'data-dent' => '27'],
        ['shape' => 'rect', 'coords' => '705,70,770,240', 'alt' => 'Dent 28', 'data-dent' => '28'],

        // Quadrant 4 (Mandibule Inférieur Droit)
        ['shape' => 'rect', 'coords' => '20,240,90,420', 'alt' => 'Dent 48', 'data-dent' => '48'],
        ['shape' => 'rect', 'coords' => '90,240,150,420', 'alt' => 'Dent 47', 'data-dent' => '47'],
        ['shape' => 'rect', 'coords' => '150,240,205,420', 'alt' => 'Dent 46', 'data-dent' => '46'],
        ['shape' => 'rect', 'coords' => '205,240,245,420', 'alt' => 'Dent 45', 'data-dent' => '45'],
        ['shape' => 'rect', 'coords' => '245,240,285,420', 'alt' => 'Dent 44', 'data-dent' => '44'],    
        ['shape' => 'rect', 'coords' => '285,240,315,420', 'alt' => 'Dent 43', 'data-dent' => '43'],
        ['shape' => 'rect', 'coords' => '315,240,350,420', 'alt' => 'Dent 42', 'data-dent' => '42'],
        ['shape' => 'rect', 'coords' => '350,240,387,420', 'alt' => 'Dent 41', 'data-dent' => '41'],
        
        // Quadrant 3 (Mandibule Inférieur Gauche)
        ['shape' => 'rect', 'coords' => '387,240,425,420', 'alt' => 'Dent 31', 'data-dent' => '31'],
        ['shape' => 'rect', 'coords' => '425,240,460,420', 'alt' => 'Dent 32', 'data-dent' => '32'],
        ['shape' => 'rect', 'coords' => '460,240,492,420', 'alt' => 'Dent 33', 'data-dent' => '33'],
        ['shape' => 'rect', 'coords' => '492,240,530,420', 'alt' => 'Dent 34', 'data-dent' => '34'], 
        ['shape' => 'rect', 'coords' => '530,240,570,420', 'alt' => 'Dent 35', 'data-dent' => '35'],
        ['shape' => 'rect', 'coords' => '570,240,625,420', 'alt' => 'Dent 36', 'data-dent' => '36'],
        ['shape' => 'rect', 'coords' => '625,240,680,420', 'alt' => 'Dent 37', 'data-dent' => '37'],
        ['shape' => 'rect', 'coords' => '680,240,735,420', 'alt' => 'Dent 38', 'data-dent' => '38'],
    ];
@endphp