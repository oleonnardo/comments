<?php

namespace Leonardo\Comments\Facades;

abstract class Builder {

    /**
     * @param string $string
     * @param null|int|string $quote_style
     * @param null|string $charset
     * @return string
     */
    protected function html($string, $quote_style = null, $charset = null) {
        echo html_entity_decode($string, $quote_style, $charset);
    }

}
