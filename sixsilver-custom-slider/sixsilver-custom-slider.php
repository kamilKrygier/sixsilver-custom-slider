<?php
/**
* Plugin Name: Wordpress SIXSILVER Slider
* Description: Custom slider created for SIXSILVER
* Version: 1.0.0
* Author: Kamil Krygier
* Author URI: https://www.linkedin.com/in/kamil-krygier-132940166
**/


function six_slider_func( $atts ) {
    $slider = '';
    if(!wp_is_mobile())
    {
      //declare arrays for atributes
      $imgs = array();
      $urls = array();
      //Get shortcode atributes
      $atts = shortcode_atts( array(
          'desktop-imgs' => array(),
          'desktop-urls' => array(),

      ), $atts, 'six_slider' );

      //split atributes with delimeter (',')
      $imgs = explode( ", ", $atts['desktop-imgs'] );
      $urls = explode( ", ", $atts['desktop-urls'] );

      //start bulding slider
      $slider .= '<div class="six-slider-wrapper"><div class="next control">></div><div class="prev control"><</div><ul>';

      //loop for creating slides
      for($i = 0; $i <= count($imgs)-1; $i++)
      {
          //create list-item with its own background and link inside
          // $slider .= '<li class="six-slide" style="background-image: url('.wp_get_attachment_image_url($imgs[$i], "full").');"><a class="six-slide-href" href="'.$urls[$i].'"></a></li>';
          $slider .= '<li class="six-slide" style="background-image: url('.$imgs[$i].');"><a class="six-slide-href" href="'.$urls[$i].'" target="_self"></a></li>';
      }
      //close slider html
      $slider .= '</ul></div>';

      //JQuery when there will be less than 2 slides
      if(count($imgs) < 3 && count($imgs) > 1)
      {
      $slider .= '
      <script>
          jQuery(function($) {
          var temp = $(".six-slider-wrapper ul li").clone();          
          temp.prependTo($(".six-slider-wrapper ul"));

          var slideCount =  $(".six-slider-wrapper ul li").length;
          var slideWidth =  $(".six-slider-wrapper ul li").width();
          var slideHeight =  $(".six-slider-wrapper ul li").height();
          var slideUlWidth =  slideCount * slideWidth;
          
          $(".six-slider-wrapper").css({"max-width":slideWidth, "height": slideHeight});
          $(".six-slider-wrapper ul").css("width",slideUlWidth);
          temp = -2 * slideWidth;
          $(".six-slider-wrapper ul").css("margin-left", temp);
          
          function moveLeft() {
            $(".six-slider-wrapper ul").stop().animate({
              left: + slideWidth
            },700, function() {
              $(".six-slider-wrapper ul li:last-child").prependTo($(".six-slider-wrapper ul"));
              $(".six-slider-wrapper ul").css("left","");
            });
          }
          
          function moveRight() {
            $(".six-slider-wrapper ul").stop().animate({
              left: - slideWidth
            },700, function() {
              $(".six-slider-wrapper ul li:first-child").appendTo($(".six-slider-wrapper ul"));
              $(".six-slider-wrapper ul").css("left","");
            });
          }
          
          function do_slide(){
              interval = setInterval(function(){
                moveRight();
              }, 4300);
            }
            do_slide();
          
          
          $(".six-slider-wrapper ul li").hover(function(){
          clearInterval(interval);
          });
          $(".six-slider-wrapper ul li").mouseleave(function(){
          do_slide();
          });
          
          $(".next").on("click",function(){
            clearInterval(interval);
            moveRight();
          });
          
          $(".prev").on("click",function(){
            clearInterval(interval);
            moveLeft();
          });
          
          
        });
      </script>
      ';
      }

      //JQuery when there will be more than 2 slides
      if(count($imgs) > 2)
      {
      $slider .= '
      <script>
          jQuery(function($) {

          
          $(".six-slider-wrapper ul li:last-child").prependTo($(".six-slider-wrapper ul"));

          var slideCount =  $(".six-slider-wrapper ul li").length;
          var slideWidth =  $(".six-slider-wrapper ul li").width();
          var slideHeight =  $(".six-slider-wrapper ul li").height();
          var slideUlWidth =  slideCount * slideWidth;
          
          $(".six-slider-wrapper").css({"max-width":slideWidth, "height": slideHeight});
          $(".six-slider-wrapper ul").css({"width":slideUlWidth, "margin-left": - slideWidth});
          
          function moveLeft() {
            $(".six-slider-wrapper ul").stop().animate({
              left: + slideWidth
            },700, function() {
              $(".six-slider-wrapper ul li:last-child").prependTo($(".six-slider-wrapper ul"));
              $(".six-slider-wrapper ul").css("left","");
            });
          }
          
          function moveRight() {
            $(".six-slider-wrapper ul").stop().animate({
              left: - slideWidth
            },700, function() {
              $(".six-slider-wrapper ul li:first-child").appendTo($(".six-slider-wrapper ul"));
              $(".six-slider-wrapper ul").css("left","");
            });
          }
          
          function do_slide(){
              interval = setInterval(function(){
                moveRight();
              }, 4300);
            }
            do_slide();
          
          
          $(".six-slider-wrapper ul li").hover(function(){
          clearInterval(interval);
          });
          $(".six-slider-wrapper ul li").mouseleave(function(){
          do_slide();
          });
          
          $(".next").on("click",function(){
            clearInterval(interval);
            moveRight();
          });
          
          $(".prev").on("click",function(){
            clearInterval(interval);
            moveLeft();
          });
          
          
        });
      </script>
      ';
      }
        
    }

    // return $slider;
    return $slider;
 
}

add_shortcode( 'six_slider', 'six_slider_func' );
//usage example
//[six_slider desktop-imgs="https://nowystaging.sixsilver.pl/wp-content/uploads/2022/05/sixsilver_lazurowe_promocje_2022-desktop-1.jpg, https://nowystaging.sixsilver.pl/wp-content/uploads/2022/05/sixsilver_dzien_mamy_promo-banner_desktop-3.jpg" desktop-urls="https://sixsilver.pl/aktualnosci, https://sixsilver.pl/kontakt"]