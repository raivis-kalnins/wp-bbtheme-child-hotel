<?php
defined( 'ABSPATH' ) || exit;

function wpbb_hotel_project_mode( $mode ) { return 'hotel'; }
add_filter( 'wp_theme_project_mode', 'wpbb_hotel_project_mode' );

function wpbb_hotel_assets() {
    $theme = wp_get_theme();
    wp_enqueue_style( 'wpbb-hotel-meta', get_stylesheet_uri(), array( 'wp-theme-style' ), $theme->get( 'Version' ) );
    $manifest = get_stylesheet_directory() . '/dist/.vite/manifest.json';
    if ( ! is_readable( $manifest ) ) return;
    $data = json_decode( (string) file_get_contents( $manifest ), true );
    if ( ! is_array( $data ) ) return;
    if ( ! empty( $data['src/scss/public.scss']['file'] ) ) {
        wp_enqueue_style( 'wpbb-hotel-app', get_stylesheet_directory_uri() . '/dist/' . ltrim( $data['src/scss/public.scss']['file'], '/' ), array( 'wpbb-hotel-meta' ), $theme->get( 'Version' ) );
        if ( function_exists( 'wp_theme_sector_customizer_css' ) ) wp_add_inline_style( 'wpbb-hotel-app', wp_theme_sector_customizer_css( '#253E5B', '18px', '--sector-primary', '--sector-radius' ) );
    }
    if ( ! empty( $data['src/js/main.js']['file'] ) ) wp_enqueue_script( 'wpbb-hotel-app', get_stylesheet_directory_uri() . '/dist/' . ltrim( $data['src/js/main.js']['file'], '/' ), array(), $theme->get( 'Version' ), true );
}
add_action( 'wp_enqueue_scripts', 'wpbb_hotel_assets', 30 );

function wpbb_hotel_dark_mode_bootstrap() { echo '<script>(function(){try{var m=localStorage.getItem("wpThemeMode");if(m==="dark"){document.documentElement.classList.add("is-dark-theme");document.documentElement.setAttribute("data-theme","dark");}}catch(e){}})();</script>'; }
add_action( 'wp_head', 'wpbb_hotel_dark_mode_bootstrap', 1 );


