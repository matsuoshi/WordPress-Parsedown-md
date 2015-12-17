<?php
/*
Plugin Name: Parsedown-md
Description: markdown parser, based on `Parsedown` <http://parsedown.org/>
Author: h.matsuo
Version: 1.0
*/

require_once __DIR__ . '/parsedown/parsedown.php';


class ParsedownMd
{
    protected $pd;

    public function __construct()
    {
        add_action('init', array(&$this, 'init'));
    }

    public function init()
    {
        // Parsedown 初期化
        $this->pd = new Parsedown();
        $this->pd->setBreaksEnabled(true); // 改行だけで改行する

        // クウォート等の自動変換をOFFに
        remove_filter('the_content', 'wpautop');
        remove_filter('the_content', 'wptexturize');
        remove_filter('comment_text', 'wptexturize');

        // markdown呼び出しフィルタ設定
        add_filter('the_content', array(&$this, 'parsedown'));
        add_filter('comment_text', array(&$this, 'parsedown'));
    }

    public function parsedown($content)
    {
        return '<div class="post markdown">' . $this->pd->text($content) . '</div>';
    }
}

new ParsedownMd();
