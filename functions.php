<?php

function findGemeinde($id) {
    if ($id == NULL) {
        return;
    }
    $gemeinden = json_decode(file_get_contents(__DIR__ . "/data/gemeinden/gemeinden.json"), true);
    $gemeinde = array_values(array_filter($gemeinden, function($gemeinde) use($id){
        return $gemeinde["gde_nr"] == $id;
    }));
    if (!$gemeinde) {
        $gemeinde = array_values(array_filter($gemeinden, function($gemeinde) use($id){
            return in_array($id, $gemeinde["plz_array"]);
        }));
    }
    if (!$gemeinde) {
        $gemeinde = array_values(array_filter($gemeinden, function($gemeinde) use($id){
            return $gemeinde["gde_name"] == $id;
        }));
    }

    return $gemeinde[0];
}

function findParty($slug) {
    $parteien = json_decode(file_get_contents(__DIR__ . "/data/parties.json"), true);

    $partei = array_values(array_filter($parteien, function($partei) use($slug){
        return $partei["slug"] == $slug;
    }));
    if (!$partei) {
        $partei = array_values(array_filter($parteien, function($partei) use($slug){
            return $partei["name"] == $slug;
        }));
    }
    if (!$partei) {
        $partei = [
            $slug
        ];
    }

    return $partei[0];

}