function wpbb_hotel_demo_profile( $profile ) {
    $assets = trailingslashit( get_stylesheet_directory_uri() ) . 'assets/img/demo/';
    return array_merge( $profile, array(
        'id'=>'hotel', 'name'=>__( 'Hotel Website', 'wp-bbtheme-child-hotel' ), 'commerce'=>false,
        'eyebrow'=>__( 'Stay well, book clearly', 'wp-bbtheme-child-hotel' ), 'hero_title'=>__( 'A hotel website designed around the stay.', 'wp-bbtheme-child-hotel' ), 'hero_text'=>__( 'Explore rooms, compare practical details and request dates without losing the atmosphere that makes the property distinctive.', 'wp-bbtheme-child-hotel' ),
        'hero_image'=>$assets . 'hero-photo.jpg', 'about_image'=>$assets . 'about-photo.jpg',
        'primary_label'=>__( 'Find a room', 'wp-bbtheme-child-hotel' ), 'primary_url'=>'#finder',
        'secondary_label'=>__( 'Explore services', 'wp-bbtheme-child-hotel' ), 'secondary_url'=>wp_theme_demo_page_url( 'services' ),
        'services_eyebrow'=>__( 'What we do', 'wp-bbtheme-child-hotel' ), 'services_heading'=>__( 'A polished booking journey before the guest reaches reception.', 'wp-bbtheme-child-hotel' ),
        'about_eyebrow'=>__( 'Why choose us', 'wp-bbtheme-child-hotel' ), 'about_title'=>__( 'Hospitality detail with fewer booking distractions.', 'wp-bbtheme-child-hotel' ), 'about_text'=>__( 'Room discovery, amenities, availability requests and local guidance are organised into a calm hotel experience.', 'wp-bbtheme-child-hotel' ),
        'industries_eyebrow'=>__( 'Built around your needs', 'wp-bbtheme-child-hotel' ), 'industries_heading'=>__( 'Rooms and stays for weekends, work, families and longer visits.', 'wp-bbtheme-child-hotel' ),
        'process_eyebrow'=>__( 'How it works', 'wp-bbtheme-child-hotel' ), 'process_heading'=>__( 'Choose a room, request dates and arrive with the essentials clear.', 'wp-bbtheme-child-hotel' ), 'faq_heading'=>__( 'Useful booking and stay questions, answered early.', 'wp-bbtheme-child-hotel' ),
        'services'=>array(array( __( 'Rooms & suites', 'wp-bbtheme-child-hotel' ), __( 'Present room differences, capacity and practical amenities clearly.', 'wp-bbtheme-child-hotel' ) ),
array( __( 'Breakfast & dining', 'wp-bbtheme-child-hotel' ), __( 'Connect stays with useful food and local experience content.', 'wp-bbtheme-child-hotel' ) ),
array( __( 'Groups & events', 'wp-bbtheme-child-hotel' ), __( 'Capture larger-stay and event enquiries with enough context to respond.', 'wp-bbtheme-child-hotel' ) )), 'industries'=>array(array( __( 'Weekend stays', 'wp-bbtheme-child-hotel' ), __( 'Comfortable short breaks with local recommendations.', 'wp-bbtheme-child-hotel' ) ),
array( __( 'Business travel', 'wp-bbtheme-child-hotel' ), __( 'Rooms and services that make work trips simpler.', 'wp-bbtheme-child-hotel' ) ),
array( __( 'Family stays', 'wp-bbtheme-child-hotel' ), __( 'Capacity, bed layouts and practical extras shown before booking.', 'wp-bbtheme-child-hotel' ) ),
array( __( 'Longer visits', 'wp-bbtheme-child-hotel' ), __( 'Suites and amenities suited to more than a night or two.', 'wp-bbtheme-child-hotel' ) )), 'stats'=>array(array( '34', __( 'Rooms & suites', 'wp-bbtheme-child-hotel' ) ),
array( '4.8', __( 'Guest rating', 'wp-bbtheme-child-hotel' ) ),
array( '2 min', __( 'Typical enquiry', 'wp-bbtheme-child-hotel' ) ),
array( '24h', __( 'Reception response goal', 'wp-bbtheme-child-hotel' ) )), 'process'=>array(array( '01', __( 'Explore', 'wp-bbtheme-child-hotel' ), __( 'Filter by room type, guests and nightly budget.', 'wp-bbtheme-child-hotel' ) ),
array( '02', __( 'Request', 'wp-bbtheme-child-hotel' ), __( 'Send arrival, departure and guest details.', 'wp-bbtheme-child-hotel' ) ),
array( '03', __( 'Confirm', 'wp-bbtheme-child-hotel' ), __( 'The hotel team follows up with availability and booking details.', 'wp-bbtheme-child-hotel' ) )),
        'cta_title'=>__( 'Make the stay feel considered before arrival.', 'wp-bbtheme-child-hotel' ), 'cta_text'=>__( 'Use the room finder and booking-request system as the starting point for an independent hotel or serviced property.', 'wp-bbtheme-child-hotel' ), 'footer_text'=>__( 'A refined hotel website with room discovery, stay details and direct booking enquiries.', 'wp-bbtheme-child-hotel' ),
        'page_labels'=>array('about'=>__( 'About', 'wp-bbtheme-child-hotel' ),'services'=>__( 'Services', 'wp-bbtheme-child-hotel' ),'industries'=>__( 'Solutions', 'wp-bbtheme-child-hotel' ),'contact'=>__( 'Contact', 'wp-bbtheme-child-hotel' ),'blog'=>__( 'Insights', 'wp-bbtheme-child-hotel' )),
        'palette'=>array('theme_brand_color'=>'#253E5B','theme_accent_color'=>'#A76D4B','theme_background_color'=>'#f7f8fb','theme_surface_color'=>'#ffffff','theme_border_color'=>'#dfe4ee','theme_radius'=>'22px')
    ) );
}
add_filter( 'wp_theme_demo_profile', 'wpbb_hotel_demo_profile', 20 );


function wpbb_hotel_pattern_markup( $name ) {
    $path = get_stylesheet_directory() . '/patterns/' . sanitize_file_name( $name ) . '.php';
    if ( ! is_readable( $path ) ) return '';
    ob_start(); include $path; return trim( (string) ob_get_clean() );
}

