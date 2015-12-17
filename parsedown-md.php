<?php
/*
Plugin Name: Parsedown-md
Description: markdown parser, based on `Parsedown` <http://parsedown.org/>
Author: h.matsuo
Version: 1.1
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

    /**
     * @param $content
     * @param string $class
     * @return string
     */
    public function parsedown($content, $class = 'markdown')
    {
        $attr = ($class !== false) ? ' class="' . esc_attr($class). '"' : '';
        return "<div{$attr}>" . $this->pd->text($content) . '</div>';
    }
}

$ParseDownMd = new ParsedownMd();
