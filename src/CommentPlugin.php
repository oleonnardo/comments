<?php

namespace Leonardo\Comments;

use Leonardo\Comments\Http\Request;
use Leonardo\Comments\Facades\Builder;

class CommentPlugin extends Builder {

    /** @var null|string */
    private $url = null;

    /** @var string */
    private $css = '/src/public/assets/css/comments-plugin.css';
    private $cssLoading = '../assets/css/css-loading.css';

    /** @var string */
    private $js = '/src/public/assets/js/comments-plugins.js';

    /** @var string */
    private $index = '/src/public/index.php';

    /** @var string */
    private $rootPath = null;

    /**
     * CommentPlugin constructor.
     * @param null $url
     */
    public function __construct($url = null) {
        $this->url = (empty($url)) ? Request::url() : $this->url;
    }


    /**
     * @param $url
     * @return CommentPlugin
     */
    public static function init($url) {
        return new CommentPlugin($url);
    }


    /**
     * @return string
     */
    public static function renderSpinning() {
        $cssFile = file_get_contents((new static())->cssLoading);

        echo "
        <style type='text/css'>{$cssFile}</style>
        <div class='loading-wrapper'>
            <img src='../assets/img/spinning.gif'>
        </div>";
    }


    /**
     * @return string
     */
    public function renderFrame() {
        // renderização do frame

        // recupera a URL
        $url = $this->getUrl();

        // pega a URL completa da page
        $parametro = Request::fullUrl();

        return $this->html("<iframe src='{$url}?url={$parametro}' frameborder='0' width='100%' height='400'></iframe>");
    }


    /**
     * @param string $path
     * @return $this
     */
    public function rootPath($path) {
        $this->rootPath = rtrim($path, '/');

        return $this;
    }


    /**
     * @return string
     */
    private function getUrl() {
        $url = Request::url();

        if (empty($this->rootPath)) {
            $url .= $this->index;
        } else {

            if (strpos($this->rootPath, '/') === false) {
                $url .= '/';
            }

            $url .= $this->rootPath . $this->index;
        }


        return $url;
    }
}
