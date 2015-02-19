<?php

defined('_JEXEC') or die;

 ?>

<div class="mod_erstellbar_twitter">
    <ul class="erstellbar-orbit" data-orbit="" data-options="navigation_arrows:false;timer_speed: 7000;">
        <?php foreach($tweets as $tweet): ?>

            <li>
                <h4><?php echo $tweet->text; ?></h4>
                <div class="name">
                    <a href="//twitter.com/<?php echo $tweet->user_screen_name; ?>"><?php $tweet->user->name; ?></a>
                    <span class="date">vom <?php echo $helper->getDateString($tweet->created_at); ?></span>
                </div>
            </li>

        <?php endforeach ?>
    </ul>
</div>