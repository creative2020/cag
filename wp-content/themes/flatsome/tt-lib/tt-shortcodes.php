<?php
/*
Author: 2020 Creative
URL: htp://2020creative.com
*/
//////////////////////////////////////////////////////////////////////////////////////////////////////////////// 2020 Shortcodes


//////////////////////////////////////////////////////// TT Button

// [hsr_btn size="lg" link="#" color="#003764" fcolor="#ffffff" float="none" target="" class=""]Button Name[/hsr_btn], homes_for_sale_btn

add_shortcode( 'tt_btn', 'tt_btn' );
function tt_btn($atts, $content = null) {
    extract(shortcode_atts(array(
        'size'   => '',
        'color'  => '#003764', //#003764
        'fcolor'  => '#ffffff', //#ffffff
        'link'    => '#',
        'float'    => 'none',
        'target'    => '_blank',
        'class' => '',
        'block' => 'n',
    ), $atts ) );
    
    $classes = 'btn btn-default ' . $class . ' btn-' . $size;
    
    if ($block == 'y') {
    	$classes .= ' btn-block';
    }

    return '<a type="button" class="' . $classes . '" href="' . $link . '" style="background:' . $color . ';color:'. $fcolor . ';float:' . $float . ';" target="' . $target . '">' . $content . '</a>';
}
////////////////////////////////////////////////////////

//////////////////////////////////////////////////////// TT Icon

add_shortcode( 'fa_icon', 'fa_icon' );
function fa_icon($atts, $content = null) {
    extract(shortcode_atts(array(
        'size'   => '',
        'name' => 'rocket',
        'color'  => '#F6B02E', //bg color
        'fcolor'  => '#ffffff', //font color
        'link'    => '',
        'float'    => 'none',
        'target'    => '_blank',
        'class' => '',
    ), $atts ) );
    
    $icon = '<a href="'.$link.'" target="'.$target.'"><i class="fa fa-' . $name . ' '.$class.'" style="float:'.$float.';font-size:' . $size . ';color:' . $color . ';"></i></a>';
    
    return $icon;
}
////////////////////////////////////////////////////////

//////////////////////////////////////////////////////// TT rule

add_shortcode( 'tt_rule', 'tt_rule' ); //line
function tt_rule($atts, $content = null) {
    extract(shortcode_atts(array(
        'size'   => '1px',
        'color'  => '#ccc',
        'classes'  => 'col-sm-12 rule',
        'id' => '',
        'top' => 'n',
        'padding' => '1.0em',
        'margin' => '0',
    ), $atts ) );

    if ($top == 'n') {
    
    return '<div id="' . $id . '" class="' . $classes . '" style="border-top:' . $size . ' solid ' . $color .';padding:' . $padding . ' 0;margin:' . $margin . ' 0"></div>';
    
    } else {
        
        // nothing
    }
     
    if ($top == 'y') {
    
    return '<div id="' . $id . '" class="' . $classes . '" style="border-top:' . $size . ' solid ' . $color .';padding:1.0em 0;"> <a href="#top" class="top"><i class="fa fa-arrow-circle-up pull-right"></i></a></div>';
        
    } else {
        
        // nothing
    }
}

////////////////////////////////////////////////////////

//////////////////////////////////////////////////////// TT Post Feed

add_shortcode( 'tt_posts', 'tt_posts' ); // echo do_shortcode('[tt_posts limit="-1" cat_name="home"]');
function tt_posts ( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'name' => 'post',
            'cat' => '-1',
            'cat_name' => '',
            'limit' => '10',
            'type' => 'post',
            'pre_title' => 'y',
            'orderby' => 'date',
            'order' => 'DSC',
            'bg_color' => '',
            'sidebar' => 'n',
            'title_link' => 'y',
            'list' => 'n',
		), $atts )
	);
    
/////////////////////////////////////// Variables
$user_ID = get_current_user_id();
$user_data = get_user_meta( $user_ID );
$user_photo_id = $user_data[photo][0];
$user_photo_url = wp_get_attachment_url( $user_photo_id );
$user_photo_img = '<img src="' . $user_photo_url . '">';

/////////////////////////////////////// All Query    
if ($name == 'post' || $name == 'features') {
	// The Query
$args = array(
	'post_type' => $type,
	'post_status' => 'publish',
	'order' => $order,
    'orderby' => $orderby,
	'posts_per_page' => $limit,
    'cat' => $cat,
    'category_name' => $cat_name,
);
$the_query = new WP_Query( $args );
} else { 
	//nothing
	}
    
if ($cat_name == 'faqs') {
	// The Query
$args = array(
	'post_type' => $type,
	'post_status' => 'publish',
	'order' => 'ASC',
	'posts_per_page' => $limit,
    //'cat' => $cat,
    'category_name' => $cat_name,
);
$the_query = new WP_Query( $args );
} else { 
	//nothing
	}    
    
global $post;

// pre loop
if ( $cat_name == 'faqs' ) {
    $output .= '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
}
if ( $list == 'y') {
    $output .= '<ul>';
}

