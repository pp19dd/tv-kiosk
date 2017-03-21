<?php
require_once( "config.php" );

// collate by category
function get_feed() {
    $ret = array();
    $data = json_decode(file_get_contents(FEED));

    foreach( $data->items as $item ) {

        // skip items whose links terminate in .mp3
        if( substr($item->Link, -4) === ".mp3" ) continue;

        // get an ID from the link
        preg_match("/([0-9]+)\.html/", $item->Link, $m );

        // could not find an id
        if( !is_array($m) || !isset($m[0]) ) continue;

        // generate an embed URL
        $id = $m[1];

        $item->pangea_id = $id;

        $item->embed_url = "http://www.voanews.com/embed/player/0/{$id}.html?type=video";

        $cat = $item->Category;
        if( !isset( $ret[$cat]) ) $ret[$cat] = array();

        $ret[$cat][] = $item;
    }

    return( $ret );
}

// helper to manipulate pangea images
function tokenize_parms( $parms ) {

    $ret = array();

    foreach( $parms as $k => $v ) {

        $s = substr($v, 0, 1);
        $s2 = substr($v, 1);

        if( $s === "w" || $s === "h" ) {
            $ret[$s] = $s2;
        } else {
            $ret[$v] = 1;
        }
    }

    return( $ret );
}

// allows width and height resizing
// if neither is provided, returns raw image without
// image manipulation
function pangea_image($url, $width = false, $height = false) {
    $info = parse_url($url);

    // $info looks like
    // Array (
    //     [scheme] => https
    //     [host] => gdb.voanews.com
    //     [path] => /29fe4f2d-6711-48db-9540-03ecb0532f41_tv_w800_h450.jpg
    // )

    $partial = explode(".", $info["path"]);

    // partial looks like
    // Array (
    //     [0] => /29fe4f2d-6711-48db-9540-03ecb0532f41_tv_w800_h450
    //     [1] => jpg
    // )

    $parms = explode("_", $partial[0] );

    // parms looks like
    // Array (
    //     [0] => /29fe4f2d-6711-48db-9540-03ecb0532f41
    //     [1] => tv
    //     [2] => w800
    //     [3] => h450
    // )

    $parms_a = tokenize_parms($parms);

    // parms_a looks like
    // Array (
    //     [/29fe4f2d-6711-48db-9540-03ecb0532f41] => 1
    //     [tv] => 1
    //     [w] => 800
    //     [h] => 450
    // )

    // erase if needed
    if( $width === false && isset($parms_a["w"]) ) unset($parms_a["w"]);
    if( $height === false && isset($parms_a["h"]) ) unset($parms_a["h"]);

    // set if needed
    if( $width !== false ) $parms_a["w"] = $width;
    if( $height !== false ) $parms_a["h"] = $height;

    // now reconstruct the URL from all this manipulation

    // change [w] => 800 to [w800] => 1
    if( isset($parms_a["w"]) ) {
        $kv = "w" . $parms_a["w"];
        unset( $parms_a["w"] );
        $parms_a[$kv] = 1;
    }

    // change [h] => 400 to [h400] => 1
    if( isset($parms_a["h"]) ) {
        $kv = "h" . $parms_a["h"];
        unset( $parms_a["h"] );
        $parms_a[$kv] = 1;
    }

    $repartial = implode("_", array_keys($parms_a));
    // repartial looks like /29fe4f2d-6711-48db-9540-03ecb0532f41_tv_w320_h400

    $filename = $repartial . "." . $partial[1];
    // filename looks like /29fe4f2d-6711-48db-9540-03ecb0532f41_tv_w320_h400.jpg

    $full_url = sprintf("%s://%s%s", $info["scheme"], $info["host"], $filename );

    return($full_url);
}

// usage:
// $data = get_feed();