function wpbb_hotel_extra_home_sections( $content, $profile ) {
    if ( ( $profile['id'] ?? '' ) !== 'hotel' ) return $content;
    return $content . wpbb_hotel_pattern_markup( 'sector-proof' );
}
add_filter( 'wp_theme_demo_extra_home_sections', 'wpbb_hotel_extra_home_sections', 25, 2 );

function wpbb_hotel_blog_profile( $profile ) {
    if ( ( $profile['id'] ?? '' ) !== 'hotel' ) return $profile;
    $profile['blog_eyebrow'] = __( 'Insights', 'wp-bbtheme-child-hotel' );
    $profile['blog_archive_title'] = __( 'Stay ideas, local guides and hotel news.', 'wp-bbtheme-child-hotel' );
    $profile['blog_archive_intro'] = __( 'Editorial content that helps guests plan the whole visit, not only the room.', 'wp-bbtheme-child-hotel' );
    return $profile;
}
add_filter( 'wp_theme_demo_profile', 'wpbb_hotel_blog_profile', 90 );


function wpbb_hotel_demo_attachment( $filename, $title ) {
    $slug = sanitize_title( pathinfo( $filename, PATHINFO_FILENAME ) );
    $existing = get_page_by_path( 'wpbb-hotel-' . $slug, OBJECT, 'attachment' );
    if ( $existing ) return $existing->ID;
    $source = get_stylesheet_directory() . '/assets/img/demo/' . basename( $filename );
    if ( ! is_readable( $source ) ) return 0;
    $uploads = wp_upload_dir(); $dir = trailingslashit( $uploads['basedir'] ) . 'wpbb-hotel'; wp_mkdir_p( $dir );
    $target = $dir . '/' . basename( $filename ); if ( ! file_exists( $target ) ) copy( $source, $target );
    $filetype = wp_check_filetype( $target );
    $id = wp_insert_attachment( array( 'post_mime_type'=>$filetype['type'] ?: 'image/jpeg', 'post_title'=>$title, 'post_name'=>'wpbb-hotel-' . $slug, 'post_status'=>'inherit' ), $target );
    if ( $id && ! is_wp_error( $id ) ) {
        if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) require_once ABSPATH . 'wp-admin/includes/image.php';
        $meta = wp_generate_attachment_metadata( $id, $target ); if ( $meta ) wp_update_attachment_metadata( $id, $meta ); update_post_meta( $id, '_wp_attachment_image_alt', $title );
        return (int) $id;
    }
    return 0;
}

function wpbb_hotel_register_directory() {
    register_post_type( 'hotel_room', array(
        'labels'=>array('name'=>__( 'Rooms', 'wp-bbtheme-child-hotel' ),'singular_name'=>__( 'Room', 'wp-bbtheme-child-hotel' ),'add_new_item'=>__( 'Add Room', 'wp-bbtheme-child-hotel' )),
        'public'=>true,'show_in_rest'=>true,'has_archive'=>'rooms','rewrite'=>array('slug'=>'rooms'),'menu_icon'=>'dashicons-building','supports'=>array('title','editor','excerpt','thumbnail','page-attributes')
    ) );
    register_taxonomy( 'room_type', 'hotel_room', array( 'label'=>__( 'Room types', 'wp-bbtheme-child-hotel' ), 'public'=>true, 'show_in_rest'=>true, 'hierarchical'=>true, 'rewrite'=>array('slug'=>'room-type') ) ); register_taxonomy( 'room_amenity', 'hotel_room', array( 'label'=>__( 'Amenities', 'wp-bbtheme-child-hotel' ), 'public'=>true, 'show_in_rest'=>true, 'hierarchical'=>true, 'rewrite'=>array('slug'=>'amenity') ) );
}
add_action( 'init', 'wpbb_hotel_register_directory', 12 );

