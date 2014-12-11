<?php
// Twitter Button for Bolt, by Bob den Otter

namespace Bolt\Extension\Bolt\TwitterButton;

class Extension extends \Bolt\BaseExtension
{
    public function getName()
    {
        return "Twitter Button";
    }

    public function initialize()
    {

        if (empty($this->config['via'])) {
            $this->config['via'] = "";
        }
        if (isset($this->config['count']) && $this->config['count']==false) {
            $this->config['count'] = 'data-count="none"';
        } else {
            $this->config['count'] = '';
        }
        if (empty($this->config['url'])) {
            $this->config['url'] = $this->app['paths']['canonicalurl'];
        }
        if (empty($this->config['language'])) {
            $this->config['language'] = 'en_US';
        }
        if (empty($this->config['label'])) {
            $this->config['label'] = 'Tweet';
        }
        $this->addTwigFunction('twitterbutton', 'twitterButton');

    }

    public function twitterButton()
    {

        // code from: https://twitter.com/about/resources/buttons#tweet

        $html = <<< EOM
    <a href="https://twitter.com/share" class="twitter-share-button" data-via="%via%" 
%count% data-url="%url%" data-dnt="true" data-lang="%language%">%label%</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);
js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}
(document,"script","twitter-wjs");</script>
EOM;

        $html = str_replace("%url%", $this->config['url'], $html);
        $html = str_replace("%via%", $this->config['via'], $html);
        $html = str_replace("%count%", $this->config['count'], $html);
        $html = str_replace("%language%", $this->config['language'], $html);
        $html = str_replace("%label%", $this->config['label'], $html);

        return new \Twig_Markup($html, 'UTF-8');

    }
}
