<?php

function findGemeinde($id) {
    $gemeinden = json_decode(file_get_contents(__DIR__ . "/data/gemeinden.json"), true);
    if (gettype($id) == "integer") {
        return array_values(array_filter($gemeinden, function($gemeinde) use($id){
            return $gemeinde["nr"] == $id;
        }))[0];
    } else if (gettype($id) == "string") {
        return array_values(array_filter($gemeinden, function($gemeinde) use($id){
            return $gemeinde["name"] == $id;
        }))[0];
    }
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