function wpbb_hotel_meta_fields() { return array('nightly_rate'=>__( 'Nightly rate', 'wp-bbtheme-child-hotel' ),'capacity'=>__( 'Guest capacity', 'wp-bbtheme-child-hotel' ),'beds'=>__( 'Beds', 'wp-bbtheme-child-hotel' ),'size'=>__( 'Room size', 'wp-bbtheme-child-hotel' ),'view'=>__( 'View / outlook', 'wp-bbtheme-child-hotel' )); }
function wpbb_hotel_meta_box() { add_meta_box( 'wpbb-hotel-details', __( 'Room details', 'wp-bbtheme-child-hotel' ), 'wpbb_hotel_meta_box_render', 'hotel_room', 'normal', 'high' ); }
add_action( 'add_meta_boxes', 'wpbb_hotel_meta_box' );
function wpbb_hotel_meta_box_render( $post ) {
    wp_nonce_field( 'wpbb_hotel_save', 'wpbb_hotel_nonce' ); echo '<div style="display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px">';
    foreach ( wpbb_hotel_meta_fields() as $key=>$label ) { $value=get_post_meta($post->ID,'_hotel_'.$key,true); echo '<label><strong>'.esc_html($label).'</strong><input class="widefat" type="text" name="wpbb_hotel['.esc_attr($key).']" value="'.esc_attr($value).'"></label>'; } echo '</div>';
}
function wpbb_hotel_save_meta( $post_id ) {
    if ( empty($_POST['wpbb_hotel_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['wpbb_hotel_nonce'])),'wpbb_hotel_save') || !current_user_can('edit_post',$post_id) ) return;
    $values=isset($_POST['wpbb_hotel'])&&is_array($_POST['wpbb_hotel'])?wp_unslash($_POST['wpbb_hotel']):array(); foreach(wpbb_hotel_meta_fields() as $key=>$label) update_post_meta($post_id,'_hotel_'.$key,sanitize_text_field($values[$key]??''));
}
add_action( 'save_post_hotel_room', 'wpbb_hotel_save_meta' );

function wpbb_hotel_directory_configs( $configs ) {
    $configs['hotel'] = array(
      'post_type'=>'hotel_room','eyebrow'=>__( 'Room finder', 'wp-bbtheme-child-hotel' ),'title'=>__( 'Choose a room for the way you are staying.', 'wp-bbtheme-child-hotel' ),'intro'=>__( 'Compare room type, capacity and price before requesting your dates.', 'wp-bbtheme-child-hotel' ),'keyword_label'=>__( 'Search rooms', 'wp-bbtheme-child-hotel' ),'keyword_placeholder'=>__( 'Suite, balcony, family…', 'wp-bbtheme-child-hotel' ),'button_label'=>__( 'Find rooms', 'wp-bbtheme-child-hotel' ),'results_label'=>__( 'rooms available to enquire about', 'wp-bbtheme-child-hotel' ),'limit'=>8,'default_sort'=>'featured',
      'filters'=>array(array('type'=>'taxonomy','key'=>'type','label'=>__( 'Room type', 'wp-bbtheme-child-hotel' ),'taxonomy'=>'room_type','all_label'=>'Any room'),array('type'=>'meta_min','key'=>'guests','label'=>__( 'Guests', 'wp-bbtheme-child-hotel' ),'meta_key'=>'_hotel_capacity','placeholder'=>'1','step'=>1),array('type'=>'meta_max','key'=>'max_rate','label'=>__( 'Max nightly rate', 'wp-bbtheme-child-hotel' ),'meta_key'=>'_hotel_nightly_rate','placeholder'=>'No max','step'=>10),array('type'=>'taxonomy','key'=>'amenity','label'=>__( 'Amenity', 'wp-bbtheme-child-hotel' ),'taxonomy'=>'room_amenity','all_label'=>'Any amenity')),'sorts'=>array('featured'=>array('label'=>__( 'Recommended', 'wp-bbtheme-child-hotel' ),'orderby'=>'menu_order','order'=>'ASC'),'rate-asc'=>array('label'=>__( 'Price: low to high', 'wp-bbtheme-child-hotel' ),'orderby'=>'meta_value_num','order'=>'ASC','meta_key'=>'_hotel_nightly_rate'),'rate-desc'=>array('label'=>__( 'Price: high to low', 'wp-bbtheme-child-hotel' ),'orderby'=>'meta_value_num','order'=>'DESC','meta_key'=>'_hotel_nightly_rate')),'card_taxonomies'=>array('room_type'),'card_meta'=>array(array('key'=>'_hotel_nightly_rate','label'=>__( 'Nightly', 'wp-bbtheme-child-hotel' ),'format'=>'money','currency'=>'£'),array('key'=>'_hotel_capacity','label'=>__( 'Guests', 'wp-bbtheme-child-hotel' )),array('key'=>'_hotel_beds','label'=>__( 'Beds', 'wp-bbtheme-child-hotel' )),array('key'=>'_hotel_size','label'=>__( 'Size', 'wp-bbtheme-child-hotel' ))),'card_button'=>__( 'View room', 'wp-bbtheme-child-hotel' )
    ); return $configs;
}
add_filter( 'wp_theme_sector_directory_configs', 'wpbb_hotel_directory_configs' );

function wpbb_hotel_seed_directory( $profile ) {
    if ( ( $profile['id'] ?? '' ) !== 'hotel' ) return;
    $rows=array(array('title'=>'Garden King','slug'=>'garden-king','excerpt'=>'A quiet king room overlooking the courtyard garden.','content'=>'A quiet king room overlooking the courtyard garden.','terms'=>array('room_type'=>'King Room','room_amenity'=>'Garden view'),'meta'=>array('nightly_rate'=>'165','capacity'=>'2','beds'=>'1 king','size'=>'28 m²','view'=>'Courtyard garden'),'image'=>'item-1.jpg'),array('title'=>'City Suite','slug'=>'city-suite','excerpt'=>'A separate sitting area, generous workspace and skyline outlook.','content'=>'A separate sitting area, generous workspace and skyline outlook.','terms'=>array('room_type'=>'Suite','room_amenity'=>'Workspace'),'meta'=>array('nightly_rate'=>'245','capacity'=>'2','beds'=>'1 king','size'=>'42 m²','view'=>'City'),'image'=>'item-2.jpg'),array('title'=>'Family Loft','slug'=>'family-loft','excerpt'=>'Flexible sleeping space for families with a relaxed loft layout.','content'=>'Flexible sleeping space for families with a relaxed loft layout.','terms'=>array('room_type'=>'Family Room','room_amenity'=>'Family friendly'),'meta'=>array('nightly_rate'=>'285','capacity'=>'4','beds'=>'1 king + sofa bed','size'=>'48 m²','view'=>'Roof garden'),'image'=>'item-3.jpg'),array('title'=>'Courtyard Twin','slug'=>'courtyard-twin','excerpt'=>'Two comfortable beds and easy access to the hotel courtyard.','content'=>'Two comfortable beds and easy access to the hotel courtyard.','terms'=>array('room_type'=>'Twin Room','room_amenity'=>'Courtyard'),'meta'=>array('nightly_rate'=>'145','capacity'=>'2','beds'=>'2 twins','size'=>'25 m²','view'=>'Courtyard'),'image'=>'item-4.jpg'),array('title'=>'Terrace Studio','slug'=>'terrace-studio','excerpt'=>'A studio room with private outdoor seating and kitchenette.','content'=>'A studio room with private outdoor seating and kitchenette.','terms'=>array('room_type'=>'Studio','room_amenity'=>'Private terrace'),'meta'=>array('nightly_rate'=>'215','capacity'=>'2','beds'=>'1 king','size'=>'35 m²','view'=>'Terrace'),'image'=>'item-5.jpg'),array('title'=>'Accessible Queen','slug'=>'accessible-queen','excerpt'=>'Step-free room with accessible bathroom and generous circulation space.','content'=>'Step-free room with accessible bathroom and generous circulation space.','terms'=>array('room_type'=>'Accessible Room','room_amenity'=>'Accessible'),'meta'=>array('nightly_rate'=>'155','capacity'=>'2','beds'=>'1 queen','size'=>'31 m²','view'=>'Garden'),'image'=>'item-6.jpg'));
    foreach($rows as $i=>$row){
      foreach($row['terms'] as $tax=>$term) if(taxonomy_exists($tax)&&!term_exists($term,$tax)) wp_insert_term($term,$tax);
      $existing=get_page_by_path($row['slug'],OBJECT,'hotel_room'); $args=array('post_type'=>'hotel_room','post_status'=>'publish','post_title'=>$row['title'],'post_name'=>$row['slug'],'menu_order'=>$i,'post_excerpt'=>$row['excerpt'],'post_content'=>'<!-- wp:paragraph --><p>'.esc_html($row['content']).'</p><!-- /wp:paragraph -->');
      if($existing){$args['ID']=$existing->ID;$id=wp_update_post($args);}else{$id=wp_insert_post($args);} if(!$id||is_wp_error($id))continue;
      foreach($row['terms'] as $tax=>$term)wp_set_object_terms($id,$term,$tax); foreach($row['meta'] as $key=>$value)update_post_meta($id,'_hotel_'.$key,$value); $img=wpbb_hotel_demo_attachment($row['image'],$row['title']); if($img)set_post_thumbnail($id,$img); update_post_meta($id,'_wp_theme_demo_hotel_room',1);
    }
}
add_action( 'wp_theme_seed_sector_pages', 'wpbb_hotel_seed_directory', 25 );

function wpbb_hotel_after_hero_finder( $content, $profile ) {
    if ( ( $profile['id'] ?? '' ) !== 'hotel' ) return $content;
    return $content . '<!-- wp:group {"className":"wp-theme-section-shell wpbb-hotel-finder-section","layout":{"type":"default"}} --><div class="wp-block-group wp-theme-section-shell wpbb-hotel-finder-section"><!-- wp:wpbb/row {"containerClass":"container"} --><!-- wp:wpbb/column {"xs":12} --><!-- wp:wpbb/sector-finder {"context":"hotel","limit":8} /--><!-- /wp:wpbb/column --><!-- /wp:wpbb/row --></div><!-- /wp:group -->';
}
add_filter( 'wp_theme_demo_after_hero_sections', 'wpbb_hotel_after_hero_finder', 20, 2 );

function wpbb_hotel_navigation( $items, $profile ) {
    if ( ( $profile['id'] ?? '' ) !== 'hotel' ) return $items;
    array_splice( $items, 1, 0, array( array('key'=>'hotel_room','title'=>__( 'Rooms', 'wp-bbtheme-child-hotel' ),'type'=>'post_type_archive','object'=>'hotel_room','locations'=>array('header','footer')) ) ); return $items;
}
add_filter( 'wp_theme_demo_navigation_items', 'wpbb_hotel_navigation', 20, 2 );

function wpbb_hotel_header_search_types( $types ) { if(post_type_exists('hotel_room'))$types[]='hotel_room'; return array_values(array_unique($types)); }
add_filter( 'wp_theme_header_search_post_types', 'wpbb_hotel_header_search_types' );

function wpbb_hotel_single_content( $content ) {
    if ( !is_singular('hotel_room') || !in_the_loop() || !is_main_query() ) return $content; $id=get_the_ID(); $image=get_the_post_thumbnail_url($id,'large'); $gallery=function_exists('wp_theme_item_gallery_single_markup')?wp_theme_item_gallery_single_markup($id):'';
    $facts=''; foreach(wpbb_hotel_meta_fields() as $key=>$label){$value=get_post_meta($id,'_hotel_'.$key,true);if(''!==trim((string)$value))$facts.='<div><small>'.esc_html($label).'</small><strong>'.esc_html($value).'</strong></div>';}
    $html='<section class="wpbb-sector-single"><div class="container"><div class="wpbb-sector-single__hero"><div class="wpbb-sector-single__media">'.($gallery?:($image?'<img src="'.esc_url($image).'" alt="'.esc_attr(get_the_title()).'">':'')).'</div><div><p class="wp-theme-sector-eyebrow">'.esc_html('Room').'</p><h1>'.esc_html(get_the_title()).'</h1><p class="wp-theme-sector-lead">'.esc_html(get_the_excerpt()).'</p><div class="wpbb-sector-single__facts">'.$facts.'</div></div></div><div class="wpbb-sector-single__content">'.$content.'</div>';
    if(function_exists('wpbb_hotel_request_form'))$html.=wpbb_hotel_request_form($id); return $html.'</div></section>';
}
add_filter( 'the_content', 'wpbb_hotel_single_content', 25 );

function wpbb_hotel_polylang_post_types( $types, $settings ) { $types['hotel_room']='hotel_room'; return $types; }
add_filter( 'pll_get_post_types', 'wpbb_hotel_polylang_post_types', 10, 2 );
function wpbb_hotel_pll_room_type( $tax, $settings ) { $tax['room_type']='room_type'; return $tax; }
add_filter( 'pll_get_taxonomies', 'wpbb_hotel_pll_room_type', 10, 2 );
function wpbb_hotel_pll_room_amenity( $tax, $settings ) { $tax['room_amenity']='room_amenity'; return $tax; }
add_filter( 'pll_get_taxonomies', 'wpbb_hotel_pll_room_amenity', 10, 2 );

function wpbb_hotel_register_requests() { register_post_type('hotel_booking',array('labels'=>array('name'=>__( 'Booking Requests', 'wp-bbtheme-child-hotel' ),'singular_name'=>__( 'Booking Request', 'wp-bbtheme-child-hotel' )),'public'=>false,'show_ui'=>true,'show_in_menu'=>'edit.php?post_type=hotel_room','supports'=>array('title'))); }
add_action('init','wpbb_hotel_register_requests',14);
function wpbb_hotel_request_form( $object_id ) {
    $success=isset($_GET['request'])&&'received'===sanitize_key(wp_unslash($_GET['request'])); ob_start(); ?>
    <div class="wpbb-sector-request" id="request"><p class="wp-theme-sector-eyebrow"><?php echo esc_html(__( 'Request your stay', 'wp-bbtheme-child-hotel' )); ?></p><h2><?php echo esc_html(__( 'Send your dates and guest details.', 'wp-bbtheme-child-hotel' )); ?></h2><?php if($success):?><div class="alert alert-success"><?php echo esc_html(__( 'Thanks. Your stay request has been received.', 'wp-bbtheme-child-hotel' )); ?></div><?php endif;?>
    <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>"><input type="hidden" name="action" value="wpbb_hotel_submit_request"><input type="hidden" name="object_id" value="<?php echo esc_attr($object_id); ?>"><?php wp_nonce_field('wpbb_hotel_request_'.$object_id,'wpbb_hotel_request_nonce'); ?>
      <?php echo '<label class=""><span>'.esc_html(__( 'Name', 'wp-bbtheme-child-hotel' )).'</span><input type="text" name="name" required></label>' . '<label class=""><span>'.esc_html(__( 'Email', 'wp-bbtheme-child-hotel' )).'</span><input type="email" name="email" required></label>' . '<label class=""><span>'.esc_html(__( 'Arrival', 'wp-bbtheme-child-hotel' )).'</span><input type="date" name="arrival" required></label>' . '<label class=""><span>'.esc_html(__( 'Departure', 'wp-bbtheme-child-hotel' )).'</span><input type="date" name="departure" required></label>' . '<label class=""><span>'.esc_html(__( 'Guests', 'wp-bbtheme-child-hotel' )).'</span><input type="number" name="guests" min="1" required></label>' . '<label class="is-wide"><span>'.esc_html(__( 'Requests or accessibility needs', 'wp-bbtheme-child-hotel' )).'</span><textarea name="message" rows="5"></textarea></label>'; ?><button class="btn btn-primary" type="submit"><?php echo esc_html(__( 'Request availability', 'wp-bbtheme-child-hotel' )); ?></button>
    </form></div><?php return ob_get_clean();
}
function wpbb_hotel_submit_request() {
    $object_id=absint($_POST['object_id']??0); if(!$object_id||'hotel_room'!==get_post_type($object_id))wp_die(esc_html(__( 'Invalid request.', 'wp-bbtheme-child-hotel' ))); if(empty($_POST['wpbb_hotel_request_nonce'])||!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['wpbb_hotel_request_nonce'])),'wpbb_hotel_request_'.$object_id))wp_die(esc_html(__( 'The form expired. Please try again.', 'wp-bbtheme-child-hotel' )));
    $name=sanitize_text_field(wp_unslash($_POST['name']??'')); $email=sanitize_email(wp_unslash($_POST['email']??'')); $arrival=sanitize_text_field(wp_unslash($_POST['arrival']??'')); $departure=sanitize_text_field(wp_unslash($_POST['departure']??'')); $guests=absint(wp_unslash($_POST['guests']??'')); $message=sanitize_textarea_field(wp_unslash($_POST['message']??'')); if('' === (string) $name || ! is_email( $email ) || '' === (string) $arrival || '' === (string) $departure || '' === (string) $guests)wp_die(esc_html(__( 'Please complete the required fields.', 'wp-bbtheme-child-hotel' )));
    $request_id=wp_insert_post(array('post_type'=>'hotel_booking','post_status'=>'publish','post_title'=>sprintf('%s — %s',get_the_title($object_id),isset($name)?$name:current_time('mysql')))); if($request_id&&!is_wp_error($request_id)){foreach(array('object_id'=>$object_id,'name'=>$name,'email'=>$email,'arrival'=>$arrival,'departure'=>$departure,'guests'=>$guests,'message'=>$message,'status'=>'new') as $key=>$value)update_post_meta($request_id,'_hotel_request_'.$key,$value);}
    wp_safe_redirect(add_query_arg('request','received',get_permalink($object_id)).'#request'); exit;
}
add_action('admin_post_wpbb_hotel_submit_request','wpbb_hotel_submit_request'); add_action('admin_post_nopriv_wpbb_hotel_submit_request','wpbb_hotel_submit_request');

