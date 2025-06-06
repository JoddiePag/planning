<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Planification Soins Dentaires</title>
    <link href="{{ asset('css/soins_dents.css') }}" rel="stylesheet">
</head>
<body>
<div class="main-container">
    <h2></h2>

    <div class="image-container">
        <img src="{{ asset('images/dent_modifier.png') }}" usemap="#dentMap" alt="Dentition Humaine" id="dentImage">
        <div class="highlight" id="dentHighlight"></div>
        <map name="dentMap">
            <area shape="rect" coords="10,80,65,240" alt="Dent 18" href="#" data-dent="18">
            <area shape="rect" coords="65,70,120,240" alt="Dent 17" href="#" data-dent="17">
            <area shape="rect" coords="120,70,175,240" alt="Dent 16" href="#" data-dent="16">
            <area shape="rect" coords="175,70,230,240" alt="Dent 15" href="#" data-dent="15">
            <area shape="rect" coords="230,70,270,240" alt="Dent 14" href="#" data-dent="14">
            <area shape="rect" coords="270,70,310,240" alt="Dent 13" href="#" data-dent="13">
            <area shape="rect" coords="310,70,345,240" alt="Dent 12" href="#" data-dent="12">
            <area shape="rect" coords="345,70,390,240" alt="Dent 11" href="#" data-dent="11">

            <area shape="rect" coords="390,70,427,240" alt="Dent 21" href="#" data-dent="21">
            <area shape="rect" coords="427,70,470,240" alt="Dent 22" href="#" data-dent="22">
            <area shape="rect" coords="470,70,510,240" alt="Dent 23" href="#" data-dent="23">
            <area shape="rect" coords="510,70,548,240" alt="Dent 24" href="#" data-dent="24">
            <area shape="rect" coords="548,70,592,240" alt="Dent 25" href="#" data-dent="25">
            <area shape="rect" coords="592,70,650,240" alt="Dent 26" href="#" data-dent="26">
            <area shape="rect" coords="650,70,705,240" alt="Dent 27" href="#" data-dent="27">
            <area shape="rect" coords="705,70,770,240" alt="Dent 28" href="#" data-dent="28">

            <area shape="rect" coords="20,240,90,420" alt="Dent 48" href="#" data-dent="48">
            <area shape="rect" coords="90,240,150,420" alt="Dent 47" href="#" data-dent="47">
            <area shape="rect" coords="150,240,205,420" alt="Dent 46" href="#" data-dent="46">
            <area shape="rect" coords="205,240,245,420" alt="Dent 45" href="#" data-dent="45">
            <area shape="rect" coords="245,240,285,420" alt="Dent 44" href="#" data-dent="44">
            <area shape="rect" coords="285,240,315,420" alt="Dent 43" href="#" data-dent="43">
            <area shape="rect" coords="315,240,350,420" alt="Dent 42" href="#" data-dent="42">
            <area shape="rect" coords="350,240,387,420" alt="Dent 41" href="#" data-dent="41">

            <area shape="rect" coords="387,240,425,420" alt="Dent 31" href="#" data-dent="31">
            <area shape="rect" coords="425,240,460,420" alt="Dent 32" href="#" data-dent="32">
            <area shape="rect" coords="460,240,492,420" alt="Dent 33" href="#" data-dent="33">
            <area shape="rect" coords="492,240,530,420" alt="Dent 34" href="#" data-dent="34">
            <area shape="rect" coords="530,240,570,420" alt="Dent 35" href="#" data-dent="35">
            <area shape="rect" coords="570,240,625,420" alt="Dent 36" href="#" data-dent="36">
            <area shape="rect" coords="625,240,680,420" alt="Dent 37" href="#" data-dent="37">
            <area shape="rect" coords="680,240,750,420" alt="Dent 38" href="#" data-dent="38">
        </map>
    </div>

    
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/image-map-resizer/1.0.10/js/imageMapResizer.min.js"></script>


</body>
</html>