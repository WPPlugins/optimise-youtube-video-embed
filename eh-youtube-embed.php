<?php
/*
 * Plugin Name: Optimize YouTube Video Embed.
 * Plugin URI: http://www.xadapter.com/
 * Description: Embed Youtube Video using shortcode [eh_optimize_youtube_embed video="youtube_link" banner="banner_image_link_optional"].
 * Author: XAdapter
 * Author URI: http://www.xadapter.com/
 * Version: 1.0.5
 */
if (!defined('ABSPATH')) {
    exit;
}
if (!defined('EH_YOUTUBE_EMBED_MAIN_URL')) {
    define('EH_YOUTUBE_EMBED_MAIN_URL', plugin_dir_url(__FILE__));
}
add_shortcode('eh_optimize_youtube_embed','eh_optimize_youtube_embed_callback');
function eh_optimize_youtube_embed_callback($atts)
{
    if(!isset($atts['banner']))
    {
        $atts['banner'] = EH_YOUTUBE_EMBED_MAIN_URL.'/assets/img/default_banner.jpg';
    }
    if(isset($atts['video']))
    {
        if (strpos($atts['video'], 'watch') !== false) {
            $split=  explode("?v=", $atts['video']);
            $atts['video'] = "https://www.youtube.com/embed/".$split[1];
        }
    }
    $width = '560';
    $height = '315';
    if(isset($atts['width']))
    {
        $width = $atts['width'];
    }
    if(isset($atts['height']))
    {
        $height = $atts['height'];
    }
    if($atts['video'] && $atts['banner'])
    {
        $content = "
                    <div id='main_youtube_banner'>
                        <div id='play' class='play_image'></div>
                        <img id='image_banner' src='".$atts['banner']."' width='".$width."' height='".$height."'>
                    </div>
                    <script>
                        jQuery(document.body).on('click','#play',function() 
                        {
                            var htm = '<iframe width=\'".$width."\' height=\'".$height."\' src=\'".$atts['video']."?rel=0&showinfo=0&autoplay=1\' frameborder=\'0\' allowfullscreen></iframe>';
                            jQuery('#main_youtube_banner').html(htm);
                            return false;
                        });
                        jQuery(document.body).on('mouseover','#play',function() 
                        {
                            jQuery('#play').removeClass('play_image');
                            jQuery('#play').addClass('play_image_hover');
                        });
                        jQuery(document.body).on('mouseout','#play',function() 
                        {
                            jQuery('#play').removeClass('play_image_hover');
                            jQuery('#play').addClass('play_image');
                        });
                    </script>
                    <style>
                        @media only screen and (min-width: 480px) {
                            #main_youtube_banner {
                                position: relative;
                                display: inline-block;
                            }
                            #main_youtube_banner * {
                                -moz-box-sizing: border-box;
                                -webkit-box-sizing: border-box;
                                box-sizing: border-box;
                            }
                            #image_banner {
                                z-index: 9;
                                text-align: center;
                            }
                            .play_image {
                                background: url('".EH_YOUTUBE_EMBED_MAIN_URL."assets/img/play-black.png') 50% 50% no-repeat;
                                opacity: 0.9;
                                position: absolute;
                                z-index: 10;
                                left: 0;
                                top: 0;
                                background-size: 15%;
                                width: 100%;
                                height: 100%;
                                cursor: pointer;
                            }
                            .play_image_hover {
                                background: url('".EH_YOUTUBE_EMBED_MAIN_URL."assets/img/play-red.png') 50% 50% no-repeat;
                                opacity: 1;
                                position: absolute;
                                z-index: 10;
                                left: 0;
                                top: 0;
                                background-size: 15%;
                                width: 100%;
                                height: 100%;
                                cursor: pointer;
                            }
                        }
                        @media only screen and (max-width: 479px) {
                            #main_youtube_banner {
                                position: relative;
                                display: inline-block;
                            }
                            #main_youtube_banner * {
                                -moz-box-sizing: border-box;
                                -webkit-box-sizing: border-box;
                                box-sizing: border-box;
                            }
                            #image_banner {
                                z-index: 9;
                                text-align: center;
                            }
                            .play_image {
                                background: url('".EH_YOUTUBE_EMBED_MAIN_URL."assets/img/play-black.png') 50% 50% no-repeat;
                                opacity: 0.9;
                                position: absolute;
                                z-index: 10;
                                left: 0;
                                top: 0;
                                background-size: 10%;
                                width: 100%;
                                height: 100%;
                                cursor: pointer;
                            }
                            .play_image_hover {
                                background: url('".EH_YOUTUBE_EMBED_MAIN_URL."assets/img/play-red.png') 50% 50% no-repeat;
                                opacity: 1;
                                background-size: 10%;
                                position: absolute;
                                z-index: 10;
                                left: 0;
                                top: 0;
                                background-size: 10%;
                                width: 100%;
                                height: 100%;
                                cursor: pointer;
                            }
                        }
                    </style>";
        return $content;
    }
    return;
}
