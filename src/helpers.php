<?php

if (! function_exists('comments')) {
    /**
     * @param null $url
     * @return \Leonardo\Comments\CommentPlugin
     */
    function comments($url = null) {
        return \Leonardo\Comments\CommentPlugin::init($url);
    }
}

if (! function_exists('exists')) {
    /**
     * @param string|int $key
     * @param array $array
     * @param null $default
     * @return string|int|null
     */
    function exists($key, $array, $default = null) {

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $default;
    }
}

