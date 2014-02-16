<?php

/**
 * Plugin Name: Mixtape Machine
 * Description: A customizable retro sidebar widget that brings your SoundCloud playlists straight into the 20th century.
 * Author: Dave Hall
 * Plugin URI: http://www.mixtapemachine.com
 * Author URI: http://www.icanmakeyouwebsite.com
 * Version: 0.9.2
 * Text Domain: mixtape_machine
 * License: GPLv2
**/

/**
*	Copyright (c) 2014, Dave Hall (dave@icanmakeyouwebsite.com)
*	All rights reserved.
*
*	Redistribution and use in source and binary forms, with or without
*	modification, are permitted provided that the following conditions are met:
*		* Redistributions of source code must retain the above copyright
*		  notice, this list of conditions and the following disclaimer.
*		* Redistributions in binary form must reproduce the above copyright
*		  notice, this list of conditions and the following disclaimer in the
*		  documentation and/or other materials provided with the distribution.
*		* Neither the name of the organization nor the
*		  names of its contributors may be used to endorse or promote products
*		  derived from this software without specific prior written permission.
*
*	THIS SOFTWARE IS PROVIDED BY DAVE HALL ''AS IS'' AND ANY
*	EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
*	WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
*	DISCLAIMED. IN NO EVENT SHALL <copyright holder> BE LIABLE FOR ANY
*	DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
*	(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
*	LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
*	ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
*	(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
*	SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*/

/* This is my first plugin, so please be kind. Send any development feedback to dave@icanmakeyouwebsite.com */

add_action( 'load-widgets.php', 'my_custom_load' );
function my_custom_load() {    
	wp_enqueue_style( 'wp-color-picker' );        
	wp_enqueue_script( 'wp-color-picker' );   
}

class mixtape_machine extends WP_Widget {

