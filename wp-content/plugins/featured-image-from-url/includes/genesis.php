<?php

add_filter('genesis_get_image', 'fifu_genesis_image', 10, 4);

function fifu_genesis_image($args, $size, $var2, $src) {
    return $src ? fifu_replace($args, get_the_ID(), $var2, $size) : $args;
}

