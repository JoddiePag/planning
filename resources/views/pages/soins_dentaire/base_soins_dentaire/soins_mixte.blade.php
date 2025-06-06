@extends('pages.soins_dentaire.base_soins_dentaire.base_soins')

@php
    $imagePath = 'images/DentMixte.png'; // Votre image de dentition mixte

    // ATTENTION : Les coordonnées 'coords' ci-dessous sont des EXEMPLES et doivent
    // être ajustées pour correspondre précisément à la disposition des dents sur votre image 'DentMixte.png'.
    // La numérotation des dents (data-dent) est correcte pour les dents de lait.
    $mapAreas = [
        // Quadrant 5 (Maxillaire Supérieur Droit - dents de lait)
        ['shape' => 'rect', 'coords' => '50,100,100,200', 'alt' => 'Dent 55', 'data-dent' => '55'], // Secondaire Molaire
        ['shape' => 'rect', 'coords' => '105,100,155,200', 'alt' => 'Dent 54', 'data-dent' => '54'], // Première Molaire
        ['shape' => 'rect', 'coords' => '160,100,210,200', 'alt' => 'Dent 53', 'data-dent' => '53'], // Canine
        ['shape' => 'rect', 'coords' => '215,100,265,200', 'alt' => 'Dent 52', 'data-dent' => '52'], // Incisive Latérale
        ['shape' => 'rect', 'coords' => '270,100,320,200', 'alt' => 'Dent 51', 'data-dent' => '51'], // Incisive Centrale

        // Quadrant 6 (Maxillaire Supérieur Gauche - dents de lait)
        ['shape' => 'rect', 'coords' => '325,100,375,200', 'alt' => 'Dent 61', 'data-dent' => '61'], // Incisive Centrale
        ['shape' => 'rect', 'coords' => '380,100,430,200', 'alt' => 'Dent 62', 'data-dent' => '62'], // Incisive Latérale
        ['shape' => 'rect', 'coords' => '435,100,485,200', 'alt' => 'Dent 63', 'data-dent' => '63'], // Canine
        ['shape' => 'rect', 'coords' => '490,100,540,200', 'alt' => 'Dent 64', 'data-dent' => '64'], // Première Molaire
        ['shape' => 'rect', 'coords' => '545,100,595,200', 'alt' => 'Dent 65', 'data-dent' => '65'], // Seconde Molaire

        // Quadrant 8 (Mandibule Inférieur Droit - dents de lait)
        ['shape' => 'rect', 'coords' => '50,300,100,400', 'alt' => 'Dent 85', 'data-dent' => '85'], // Seconde Molaire
        ['shape' => 'rect', 'coords' => '105,300,155,400', 'alt' => 'Dent 84', 'data-dent' => '84'], // Première Molaire
        ['shape' => 'rect', 'coords' => '160,300,210,400', 'alt' => 'Dent 83', 'data-dent' => '83'], // Canine
        ['shape' => 'rect', 'coords' => '215,300,265,400', 'alt' => 'Dent 82', 'data-dent' => '82'], // Incisive Latérale
        ['shape' => 'rect', 'coords' => '270,300,320,400', 'alt' => 'Dent 81', 'data-dent' => '81'], // Incisive Centrale

        // Quadrant 7 (Mandibule Inférieur Gauche - dents de lait)
        ['shape' => 'rect', 'coords' => '325,300,375,400', 'alt' => 'Dent 71', 'data-dent' => '71'], // Incisive Centrale
        ['shape' => 'rect', 'coords' => '380,300,430,400', 'alt' => 'Dent 72', 'data-dent' => '72'], // Incisive Latérale
        ['shape' => 'rect', 'coords' => '435,300,485,400', 'alt' => 'Dent 73', 'data-dent' => '73'], // Canine
        ['shape' => 'rect', 'coords' => '490,300,540,400', 'alt' => 'Dent 74', 'data-dent' => '74'], // Première Molaire
        ['shape' => 'rect', 'coords' => '545,300,595,400', 'alt' => 'Dent 75', 'data-dent' => '75'], // Seconde Molaire
    ];
@endphp