	// constructor
	function mixtape_machine() {
		parent::WP_Widget(false, $name = 'Mixtape Machine' );
	}

// widget form creation
function form($instance) {

// Check values
if( $instance) {
     $color = esc_attr($instance['color']);
     $embed = $instance['embed'];
     $creds = esc_attr($instance['creds']);
     $fonts = esc_attr($instance['fonts']);
} else {
     $color = '#990000';
     $embed = '';
     $creds = 0 ;
     $fonts = 1 ;
}
?>

<script type='text/javascript'>
	jQuery(document).ready(function($) {
		$('.my-color-picker').wpColorPicker();
	});
</script>

<p>
<label for="<?php echo $this->get_field_id('embed'); ?>">SoundCloud Embed Code:</label>
<textarea class="widefat" style="height: 200px" id="<?php echo $this->get_field_id('embed'); ?>" name="<?php echo $this->get_field_name('embed'); ?>"><?php echo $embed; ?></textarea>
(Use the standard iframe code, not the WordPress version.)
</p>

<p>
<label for="<?php echo $this->get_field_id('color'); ?>">Background color:</label><br>
<input class="my-color-picker" id="<?php echo $this->get_field_id('color'); ?>" name="<?php echo $this->get_field_name('color'); ?>" type="text" value="<?php echo $color; ?>" />
</p>

<p>
<input id="<?php echo $this->get_field_id('creds'); ?>" name="<?php echo $this->get_field_name('creds'); ?>" type="checkbox" value="1" <?php checked( $creds ); ?> />
<label for="<?php echo $this->get_field_id('creds'); ?>">Show link to Mixtape Machine under playlist? (So that other people can get it for themselves.)</label>
</p>

<p>
<input id="<?php echo $this->get_field_id('fonts'); ?>" name="<?php echo $this->get_field_name('fonts'); ?>" type="checkbox" value="1" <?php checked( $fonts ); ?> />
<label for="<?php echo $this->get_field_id('fonts'); ?>">Use Google hosted fonts? (Recommended)</label>
</p>

<p><a href="http://www.mixtapemachine.com/donate" title="Donate to the maker of the Mixtape Machine">If you use and enjoy Mixtape Machine, please consider a donation</a></p>

<p><a href="http://wordpress.org/support/view/plugin-reviews/mixtape-machine" title="Be brutal...">Review this plugin</a></p>

<?php
}

// update widget
function update($new_instance, $old_instance) {
      $instance = $old_instance;
      $instance['color'] = strip_tags($new_instance['color']);
      $instance['embed'] = $new_instance['embed'];
      $instance['creds'] = $new_instance['creds'];
      $instance['fonts'] = $new_instance['fonts'];
     return $instance;
}

// display widget
function widget($args, $instance) {
   extract( $args );
   $color = $instance['color'];
   $embed = $instance['embed'];
   $creds = $instance['creds'];
   $fonts = $instance['fonts'];
   echo $before_widget;

wp_enqueue_style('mm_style', plugins_url( 'mixtape_machine.css', __FILE__ ) );
wp_enqueue_script( 'jquery' ); 

?>

	<div class="widget-text player actionButtons" style="background: <?php echo $color; ?>">
        <div class="listmask">
        <?php if( $creds AND $creds == '1' ) { echo '
            <p class="credits"><a href="http://www.mixtapemachine.com/" title="Mixtape Machine SoundCloud widget">Mixtape Machine</a><a href="http://www.icanmakeyouwebsite.com" title="I Can Make You Website">Music Web Design</a></p>
        '; }?>
            <p class="closer">Close X</p>
        </div>
        <img class="panel" src="<?php echo plugins_url('skins/default/controls.png', __FILE__ ); ?>" >
        <div class="light"></div>
        <div class="track-info">
            <div class="progress"></div>
            <a href="javascript:void(0)"><span></span></a>
        </div>
        <button class="play"></button>
        <button class="pause"></button>
        <button class="prev"></button>
        <button class="next"></button>
        <div class="tracklist"></div>
        <?php echo $embed; ?>
        <img class="preloaded" src="<?php echo plugins_url('skins/default/controls-play.png', __FILE__ ); ?>">
        <img class="preloaded" src="<?php echo plugins_url('skins/default/controls-stop.png', __FILE__ ); ?>">
        <img class="preloaded" src="<?php echo plugins_url('skins/default/controls-rw.png', __FILE__ ); ?>">
        <img class="preloaded" src="<?php echo plugins_url('skins/default/controls-ff.png', __FILE__ ); ?>">
        <div style="display: none">xlkj445ddkdjhhgppp00R</div>
	</div>


  <?php if( $fonts AND $fonts == '1' ) { echo '
    <link href="http://fonts.googleapis.com/css?family=Codystar|Reenie+Beanie" rel="stylesheet" type="text/css">
  '; }?>
  <script type="text/javascript" src="<?php echo plugins_url('api.js', __FILE__ ); ?>" ></script>

<script type="text/javascript">

var $ = jQuery;

function hideTL () {
  var vvvv = setTimeout( function() {
      $('.tracklist').css({'position':'fixed', 'margin-top':'0'});
  }, 600);
}

function setAnimation () {

              $('.player').addClass('playing');
              clearInterval( $('.player').attr('ST') );
              var speed = 100;
              $('.track-info a').stop().css('margin-left', '0');
                  var t = setTimeout( function() {
                    var boxWidth = $('.track-info').width();
                    var titleLength = $('.track-info a > span').width();
                    if (titleLength > boxWidth)
                      {
                        var time = (titleLength + boxWidth) * 1000 / speed; // Take width into account also...
                        var Ttime = titleLength * 1000 / speed;
                        var Btime = boxWidth * 1000 / speed;
                        $('.track-info a').stop().delay( Btime ).animate({'margin-left': 0 - 20 - titleLength}, Ttime, 'linear');
                        var scrollTitle = setInterval( function() {
                          $('.track-info a').stop().css('margin-left', boxWidth).animate({'margin-left': 0 - 20 - titleLength}, time, 'linear');
                        }, time + 100 );
                        $('.player').attr('ST', scrollTitle);
                      }
                  }, 1000);
}

$(document).ready( function() {

    $('.pause').click( function() {
      $('.panel').attr('src', '<?php echo plugins_url('skins/default/controls-stop.png', __FILE__ ); ?>');
      s = setTimeout ( function () { $('.panel').attr('src', '<?php echo plugins_url('skins/default/controls.png', __FILE__ ); ?>');}, 200);
      $('.track-info a').stop().animate({'margin-left': 0}, 400);
      clearInterval( $('.player').attr('ST') );
    });
    $('.play').click(
      function() { $('.panel').attr('src', '<?php echo plugins_url('skins/default/controls-play.png', __FILE__ ); ?>');
      setAnimation();
    });
    $('.next').click(
      function() { $('.panel').attr('src', '<?php echo plugins_url('skins/default/controls-ff.png', __FILE__ ); ?>');
      s = setTimeout ( function () { $('.panel').attr('src', '<?php echo plugins_url('skins/default/controls-play.png', __FILE__ ); ?>'); }, 200);
      $('.track-info a > span');
      setAnimation();
    });
    $('.prev').click(
      function() { $('.panel').attr('src', '<?php echo plugins_url('skins/default/controls-rw.png', __FILE__ ); ?>');
      s = setTimeout ( function () { $('.panel').attr('src', '<?php echo plugins_url('skins/default/controls-play.png', __FILE__ ); ?>'); }, 200);
      $('.track-info a > span');
      setAnimation();
    });
    $('.listmask').click( function() {
      $('.tracklist').removeClass('up');
      $('body').removeClass('trad');
      $(this).fadeOut(400);
      hideTL();
    });
});

$(window).bind('load resize', function() {
  var h = $('.track-info').height() * 0.8;
  $('.track-info a').css('font-size', h + 'px');
  $('img.preloaded').css('display', 'block');
});

    (function(){

      var iframe = document.querySelector('.player > iframe');
      var widget = SC.Widget(iframe);

      var forEach = Array.prototype.forEach;

      function addEvent(element, eventName, callback) {
        if (element.addEventListener) {
          element.addEventListener(eventName, callback, false);
        } else {
          element.attachEvent(eventName, callback, false);
        }
      }

      var eventKey, eventName;
      for (eventKey in SC.Widget.Events) {
        (function(eventName, eventKey) {
          eventName = SC.Widget.Events[eventKey];
        }(eventName, eventKey))
      }

      var actionButtons = document.querySelectorAll('.actionButtons button, .player > a');
      forEach.call(actionButtons, function(button) {
        addEvent(button, 'click', function(e) {
          if (e.target !== this) {
            e.stopPropagation();
            return false;
          }
          var input = this.querySelector('input');
          var value = input && input.value;
          widget[this.className](value);
        });
      });


      var getterButtons = document.querySelectorAll('.getterButtons button');
      forEach.call(getterButtons, function(button){
        addEvent(button, 'click', function(e) {
        });
      });


    $('.track-info a, .light').click(function(){
          
          $('.listmask').fadeIn(250);
          var TLwidth = $('.tracklist').width();
          var Wwidth = $(window).width();
          $('.tracklist').css('left', (Wwidth - TLwidth) / 2);

          var vvv = setTimeout( function() {
              var extra = $(window).scrollTop();
              $('.tracklist').appendTo('body').css({'position':'absolute', 'margin-top':extra});
          }, 600);
          widget['getSounds'](function(val){
            $('.tracklist').addClass('up').html('');
            for (var i=0;i<val.length;i++)
              {
                $('.tracklist').append( '<a href="javascript:void(0)" title="' + val[i].description + '" class="tracklink">' + (i + 1) + '. ' + val[i].title + '</a><br>');
              }
            $('.tracklist').append('<a href="javascript:void(0)" class="SCicon" title="Open standard SoundCloud player" ><img src="<?php echo plugins_url('soundcloud.png', __FILE__ ); ?>"></a>');

            $('a.SCicon').click( function() {
              $('.tracklist').removeClass('up');
              $('body').addClass('trad');
              hideTL();
            });

            $('a.tracklink').click( function() {
              $('.tracklist').removeClass('up');
              var tnum = $(this).index('a.tracklink');
              widget['skip'](tnum);
              $('.listmask').fadeOut(400);
              hideTL();
              });
            });
          });


      s = setInterval ( function() {
          widget['isPaused'](function(val){
            if (val == true) { $('.player').removeClass('playing');}
            else { $('.player').addClass('playing'); }
          });

          widget['getCurrentSoundIndex'](function(val){
            $('.track-info a > span').attr('track', val + 1);
          });

          widget['getCurrentSound'](function(val){
            var listing = $('.track-info a > span').attr('track') + '. ' + val.title;
            var theTrack = $('.track-info a > span').text();
            if ( listing != theTrack || theTrack == '' ) {
              $('.track-info a > span').text( listing ).attr('title', val.description);
              setAnimation();
            }
          });

          widget['getPosition'](function(pos){
            widget['getDuration'](function(dur){
              $('.player').attr('duration', dur);
            });
            var dur = $('.player').attr('duration');
            var per = 100 * pos / dur;
            $('.progress').css('width', per + "%");
          });

      }, 100);

    }());

</script>

<?php
   echo $after_widget;
}
}

add_action('widgets_init', create_function('', 'return register_widget("mixtape_machine");'));

?>