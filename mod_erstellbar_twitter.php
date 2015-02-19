<?php

defined('_JEXEC') or die;

require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'helper.php');
require_once('vendor/autoload.php');

$helper = new ModErstellbarTwitterHelper($params);
$tweets = $helper->getTwitterEntries();
$tweets = $helper->linkEntries($tweets);

$document = JFactory::getDocument();

$document->addStyleSheet(JURI::base() . 'modules/mod_erstellbar_twitter/assets/css/erstellbar-orbit.css');
// $document->addStyleSheet(JUri::base() . 'modules/mod_erstellbar_twitter/assets/js/foundation.orbit.js');



require JModuleHelper::getLayoutPath('mod_erstellbar_twitter', $params->get('layout','default'));
?>