// The Loop
if ( $the_query->have_posts() ) {
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		// pull meta for each post
		$post_id = get_the_ID();
		$permalink = get_permalink( $id );
        $post = get_post();
        //$image = the_post_thumbnail( 'thumbnail' );
        $size = 'thumbnail';
        $post_thumbnail_id = get_post_thumbnail_id( $post_id );
        $image_info = wp_get_attachment_image_src( $post_thumbnail_id, $size, $icon );
        $tt_excerpt = $post->post_excerpt;
        $tt_pre_title = '';
        $tt_icon = '';
        $tt_icon_size = '3.0em';
        $category = get_the_category(); 
        $cat_name = $category[0]->category_nicename;
        $tt_icon_name = get_post_meta( $post_id, 'tt_icon' );
        if ( $tt_icon_name[0] != null ) {
            $tt_icon = $tt_icon_name[0];
        }
        
        if ($cat_name == 'faqs') {
            $tt_icon = 'question-circle';
            $font_color = '#F6B02E';
            $bg_color = '#e3e3e2';
            $tt_icon_size = '2.5em';
            $tt_pre_title = 'FAQ: ';
            }
        
        if ( empty( $post->post_excerpt ) ) {
            $tt_content = $post->post_content;
        } else {
            //do nothing
        }
        if ( !empty( $post->post_excerpt ) ) {
            $tt_content = $post->post_excerpt;
        } else {
            //do nothing
        }
        
       if ($cat_name == 'uncategorized') {
            $tt_icon = '';
            }
        
        if ($cat_name == 'news') {
            $tt_icon = 'newspaper-o';
            $tt_pre_title = 'NEWS: ';
            $bg_color = '#D0CEC0';
            }
        if ($cat_name == 'features') {
            $tt_icon_name = get_post_meta( $post_id, 'tt_icon' );
                if ( $tt_icon_name[0] != null ) {
                    $tt_icon = $tt_icon_name[0];
                } else {
                    $tt_icon = 'rocket';
                }
            $image = '<i class="fa fa-'.$tt_icon.'" style="color:'.$font_color.';font-size:4.0em;"></i>';
            $font_color = '#F6B02E';
            $tt_pre_title = 'FEATURE: ';
            $bg_color = '';
            $closer =   '<div class="col-xs-12">'.
                            do_shortcode('[tt_rule]').
                            '<a class="btn btn-primary btn-lg pull-right" href="/our-features"><i class="fa fa-arrow-circle-right"></i> Explore all features</a>'.    
                        '</div>';
            }

        if ($cat_name == 'testimonial') {
            $tt_icon = 'quote-left';
            $font_color = 'white';
            $image = '<i class="fa fa-'.$tt_icon.'" style="color:'.$font_color.';font-size:4.0em;"></i>';
            $bg_color = '#D0CEC0';
            $tt_pre_title = 'Testimonial: ';
            $testimonial_author_name = get_post_meta( $post_id, 'testimonial_author_name' );
            $testimonial_author_company = get_post_meta( $post_id, 'testimonial_author_company' );
            $testimonial_author_cityst = get_post_meta( $post_id, 'testimonial_author_cityst' );
            $testimonial_author_title = get_post_meta( $post_id, 'testimonial_author_title' );
            $testimonial_author_company_logo = get_post_meta( $post_id, 'testimonial_author_company_logo' );
                if ( $testimonial_author_company_logo == null ) {
                    $testimonial_author_company_logo_alt = '<i class="fa fa-quote-right" style="color:'.$bg_color.';font-size:3.0em;"></i>';
                } else {
                    //nothing
                }
            $closer =   '<div class="col-xs-12">'.
                            do_shortcode('[tt_rule]').
                            '<a class="btn btn-primary btn-lg pull-right" href="/our-clients"><i class="fa fa-arrow-circle-right"></i> Read more testimonials</a>'.    
                        '</div>';
        }
    
        if (empty( $image_info[0] )) {
            $image = '<i class="fa fa-'.$tt_icon.'" style="color:'.$font_color.';font-size:'.$tt_icon_size.';"></i>';   //default icon
        } else {
           $image = '<img src="'.$image_info[0].'" class="img-responsive">';
        }
        if ($pre_title == 'n') {
            $tt_pre_title = '';
            }
        
         
		
//HTML
    if ($cat_name == 'features' && $list == 'y') {
        
    // Features Output HTML - List View  
                // image
    $output .=  '<li class="'.$cat_name.'"><a class="lst" href="/our-features/#'.$post->post_name.'">'.
                '<i class="fa fa-'.$tt_icon.'" ></i>'. $post->post_title .
                '</a></li>';
    } 
    if ($cat_name == 'features' && $list =='n') {
        
    // Features Output HTML   
                // image
    $output .=  do_shortcode('[tt_rule id="'.$post->post_name.'" top="y"]').
                '<div class="row '.$cat_name.'-wrap" style="background-color:'.$bg_color.';">'.
                '<div class="'.$cat_name.'-img col-xs-6 col-xs-offset-3 col-sm-offset-0 col-sm-2">';
                // text
    $output .= '<p class="text-center">'.$image.'</p>'.
                '</div>'.
                '<div class="col-xs-offset-1 col-xs-10 col-sm-offset-0 col-sm-10">';
                //check if title link is yes
                    if ($title_link == 'n') {
                        $output .= '<h2>'.$tt_pre_title.''. $post->post_title .'</h2>';
                    } else {
                        $output = '<a href="'.$permalink.'"><h2>'.$tt_pre_title.''. $post->post_title .'</h2></a>';
                    }    
    $output .=  '<p>'. $tt_content .'</p>'.
                '</div></div>'.
                '<div class="clearfix"></div>';
    } 
        
    if ($cat_name == 'faqs') {
        
    // FAQ's Output HTML   
    $output .= '<div class="row tt-post '.$cat.'-wrap" style="background:'.$bg_color.';" role="tab"><a data-toggle="collapse" href="#collapseFaq-'.$post_id.'" aria-expanded="false" aria-controls="collapseFaq-'.$bg_color.'">'.
                '<div class="'.$cat_name.'-img col-xs-offset-3 col-xs-6 col-sm-2">';  
    $output .= '<p class="text-center">'.$image.'</p></a>'.
                '</div>'.
                '<div class="col-xs-12 col-sm-10">'. 
                    '<a data-toggle="collapse" href="#collapseFaq-'.$post_id.'" aria-expanded="false" aria-controls="collapseFaq-'.$post_id.'" data-parent="#selector"><h2>'.$tt_pre_title.''. $post->post_title .'</h2></a>'.
                    '<div class="collapse" id="collapseFaq-'.$post_id.'"><p class="content-'.$cat_name.'">'. $tt_content .'</p></div>'.
                '</div></div>'.
                '<div class="clearfix"></div>';
    }
    
    //Sidebar Output HTML
    if ( $sidebar == 'y' ) {
        $testimonial_author_name = get_post_meta( $post_id, 'testimonial_author_name' );
        $testimonial_author_company = get_post_meta( $post_id, 'testimonial_author_company' );
        $testimonial_author_cityst = get_post_meta( $post_id, 'testimonial_author_cityst' );
        $testimonial_author_title = get_post_meta( $post_id, 'testimonial_author_title' );
                // image
    $output .=  '<div class="row '.$cat.'-wrap" style="background-color:'.$bg_color.';">'.
                '<div class="'.$cat_name.'-img col-xs-6 col-xs-offset-3">'.
                '<p class="text-center"><i class="fa fa-quote-left" style="color:white;font-size:3.0em;"></i></p>'.
                '</div>';
                // text
    $output .= 
                '<div class="col-xs-offset-1 col-xs-10">'. 
                '<a href="'.$permalink.'"><h2>'.$tt_pre_title.''. $post->post_title .'</h2></a>'.
                '<p>'. $tt_content .'</p>'.
                
                '<div class="col-xs-offset-1" col-xs-11>'.
                 '<span class="author-name">'.$testimonial_author_name[0].'</span>'.
                 '<span class="author-title">'.$testimonial_author_title[0].'</span></br>'.
                 '<span class="author-company">'.$testimonial_author_company[0].'</span></br>'.
                '<span class="author-cityst">'.$testimonial_author_cityst[0].'</span>'.
                '</div>'.
        
                '</div></div>'.
                '<div class="clearfix"></div>';
    } 
    
    if ($cat_name == '' || $cat_name == 'testimonial' && $sidebar == 'n') {
        
    //default Output HTML
                // image
        get_template_part( 'content', 'testimonial' );
    }
        
    } //loop end
	
        
} else {
	// no posts found
	echo '<h2>No ' . $type . ' found</h2>';
}
    // after loop
    if ( $cat_name == 'faqs' ) {
        $output .= '</div>';
        }
    if ( $list == 'y') {
        $output .= '</ul>';
        }
    
/* Restore original Post Data */
wp_reset_postdata();
return $output;

}

////////////////////////////////////////////////////////

//////////////////////////////////////////////////////// TT Social Icons

add_shortcode( 'tt_social', 'tt_social' );

function tt_social($atts) {
	
    extract(shortcode_atts(array(
        'size'   => '1.8em',
        'color'  => 'black',
        'margin-right' => '4px',
        'twitter' => 'https://twitter.com/capitusgroup',
        'linkedin' => 'https://www.linkedin.com/company/1237308',
        'instagram' => 'https://instagram.com/capitusgroup',
    ), $atts ) );

    
    return '<div id="tt-social" class="row">'.
				'<div class="col-sm-12">'.
					'<h3>'.
						'<a href="'.$linkedin.'" target="_blank"><i class="fa fa-linkedin"></i></a>'.
						'<a href="'.$twitter.'" target="_blank"><i class="fa fa-twitter"></i></a>'.
						'<a href="'.$instagram.'" target="_blank"><i class="fa fa-instagram"></i></a>'.
					'</h3>'.
				'</div>'.
			'</div>';
}

////////////////////////////////////////////////////////

