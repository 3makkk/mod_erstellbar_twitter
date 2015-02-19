<?php
/**
 * Created by PhpStorm.
 * User: emak
 * Date: 19.02.15
 * Time: 09:01
 */

defined('_JEXEC') or die;
require_once('vendor/autoload.php');

class ModErstellbarTwitterHelper {


    /**
     * @var \Joomla\Registry\Registry
     */
    protected $params;

    /**
     * @param $params \Joomla\Registry\Registry
     */
    public function __construct(&$params)
    {
        $this->params = $params;
    }

    public function getTwitterEntries()
    {
        $settings = array(
            'oauth_access_token' => $this->params->get('erstellbar_twitter_oauth_access_token'),
            'oauth_access_token_secret' => $this->params->get('erstellbar_twitter_oauth_access_token_secret'),
            'consumer_key' => $this->params->get('erstellbar_twitter_consumer_key'),
            'consumer_secret' => $this->params->get('erstellbar_consumer_secret')
        );

        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        $getfield = '?screen_name=spreeboote&count=3&include_entities=true';
        $requestMethod = 'GET';


        $twitter = new TwitterAPIExchange($settings);
        $tweets = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
        $tweets = json_decode($tweets);

        return $tweets;
    }

    /**
     * Link entries (media, hashtags, user_mentions)
     *
     * @param $tweets
     * @return array
     */
    public function linkEntries($tweets)
    {
        foreach ($tweets as $tweet) {
            foreach ($tweet->entities as $type => $entity) {
                foreach ($entity as $element) {
                    if ($type == 'media' or $type == 'urls') {
                        $link = '<a href="' . $element->url . '">' . $element->url . '</a>';
                        $tweet->text = str_replace($element->url, $link, $tweet->text);
                    }
                    if ($type == 'hashtags') {
                        $link = '<a href="http://twitter.com/hastag/' . $element->text . '">#' . $element->text . '</a>';
                        $tweet->text = str_replace('#' . $element->text, $link, $tweet->text);

                    }
                    if ($type == 'user_mentions') {
                        $link = '<a href ="http://twitter.com/' . $element->screen_name . '">@ ' . $element->screen_name . '</a>';
                        $tweet->text = str_replace('@' . $element->screen_name, $link, $tweet->text);
                    }
                }
            }
        }

        return $tweets;
    }

    public function getDateString($date)
    {
        $dateTime = new DateTime($date);

        $day = array(
            0 => 'Montag',
            1 => 'Dienstag',
            2 => 'Mittwoch',
            3 => 'Donnerstag',
            4 => 'Freitag',
            5 => 'Samstag',
            6 => 'Sonntag'
        );

        return $day[$dateTime->format('w')] . ' ' . $dateTime->format('d.m');
    }
}

?>