function wpbb_hotel_mega_menu( $definitions, $profile ) {
    if ( ( $profile['id'] ?? '' ) !== 'hotel' ) return $definitions; $archive=get_post_type_archive_link('hotel_room')?:home_url('/rooms/');
    $definitions['hotel_room']=array('title'=>__( 'Rooms navigation', 'wp-bbtheme-child-hotel' ),'target_key'=>'hotel_room','eyebrow'=>__( 'Rooms', 'wp-bbtheme-child-hotel' ),'heading'=>__( 'Find the room that fits the stay.', 'wp-bbtheme-child-hotel' ),'intro'=>__( 'Compare room types, capacity and details before requesting dates.', 'wp-bbtheme-child-hotel' ),'columns'=>array(
      array('title'=>__( 'Explore', 'wp-bbtheme-child-hotel' ),'links'=>array(array(__( 'Rooms', 'wp-bbtheme-child-hotel' ),__( 'Compare room type, capacity and price before requesting your dates.', 'wp-bbtheme-child-hotel' ),$archive),array(__( 'Services', 'wp-bbtheme-child-hotel' ),__( 'A polished booking journey before the guest reaches reception.', 'wp-bbtheme-child-hotel' ),wp_theme_demo_page_url('services')),array(__( 'Solutions', 'wp-bbtheme-child-hotel' ),__( 'Rooms and stays for weekends, work, families and longer visits.', 'wp-bbtheme-child-hotel' ),wp_theme_demo_page_url('industries')))),
      array('title'=>__( 'Plan', 'wp-bbtheme-child-hotel' ),'links'=>array(array(__( 'How it works', 'wp-bbtheme-child-hotel' ),__( 'Choose a room, request dates and arrive with the essentials clear.', 'wp-bbtheme-child-hotel' ),wp_theme_demo_page_url('services')),array(__( 'About', 'wp-bbtheme-child-hotel' ),__( 'Room discovery, amenities, availability requests and local guidance are organised into a calm hotel experience.', 'wp-bbtheme-child-hotel' ),wp_theme_demo_page_url('about')),array(__( 'Contact', 'wp-bbtheme-child-hotel' ),__( 'Talk to the team about the next step.', 'wp-bbtheme-child-hotel' ),wp_theme_demo_page_url('contact')))),
      array('title'=>__( 'Useful', 'wp-bbtheme-child-hotel' ),'links'=>array(array(__( 'Insights', 'wp-bbtheme-child-hotel' ),__( 'Editorial content that helps guests plan the whole visit, not only the room.', 'wp-bbtheme-child-hotel' ),get_permalink(get_option('page_for_posts'))?:home_url('/blog/')),array(__( 'Search', 'wp-bbtheme-child-hotel' ),__( 'Use the live finder to narrow the catalogue.', 'wp-bbtheme-child-hotel' ),$archive),array(__( 'Enquire', 'wp-bbtheme-child-hotel' ),__( 'Send the details needed for a useful response.', 'wp-bbtheme-child-hotel' ),wp_theme_demo_page_url('contact'))))
    )); return $definitions;
}
add_filter('wp_theme_demo_mega_menu_definitions','wpbb_hotel_mega_menu',20,2);
