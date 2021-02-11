<?php
/**
* Author: triopsi
* Author URI: http://wiki.profoxi.de
* License: GPL3
* License URI: https://www.gnu.org/licenses/gpl-3.0
*
* thaos is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 2 of the License, or
* any later version.
*  
* thaos is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*  
* You should have received a copy of the GNU General Public License
* along with thaos. If not, see https://www.gnu.org/licenses/gpl-3.0.
**/

/* Shortcode on the Page */
add_shortcode("thaos", "thaos_sh");

//Show the Shortcode in the post/site/content
function thaos_sh($atts) {

  //Data of the current Post
  global $post;

  // Shortcode Parameter
	extract(shortcode_atts(array(
		'link_target'		=> 'self',
		'show_title'		=> 'true',
		'orderby'			=> 'date',
    'order'				=> 'ASC',
    'servicename' => '',
    'width' => '',
    ), $atts));
    
  $link_target 		  = ( $link_target == 'blank' ) 		? '_blank' 	: '_self';
  $show_title 		  = ( $show_title == 'false') 	    ? false	: true;
  $order 				    = ( strtolower($order) == 'asc' ) 	? 'ASC' : 'DESC';
  $orderby 			    = !empty($orderby)	 				? $orderby 	: 'date';
  $servicename		  = !empty($servicename)              ? $servicename : '';
  $width		        = !empty($width)              ? $width : '100';
        
  // WP Query Parameters
  $query_args = array(
    'post_type' 			  => 'thaos',
    'post_status' 			=> array( 'publish' ),
    'posts_per_page'		=> -1,
    'order'          		=> $order,
	  'orderby'        		=> $orderby,
  );

  //search single service
  if(!empty($servicename)){
    $query_args['name'] = $servicename;
  }

  //search single service
  if(!empty($width)){
    $width_item = $width;
  }

  // WP Query Parameters
	$thaos_query = new WP_Query($query_args);
  $post_count = $thaos_query->post_count;
  
  //Output
  $htmlout = '<!-- Start Triopsi Hosting Service List -->';

  // Gets table slug (post name)
  $all_attr = shortcode_atts( array( "name" => '' ), $atts );

  //Style
  $main_color = get_option( 'thaos_setting_main_color' , '#237dd1');
  $border_color = get_option( 'thaos_setting_border_color_hover' , '#237dd1');

  //Buffer Start
  ob_start();

  //div
  $divcollum=($post_count<=5)?$post_count:5;

  //Show Services CSS
  if( $thaos_query->have_posts() ) { 
    ?>
      <style>
          .thaos .thaos-txt {
              color: <?php echo $main_color ?>;
          }
          .thaos .border-bottom-hover:hover {
                border-bottom-color: <?php echo $border_color ?>;
            }
          ul.thaos li {
              width: <?php echo round(($width_item/$divcollum),2)?>%;
          }          
          /* Unter Tabletsgröße */
          @media (max-width: 991.98px) {
              ul.thaos li {
                  width: 100%;
              }

          }
      </style>
    <?php
    //Output Buffer and Clen Buffer
    $o = ob_get_clean();

    //itteration
    $i=0;

    //Outputt all Services
    while ($thaos_query->have_posts()) : $thaos_query->the_post();

      //itteration high
      $i++;

      $htmlout .='<!--'.($i % 5).'-->';

      if ($i % 5 == 1){
        //Output
        $htmlout .='<ul class="row thaos">';
      }

      //Default Link=true
      $nolink=true;

      //Get the title
      $title_service = get_the_title();  

      //get the output
      $thecontent = get_the_content();    

      //Get links
      $service_url_page_id = (int)get_post_meta( $post->ID, '_thaos_service_url_page_id', true );
      $service_url_post_id = (int)get_post_meta( $post->ID, '_thaos_service_url_post_id', true );
      $service_url_link = get_post_meta( $post->ID, '_thaos_service_url_link', true );

      //Default url
      $htmlurl='';

      //Set the url
      if($service_url_page_id !=0){
        $htmlurl=get_page_link($service_url_page_id);
      }
      if($service_url_post_id !=0){
        $htmlurl=get_page_link($service_url_page_id);
      }
      if($service_url_link !=''){
        $htmlurl=$service_url_link;
      }
      if($service_url_page_id ==0 && $service_url_post_id ==0 && empty($service_url_link)){
        $nolink=false;
      }

      //Get icon
      $service_icon = get_post_meta( $post->ID, '_thaos_service_icon', true );

      //Start List
      $htmlout .='<li>';
      if($nolink){
        $htmlout .='<a target="'.esc_html($link_target).'" href="'.$htmlurl.'">';
      }
      $htmlout .='<div class="thboxservice" style="">
              <div class="thserviceitem border-bottom-hover">
                <div class="angebot-icon thaos-txt">
                  <i class="fas '.$service_icon.'"></i>
                </div>';
      if($show_title){
        $htmlout .='<h3 class="thaos-txt">'.$title_service.'</h3>';
      }

      if(!empty($thecontent)){
        $htmlout .='<p>'.$thecontent.'</p>';
      }
      
      $htmlout .='</div>
            </div>';
      if($nolink){
        $htmlout .='</a>';
      }
      $htmlout .='</li>';

      if ($i % 5 == 0){
        $htmlout .='</ul><!-- END UL-->';
      }

    endwhile;

    if ($i % 5 !=0){
      $htmlout .='</ul><!-- END UL-->';
    }

  }
  $htmlout .= '<!-- End Triopsi Hosting Service List -->';
  wp_reset_postdata(); // Reset WP Query
  return $o.$htmlout;

}