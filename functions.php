<?php
defined( 'ABSPATH' ) || exit;

function wpbb_hotel_project_mode( $mode ) { return 'hotel'; }
add_filter( 'wp_theme_project_mode', 'wpbb_hotel_project_mode' );

function wpbb_hotel_assets() {
    $theme = wp_get_theme();
    $manifest = get_stylesheet_directory() . '/dist/.vite/manifest.json';
    if ( ! is_readable( $manifest ) ) return;
    $data = json_decode( (string) file_get_contents( $manifest ), true );
    if ( ! is_array( $data ) ) return;
    if ( ! empty( $data['src/scss/public.scss']['file'] ) ) {
        wp_enqueue_style( 'wpbb-hotel-app', get_stylesheet_directory_uri() . '/dist/' . ltrim( $data['src/scss/public.scss']['file'], '/' ), array(), $theme->get( 'Version' ) );
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
    if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) require_once ABSPATH . 'wp-admin/includes/image.php';
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

/**
 * v3.8.10.20: keep editable Mega Menu content out of public discovery / SEO.
 * The parent already registers these objects as private; child filters make the
 * intent explicit for Core XML sitemaps and common SEO plugins too.
 */
function wpbb_child_private_megamenu_post_type_args( $args, $post_type ) {
    if ( 'megamenu' !== $post_type ) return $args;
    $args['public'] = false;
    $args['publicly_queryable'] = false;
    $args['exclude_from_search'] = true;
    $args['has_archive'] = false;
    $args['rewrite'] = false;
    $args['query_var'] = false;
    return $args;
}
add_filter( 'register_post_type_args', 'wpbb_child_private_megamenu_post_type_args', 20, 2 );

function wpbb_child_private_megamenu_taxonomy_args( $args, $taxonomy ) {
    if ( 'megamenu-cat' !== $taxonomy ) return $args;
    $args['public'] = false;
    $args['publicly_queryable'] = false;
    $args['rewrite'] = false;
    $args['query_var'] = false;
    return $args;
}
add_filter( 'register_taxonomy_args', 'wpbb_child_private_megamenu_taxonomy_args', 20, 2 );

function wpbb_child_core_sitemap_post_types( $post_types ) {
    unset( $post_types['megamenu'] );
    return $post_types;
}
add_filter( 'wp_sitemaps_post_types', 'wpbb_child_core_sitemap_post_types', 20 );

function wpbb_child_core_sitemap_taxonomies( $taxonomies ) {
    unset( $taxonomies['megamenu-cat'] );
    return $taxonomies;
}
add_filter( 'wp_sitemaps_taxonomies', 'wpbb_child_core_sitemap_taxonomies', 20 );

function wpbb_child_mega_robots( $robots ) {
    if ( is_singular( 'megamenu' ) || is_tax( 'megamenu-cat' ) ) {
        $robots['noindex'] = true;
        $robots['nofollow'] = true;
    }
    return $robots;
}
add_filter( 'wp_robots', 'wpbb_child_mega_robots', 20 );

function wpbb_child_yoast_exclude_megamenu_post_type( $excluded, $post_type ) {
    return 'megamenu' === $post_type ? true : $excluded;
}
add_filter( 'wpseo_sitemap_exclude_post_type', 'wpbb_child_yoast_exclude_megamenu_post_type', 20, 2 );

function wpbb_child_yoast_exclude_megamenu_taxonomy( $excluded, $taxonomy ) {
    return 'megamenu-cat' === $taxonomy ? true : $excluded;
}
add_filter( 'wpseo_sitemap_exclude_taxonomy', 'wpbb_child_yoast_exclude_megamenu_taxonomy', 20, 2 );

function wpbb_child_yoast_mega_robots( $robots ) {
    if ( is_singular( 'megamenu' ) || is_tax( 'megamenu-cat' ) ) return 'noindex, nofollow';
    return $robots;
}
add_filter( 'wpseo_robots', 'wpbb_child_yoast_mega_robots', 20 );


/**
 * v3.8.10.21: global request-a-quote UI is opt-in by child theme.
 * Sector themes with their own quote journeys can keep it; the rest do not
 * expose an unrelated floating "My Quote" control or public route.
 */
if ( ! function_exists( 'wpbb_child_request_quote_enabled' ) ) {
    function wpbb_child_request_quote_enabled() {
        $enabled_themes = array(
            'wp-bbtheme-child-automotive',
            'wp-bbtheme-child-building-services',
            'wp-bbtheme-child-insurance',
            'wp-bbtheme-child-logistics',
            'wp-bbtheme-child-medicine',
            'wp-bbtheme-child-woo-tech-shop',
        );
        $enabled = in_array( get_stylesheet(), $enabled_themes, true );
        return (bool) apply_filters( 'wpbb_child_request_quote_enabled', $enabled, get_stylesheet() );
    }
}

function wpbb_child_request_quote_body_class( $classes ) {
    $classes[] = wpbb_child_request_quote_enabled() ? 'wpbb-request-quote-enabled' : 'wpbb-request-quote-disabled';
    return $classes;
}
add_filter( 'body_class', 'wpbb_child_request_quote_body_class', 30 );

function wpbb_child_request_quote_menu_items( $items ) {
    if ( wpbb_child_request_quote_enabled() ) return $items;
    $target = trim( (string) wp_parse_url( home_url( '/request-a-quote/' ), PHP_URL_PATH ), '/' );
    foreach ( $items as $key => $item ) {
        $path = trim( (string) wp_parse_url( $item->url, PHP_URL_PATH ), '/' );
        if ( $target && $path === $target ) unset( $items[ $key ] );
    }
    return $items;
}
add_filter( 'wp_nav_menu_objects', 'wpbb_child_request_quote_menu_items', 30 );

function wpbb_child_request_quote_disable_route() {
    if ( wpbb_child_request_quote_enabled() ) return;
    $request = isset( $GLOBALS['wp']->request ) ? trim( (string) $GLOBALS['wp']->request, '/' ) : '';
    if ( ! is_page( 'request-a-quote' ) && 'request-a-quote' !== $request ) return;

    global $wp_query;
    if ( $wp_query ) $wp_query->set_404();
    status_header( 404 );
    nocache_headers();
    $template = get_404_template();
    if ( $template ) {
        include $template;
        exit;
    }
    wp_die( esc_html__( 'Page not found.', 'wp-bbtheme-child' ), esc_html__( 'Not found', 'wp-bbtheme-child' ), array( 'response' => 404 ) );
}
add_action( 'template_redirect', 'wpbb_child_request_quote_disable_route', 1 );

function wpbb_child_request_quote_sitemap_args( $args, $post_type ) {
    if ( wpbb_child_request_quote_enabled() || 'page' !== $post_type ) return $args;
    $page = get_page_by_path( 'request-a-quote' );
    if ( $page ) {
        $excluded = isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array();
        $excluded[] = (int) $page->ID;
        $args['post__not_in'] = array_values( array_unique( $excluded ) );
    }
    return $args;
}
add_filter( 'wp_sitemaps_posts_query_args', 'wpbb_child_request_quote_sitemap_args', 30, 2 );

require_once get_stylesheet_directory() . '/inc/seo-guardrails.php';

/** v3.8.10.24: identify generated legal pages independently of translated slugs. */
function wpbb_child_legal_page_body_class_v381024( $classes ) {
    if ( ! is_page() ) return $classes;
    $post = get_queried_object();
    if ( ! $post instanceof WP_Post ) return $classes;

    $is_legal = function_exists( 'is_privacy_policy' ) && is_privacy_policy();
    if ( ! $is_legal && false !== strpos( (string) $post->post_content, 'wp-theme-legal-section' ) ) {
        $is_legal = true;
    }
    if ( $is_legal ) $classes[] = 'wpbb-legal-page';
    return array_values( array_unique( $classes ) );
}
add_filter( 'body_class', 'wpbb_child_legal_page_body_class_v381024', 40 );

/** v3.8.10.25: remove generated empty spacing without touching authored copy. */
if ( ! function_exists( 'wpbb_child_remove_empty_paragraphs_v381025' ) ) {
    function wpbb_child_remove_empty_paragraphs_v381025( $content ) {
        if ( is_admin() || ! is_string( $content ) || '' === $content ) return $content;
        return (string) preg_replace(
            '~<p(?:\\s[^>]*)?>(?:\\s|&nbsp;|&#160;|<br\\s*/?>)*</p>~i',
            '',
            $content
        );
    }
}
add_filter( 'the_content', 'wpbb_child_remove_empty_paragraphs_v381025', 120 );

/** v3.8.10.25: do not output a completely empty CTA block above the footer. */
if ( ! function_exists( 'wpbb_child_remove_empty_cta_v381025' ) ) {
    function wpbb_child_remove_empty_cta_v381025( $block_content, $block ) {
        if ( empty( $block['blockName'] ) || 'wpbb/cta-section' !== $block['blockName'] || ! is_string( $block_content ) ) return $block_content;
        if ( preg_match( '~<(?:img|picture|video|iframe|form|button|a)\\b~i', $block_content ) ) return $block_content;
        $plain = trim( html_entity_decode( wp_strip_all_tags( $block_content ), ENT_QUOTES | ENT_HTML5, get_bloginfo( 'charset' ) ) );
        return '' === $plain ? '' : $block_content;
    }
}
add_filter( 'render_block', 'wpbb_child_remove_empty_cta_v381025', 120, 2 );



/** v3.8.10.29: make demo switching/imports self-healing across child themes. */
if ( ! function_exists( 'wpbb_child_demo_refresh_on_activation_v381029' ) ) {
    function wpbb_child_demo_refresh_on_activation_v381029() {
        // The parent importer stores one global version/profile. When a different
        // child theme is activated, invalidate that marker so its own profile is
        // imported instead of reusing the previous child's demo state.
        delete_option( 'wp_theme_demo_import_version' );
        delete_option( 'wp_theme_demo_menu_profile' );
    }
    add_action( 'after_switch_theme', 'wpbb_child_demo_refresh_on_activation_v381029', 5 );
}

if ( ! function_exists( 'wpbb_child_demo_integrity_guard_v381029' ) ) {
    function wpbb_child_demo_integrity_guard_v381029( $page_id = 0, $profile = array() ) {
        $page_id = absint( $page_id ?: get_option( 'page_on_front' ) );
        if ( ! $page_id || 'page' !== get_post_type( $page_id ) ) return;

        $content = (string) get_post_field( 'post_content', $page_id );
        // Never rewrite a real imported or edited homepage. This is only a guard
        // for the genuinely empty/near-empty page seen after switching demos.
        if ( strlen( trim( $content ) ) >= 120 ) return;

        if ( ! is_array( $profile ) ) $profile = array();
        $eyebrow = (string) ( $profile['eyebrow'] ?? __( 'Welcome', 'wp-theme' ) );
        $title = (string) ( $profile['hero_title'] ?? get_bloginfo( 'name' ) );
        $intro = (string) ( $profile['hero_text'] ?? __( 'A practical WordPress starter site ready to edit.', 'wp-theme' ) );
        $primary_label = (string) ( $profile['primary_label'] ?? __( 'Get started', 'wp-theme' ) );
        $primary_url = (string) ( $profile['primary_url'] ?? home_url( '/contact/' ) );
        $secondary_label = (string) ( $profile['secondary_label'] ?? __( 'Explore', 'wp-theme' ) );
        $secondary_url = (string) ( $profile['secondary_url'] ?? home_url( '/services/' ) );
        $services_heading = (string) ( $profile['services_heading'] ?? __( 'Useful services, clearly presented.', 'wp-theme' ) );
        $about_title = (string) ( $profile['about_title'] ?? __( 'A flexible starting point for the real site.', 'wp-theme' ) );
        $about_text = (string) ( $profile['about_text'] ?? $intro );
        $hero_image = esc_url( (string) ( $profile['hero_image'] ?? '' ) );
        $about_image = esc_url( (string) ( $profile['about_image'] ?? $hero_image ) );
        $services = ! empty( $profile['services'] ) && is_array( $profile['services'] ) ? array_slice( $profile['services'], 0, 4 ) : array();
        $stats = ! empty( $profile['stats'] ) && is_array( $profile['stats'] ) ? array_slice( $profile['stats'], 0, 4 ) : array();

        $out = '<!-- wp:group {"className":"wp-theme-section-shell wp-theme-sector-hero wp-theme-demo-repair","layout":{"type":"default"}} --><div class="wp-block-group wp-theme-section-shell wp-theme-sector-hero wp-theme-demo-repair"><!-- wp:wpbb/row {"containerClass":"container","customClasses":"align-items-center"} --><!-- wp:wpbb/column {"xs":12,"lg":6} --><p class="wp-theme-sector-eyebrow">' . esc_html( $eyebrow ) . '</p><h1>' . esc_html( $title ) . '</h1><p class="wp-theme-sector-lead">' . esc_html( $intro ) . '</p><div class="wp-theme-demo-buttons"><a class="btn btn-primary" href="' . esc_url( $primary_url ) . '">' . esc_html( $primary_label ) . '</a><a class="btn btn-outline-primary" href="' . esc_url( $secondary_url ) . '">' . esc_html( $secondary_label ) . '</a></div><!-- /wp:wpbb/column -->';
        if ( $hero_image ) $out .= '<!-- wp:wpbb/column {"xs":12,"lg":6} --><figure class="wp-theme-sector-page-image"><img src="' . $hero_image . '" alt="" loading="eager" decoding="async"></figure><!-- /wp:wpbb/column -->';
        $out .= '<!-- /wp:wpbb/row --></div><!-- /wp:group -->';

        if ( 'automotive' === ( $profile['id'] ?? '' ) ) {
            $out .= '<!-- wp:group {"className":"wp-theme-section-shell wpbb-automotive-finder-section","layout":{"type":"default"}} --><div class="wp-block-group wp-theme-section-shell wpbb-automotive-finder-section" id="finder"><!-- wp:wpbb/row {"containerClass":"container"} --><!-- wp:wpbb/column {"xs":12} --><!-- wp:wpbb/sector-finder {"context":"automotive","limit":8} /--><!-- /wp:wpbb/column --><!-- /wp:wpbb/row --></div><!-- /wp:group -->';
        }

        $out .= '<!-- wp:group {"className":"wp-theme-section-shell wp-theme-services-section","layout":{"type":"default"}} --><div class="wp-block-group wp-theme-section-shell wp-theme-services-section"><!-- wp:wpbb/row {"containerClass":"container"} --><!-- wp:wpbb/column {"xs":12} --><p class="wp-theme-sector-eyebrow">' . esc_html( (string) ( $profile['services_eyebrow'] ?? __( 'Services', 'wp-theme' ) ) ) . '</p><h2>' . esc_html( $services_heading ) . '</h2><!-- wp:wpbb/row {"gutterX":"gx-4","gutterY":"gy-4"} -->';
        foreach ( $services as $service ) {
            $service_title = is_array( $service ) ? (string) ( $service[0] ?? '' ) : '';
            $service_text = is_array( $service ) ? (string) ( $service[1] ?? '' ) : '';
            if ( '' === trim( $service_title ) ) continue;
            $out .= '<!-- wp:wpbb/column {"xs":12,"md":6,"lg":3} --><article class="wp-theme-sector-card"><h3>' . esc_html( $service_title ) . '</h3><p>' . esc_html( $service_text ) . '</p></article><!-- /wp:wpbb/column -->';
        }
        $out .= '<!-- /wp:wpbb/row --><!-- /wp:wpbb/column --><!-- /wp:wpbb/row --></div><!-- /wp:group -->';

        $out .= '<!-- wp:group {"className":"wp-theme-section-shell wp-theme-about-section","layout":{"type":"default"}} --><div class="wp-block-group wp-theme-section-shell wp-theme-about-section"><!-- wp:wpbb/row {"containerClass":"container","customClasses":"align-items-center"} -->';
        if ( $about_image ) $out .= '<!-- wp:wpbb/column {"xs":12,"lg":6} --><figure class="wp-theme-sector-page-image"><img src="' . $about_image . '" alt="" loading="lazy" decoding="async"></figure><!-- /wp:wpbb/column -->';
        $out .= '<!-- wp:wpbb/column {"xs":12,"lg":6} --><p class="wp-theme-sector-eyebrow">' . esc_html( (string) ( $profile['about_eyebrow'] ?? __( 'About', 'wp-theme' ) ) ) . '</p><h2>' . esc_html( $about_title ) . '</h2><p class="wp-theme-sector-lead">' . esc_html( $about_text ) . '</p><!-- /wp:wpbb/column --><!-- /wp:wpbb/row --></div><!-- /wp:group -->';

        if ( $stats ) {
            $out .= '<!-- wp:group {"className":"wp-theme-section-shell wp-theme-sector-proof","layout":{"type":"default"}} --><div class="wp-block-group wp-theme-section-shell wp-theme-sector-proof"><!-- wp:wpbb/row {"containerClass":"container","gutterX":"gx-3","gutterY":"gy-3"} -->';
            foreach ( $stats as $stat ) {
                $number = is_array( $stat ) ? (string) ( $stat[0] ?? '' ) : '';
                $label = is_array( $stat ) ? (string) ( $stat[1] ?? '' ) : '';
                $out .= '<!-- wp:wpbb/column {"xs":6,"lg":3} --><div class="wp-theme-sector-proof__item"><h3>' . esc_html( $number ) . '</h3><p>' . esc_html( $label ) . '</p></div><!-- /wp:wpbb/column -->';
            }
            $out .= '<!-- /wp:wpbb/row --></div><!-- /wp:group -->';
        }

        $out .= '<!-- wp:wpbb/cta-section {"title":"' . esc_attr( (string) ( $profile['cta_title'] ?? __( 'Ready to make it yours?', 'wp-theme' ) ) ) . '","titleTag":"h2","text":"' . esc_attr( (string) ( $profile['cta_text'] ?? $intro ) ) . '","buttonText":"' . esc_attr( $primary_label ) . '","buttonUrl":"' . esc_url( $primary_url ) . '","className":"wp-theme-home-cta wp-theme-home-cta--bbuilder"} /-->';

        wp_update_post( array( 'ID' => $page_id, 'post_content' => $out ) );
        update_post_meta( $page_id, '_wp_theme_demo_repaired_381029', current_time( 'mysql' ) );
    }
    add_action( 'wp_theme_after_demo_import', 'wpbb_child_demo_integrity_guard_v381029', 99, 2 );
}


/* v3.8.10.30 visual icon configuration */
function wpbb_hotel_visual_icon_config() {
    $config = array( 'base' => get_stylesheet_directory_uri(), 'icons' => array('bed', 'calendar', 'building', 'map-pin', 'tools-kitchen-2', 'users', 'camera', 'shield') );
    echo '<script>window.wpbbChildVisuals=' . wp_json_encode( $config ) . ';</script>';
}
add_action( 'wp_footer', 'wpbb_hotel_visual_icon_config', 1 );


/* v3.8.10.30: realistic demo blog featured images. Runs only after the theme's explicit demo import. */
function wpbb_hotel_demo_blog_photo_attachment( $filename, $title ) {
    $slug = sanitize_title( pathinfo( $filename, PATHINFO_FILENAME ) );
    $existing = get_page_by_path( 'hotel-blog-' . $slug, OBJECT, 'attachment' );
    if ( $existing ) {
        if ( function_exists( 'wpbb_hotel_refresh_bundled_attachment_v381041' ) ) wpbb_hotel_refresh_bundled_attachment_v381041( (int) $existing->ID, 'assets/img/blog' );
        return (int) $existing->ID;
    }
    $source = get_stylesheet_directory() . '/assets/img/blog/' . basename( $filename );
    if ( ! is_readable( $source ) ) return 0;
    $uploads = wp_upload_dir();
    $dir = trailingslashit( $uploads['basedir'] ) . 'hotel-blog';
    wp_mkdir_p( $dir );
    $target = $dir . '/' . basename( $filename );
    if ( ! file_exists( $target ) ) copy( $source, $target );
    $filetype = wp_check_filetype( $target );
    if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) require_once ABSPATH . 'wp-admin/includes/image.php';
    $id = wp_insert_attachment( array(
        'post_mime_type' => $filetype['type'] ?: 'image/jpeg',
        'post_title' => $title,
        'post_name' => 'hotel-blog-' . $slug,
        'post_status' => 'inherit',
    ), $target );
    if ( $id && ! is_wp_error( $id ) ) {
        if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) require_once ABSPATH . 'wp-admin/includes/image.php';
        $meta = wp_generate_attachment_metadata( $id, $target );
        if ( $meta ) wp_update_attachment_metadata( $id, $meta );
        update_post_meta( $id, '_wp_attachment_image_alt', $title );
        return (int) $id;
    }
    return 0;
}
function wpbb_hotel_seed_demo_blog_photos( $page_id = 0, $profile = array() ) {
    $posts = get_posts( array( 'post_type'=>'post', 'post_status'=>'publish', 'posts_per_page'=>12, 'orderby'=>'date', 'order'=>'DESC' ) );
    if ( ! $posts ) return;
    $images = array( 'blog-1.jpg','blog-2.jpg','blog-3.jpg','blog-4.jpg','blog-5.jpg','blog-6.jpg' );
    foreach ( $posts as $index => $post ) {
        $filename = $images[ $index % count( $images ) ];
        $attachment = wpbb_hotel_demo_blog_photo_attachment( $filename, get_the_title( $post ) );
        if ( $attachment ) set_post_thumbnail( $post->ID, $attachment );
    }
}
add_action( 'wp_theme_after_demo_import', 'wpbb_hotel_seed_demo_blog_photos', 70, 2 );


/** v3.8.10.31: apply bundled realistic media to already-imported demos after theme upgrade. */

/**
 * Refresh an already-imported demo attachment from the current child-theme asset.
 *
 * Image optimisation may have changed `_wp_attached_file` from e.g. item-1.jpg to
 * item-1.avif/webp. Resolve the bundled source by filename stem instead of requiring
 * the child theme to ship every generated format, then regenerate all WP sub-sizes.
 */
function wpbb_hotel_refresh_bundled_attachment_v381041( $attachment_id, $asset_dir ) {
    $attachment_id = absint( $attachment_id );
    if ( ! $attachment_id || 'attachment' !== get_post_type( $attachment_id ) ) return false;

    $attached = (string) get_post_meta( $attachment_id, '_wp_attached_file', true );
    $stem = pathinfo( basename( $attached ), PATHINFO_FILENAME );
    if ( '' === $stem ) return false;

    $base = trailingslashit( get_stylesheet_directory() ) . trailingslashit( $asset_dir ) . $stem;
    $source = '';
    foreach ( array( '.jpg', '.jpeg', '.png', '.webp', '.avif' ) as $extension ) {
        if ( is_readable( $base . $extension ) ) {
            $source = $base . $extension;
            break;
        }
    }
    if ( ! $source ) return false;

    $target = get_attached_file( $attachment_id );
    if ( ! $target ) return false;

    if ( ! function_exists( 'wp_generate_attachment_metadata' ) ) require_once ABSPATH . 'wp-admin/includes/image.php';

    $source_ext = strtolower( (string) pathinfo( $source, PATHINFO_EXTENSION ) );
    $target_ext = strtolower( (string) pathinfo( $target, PATHINFO_EXTENSION ) );
    $written = false;

    if ( $source_ext === $target_ext ) {
        $written = (bool) @copy( $source, $target );
    } else {
        $target_type = wp_check_filetype( $target );
        $target_mime = ! empty( $target_type['type'] ) ? (string) $target_type['type'] : '';
        $editor = wp_get_image_editor( $source );
        if ( ! is_wp_error( $editor ) && 0 === strpos( $target_mime, 'image/' ) ) {
            $saved = $editor->save( $target, $target_mime );
            $written = ! is_wp_error( $saved ) && is_readable( $target );
        }
    }

    // Some hosts can read AVIF/WebP but cannot encode it. Fall back to the bundled
    // source extension and update WordPress to the new original file explicitly.
    if ( ! $written ) {
        $fallback = trailingslashit( dirname( $target ) ) . $stem . '.' . $source_ext;
        if ( ! @copy( $source, $fallback ) ) return false;
        update_attached_file( $attachment_id, $fallback );
        $filetype = wp_check_filetype( $fallback );
        if ( ! empty( $filetype['type'] ) ) {
            wp_update_post( array( 'ID' => $attachment_id, 'post_mime_type' => $filetype['type'] ) );
        }
        $target = $fallback;
    }

    // Remove old generated sizes first. Otherwise stale JPG thumbnails can remain
    // referenced after the original was converted to AVIF/WebP by an optimiser.
    $old_meta = wp_get_attachment_metadata( $attachment_id );
    if ( is_array( $old_meta ) && ! empty( $old_meta['sizes'] ) && is_array( $old_meta['sizes'] ) ) {
        foreach ( $old_meta['sizes'] as $old_size ) {
            if ( empty( $old_size['file'] ) ) continue;
            $old_file = trailingslashit( dirname( $target ) ) . basename( (string) $old_size['file'] );
            if ( is_file( $old_file ) && wp_normalize_path( $old_file ) !== wp_normalize_path( $target ) ) @unlink( $old_file );
        }
    }

    $meta = wp_generate_attachment_metadata( $attachment_id, $target );
    if ( $meta ) wp_update_attachment_metadata( $attachment_id, $meta );
    clean_attachment_cache( $attachment_id );
    return true;
}

function wpbb_hotel_realistic_media_upgrade_v381041() {
    if ( ( function_exists( 'wp_doing_ajax' ) && wp_doing_ajax() ) || ( function_exists( 'wp_doing_cron' ) && wp_doing_cron() ) ) return;
    $done_key = 'wpbb_hotel_realistic_media_upgrade_v381041';
    if ( get_option( $done_key ) ) return;
    if ( ! current_user_can( 'manage_options' ) ) return;

    $pairs = array(array('wpbb-hotel','assets/img/demo'),array('hotel-blog','assets/img/blog'));
    foreach ( $pairs as $pair ) {
        $upload_prefix = $pair[0];
        $asset_dir = $pair[1];
        $ids = get_posts( array(
            'post_type' => 'attachment',
            'post_status' => 'inherit',
            'posts_per_page' => -1,
            'fields' => 'ids',
            'meta_query' => array( array( 'key'=>'_wp_attached_file', 'value'=>$upload_prefix . '/', 'compare'=>'LIKE' ) ),
        ) );
        foreach ( $ids as $attachment_id ) {
            wpbb_hotel_refresh_bundled_attachment_v381041( $attachment_id, $asset_dir );
        }
    }
    if ( function_exists( 'wpbb_hotel_seed_directory' ) ) wpbb_hotel_seed_directory( array( 'id'=>'hotel' ) );
    if ( function_exists( 'wpbb_hotel_seed_demo_blog_photos' ) ) wpbb_hotel_seed_demo_blog_photos( 0, array() );
    update_option( $done_key, current_time( 'mysql' ), false );
}
add_action( 'admin_init', 'wpbb_hotel_realistic_media_upgrade_v381041', 120 );


/* v3.8.10.42: full-width single-column demo rows + optional frontend demo protection. */
function wpbb_child_381042_repair_single_columns( $blocks ) {
    foreach ( $blocks as &$block ) {
        if ( 'wpbb/row' === ( $block['blockName'] ?? '' ) && ! empty( $block['innerBlocks'] ) ) {
            $column_indexes = array();
            foreach ( $block['innerBlocks'] as $index => $inner ) {
                if ( 'wpbb/column' === ( $inner['blockName'] ?? '' ) ) $column_indexes[] = $index;
            }
            if ( 1 === count( $column_indexes ) ) {
                $idx = $column_indexes[0];
                $attrs = $block['innerBlocks'][ $idx ]['attrs'] ?? array();
                if ( 12 === (int) ( $attrs['xs'] ?? 12 ) ) {
                    $attrs['xs'] = 12;
                    foreach ( array( 'sm', 'md', 'lg', 'xl', 'xxl' ) as $breakpoint ) unset( $attrs[ $breakpoint ] );
                    $block['innerBlocks'][ $idx ]['attrs'] = $attrs;
                }
            }
        }
        if ( ! empty( $block['innerBlocks'] ) ) $block['innerBlocks'] = wpbb_child_381042_repair_single_columns( $block['innerBlocks'] );
    }
    unset( $block );
    return $blocks;
}

function wpbb_child_381042_repair_demo_page_widths() {
    $pages = get_posts( array(
        'post_type' => 'page', 'post_status' => 'any', 'posts_per_page' => -1,
        'meta_key' => '_wp_theme_demo_managed', 'meta_value' => '1', 'fields' => 'ids',
    ) );
    foreach ( $pages as $page_id ) {
        $content = (string) get_post_field( 'post_content', $page_id );
        if ( false === strpos( $content, 'wpbb/column' ) ) continue;
        $blocks = parse_blocks( $content );
        $repaired = serialize_blocks( wpbb_child_381042_repair_single_columns( $blocks ) );
        if ( $repaired !== $content ) wp_update_post( array( 'ID' => $page_id, 'post_content' => $repaired ) );
    }
}
add_action( 'wp_theme_after_demo_import', 'wpbb_child_381042_repair_demo_page_widths', 140 );
function wpbb_child_381042_repair_demo_page_widths_once() {
    if ( ! is_admin() || ! current_user_can( 'manage_options' ) ) return;
    $key = 'wpbb_381042_single_col_' . sanitize_key( get_stylesheet() );
    if ( get_option( $key ) ) return;
    wpbb_child_381042_repair_demo_page_widths();
    update_option( $key, 1, false );
}
add_action( 'admin_init', 'wpbb_child_381042_repair_demo_page_widths_once', 40 );

function wpbb_child_381042_protection_keys() {
    $slug = sanitize_key( get_stylesheet() );
    return array( 'enabled' => 'wpbb_demo_protection_enabled_' . $slug, 'hash' => 'wpbb_demo_protection_hash_' . $slug );
}
function wpbb_child_381042_protection_bootstrap() {
    $keys = wpbb_child_381042_protection_keys();
    if ( false === get_option( $keys['enabled'], false ) ) add_option( $keys['enabled'], '1', '', false );
    if ( false === get_option( $keys['hash'], false ) ) add_option( $keys['hash'], wp_hash_password( 'wp@demo' ), '', false );
}
add_action( 'init', 'wpbb_child_381042_protection_bootstrap', 1 );
function wpbb_child_381042_protection_enabled() {
    $keys = wpbb_child_381042_protection_keys();
    return '0' !== (string) get_option( $keys['enabled'], '1' );
}
function wpbb_child_381042_access_token() {
    $keys = wpbb_child_381042_protection_keys();
    return hash_hmac( 'sha256', (string) get_option( $keys['hash'], '' ), wp_salt( 'auth' ) );
}
function wpbb_child_381042_has_access() {
    if ( current_user_can( 'manage_options' ) ) return true;
    $cookie = isset( $_COOKIE['wpbb_demo_access'] ) ? sanitize_text_field( wp_unslash( $_COOKIE['wpbb_demo_access'] ) ) : '';
    return $cookie && hash_equals( wpbb_child_381042_access_token(), $cookie );
}
function wpbb_child_381042_protection_gate() {
    if ( ! wpbb_child_381042_protection_enabled() || is_admin() || wp_doing_ajax() || wp_doing_cron() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) || ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) || wpbb_child_381042_has_access() ) return;
    $keys = wpbb_child_381042_protection_keys();
    $error = false;
    if ( 'POST' === strtoupper( $_SERVER['REQUEST_METHOD'] ?? '' ) && isset( $_POST['wpbb_demo_password'] ) ) {
        $password = (string) wp_unslash( $_POST['wpbb_demo_password'] );
        if ( wp_check_password( $password, (string) get_option( $keys['hash'], '' ) ) ) {
            $token = wpbb_child_381042_access_token();
            setcookie( 'wpbb_demo_access', $token, array( 'expires' => time() + DAY_IN_SECONDS, 'path' => '/', 'secure' => is_ssl(), 'httponly' => true, 'samesite' => 'Lax' ) );
            $_COOKIE['wpbb_demo_access'] = $token;
            $target = home_url( wp_unslash( $_SERVER['REQUEST_URI'] ?? '/' ) );
            wp_safe_redirect( $target ); exit;
        }
        $error = true;
    }
    $brand = '#253E5B';
    $site = get_bloginfo( 'name' );
    $theme = wp_get_theme()->get( 'Name' );
    nocache_headers(); status_header( 401 );
    ?><!doctype html><html <?php language_attributes(); ?>><head><meta charset="<?php bloginfo( 'charset' ); ?>"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="robots" content="noindex,nofollow"><title><?php echo esc_html( $site ); ?> — Protected Demo</title><style>
    :root{--brand:<?php echo esc_html( $brand ); ?>}*{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:28px;background:linear-gradient(145deg,#07111d,#102131 58%,#0a1520);color:#132033;font:16px/1.55 Inter,system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif}.wpbb-demo-lock{width:min(100%,470px);padding:38px;border:1px solid rgba(255,255,255,.25);border-radius:24px;background:#fff;box-shadow:0 30px 90px rgba(0,0,0,.32)}.wpbb-demo-lock__icon{width:64px;height:64px;display:grid;place-items:center;margin-bottom:24px;border-radius:18px;background:color-mix(in srgb,var(--brand) 12%,#fff);color:var(--brand)}.wpbb-demo-lock__icon svg{width:32px;height:32px}.wpbb-demo-lock small{display:block;margin-bottom:8px;color:var(--brand);font-weight:800;letter-spacing:.12em;text-transform:uppercase}.wpbb-demo-lock h1{margin:0 0 12px;font-size:34px;line-height:1.08;letter-spacing:-.035em}.wpbb-demo-lock p{margin:0 0 24px;color:#657386}.wpbb-demo-lock label{display:block;margin-bottom:8px;font-size:13px;font-weight:750}.wpbb-demo-lock input{width:100%;height:50px;padding:0 15px;border:1px solid #d5dde5;border-radius:11px;background:#fff;color:#132033;font:inherit;outline:none}.wpbb-demo-lock input:focus{border-color:var(--brand);box-shadow:0 0 0 3px color-mix(in srgb,var(--brand) 14%,transparent)}.wpbb-demo-lock button{width:100%;height:50px;margin-top:14px;border:0;border-radius:11px;background:var(--brand);color:#fff;font:750 16px/1 inherit;cursor:pointer}.wpbb-demo-lock__error{margin:0 0 16px;padding:10px 12px;border-radius:10px;background:#fff1f0;color:#a12b22;font-size:14px}.wpbb-demo-lock__meta{margin-top:20px!important;margin-bottom:0!important;font-size:12px;color:#8a96a4!important}@media(max-width:520px){.wpbb-demo-lock{padding:28px 22px}.wpbb-demo-lock h1{font-size:29px}}
    </style></head><body><main class="wpbb-demo-lock"><div class="wpbb-demo-lock__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a12 12 0 0 0 8.5 3a12 12 0 0 1 -8.5 15a12 12 0 0 1 -8.5 -15a12 12 0 0 0 8.5 -3"/><path d="M9 12l2 2l4 -4"/></svg></div><small><?php echo esc_html( $theme ); ?></small><h1><?php echo esc_html__( 'Protected demo', 'wp-theme' ); ?></h1><p><?php echo esc_html__( 'Enter the demo password to view this website.', 'wp-theme' ); ?></p><?php if ( $error ) : ?><div class="wpbb-demo-lock__error"><?php echo esc_html__( 'That password is not correct. Please try again.', 'wp-theme' ); ?></div><?php endif; ?><form method="post"><label for="wpbb-demo-password"><?php echo esc_html__( 'Password', 'wp-theme' ); ?></label><input id="wpbb-demo-password" name="wpbb_demo_password" type="password" autocomplete="current-password" autofocus required><button type="submit"><?php echo esc_html__( 'View demo', 'wp-theme' ); ?></button></form><p class="wpbb-demo-lock__meta"><?php echo esc_html( $site ); ?></p></main></body></html><?php exit;
}
add_action( 'template_redirect', 'wpbb_child_381042_protection_gate', -1000 );

function wpbb_child_381042_save_protection_settings() {
    if ( ! current_user_can( 'manage_options' ) ) wp_die( esc_html__( 'You are not allowed to change these settings.', 'wp-theme' ) );
    check_admin_referer( 'wpbb_child_381042_save_protection' );
    $keys = wpbb_child_381042_protection_keys();
    update_option( $keys['enabled'], isset( $_POST['enabled'] ) ? '1' : '0', false );
    $password = isset( $_POST['password'] ) ? trim( (string) wp_unslash( $_POST['password'] ) ) : '';
    if ( '' !== $password ) update_option( $keys['hash'], wp_hash_password( $password ), false );
    wp_safe_redirect( add_query_arg( array( 'page' => 'wp-theme-settings', 'wpbb_protection_saved' => '1' ), admin_url( 'options-general.php' ) ) ); exit;
}
add_action( 'admin_post_wpbb_child_381042_save_protection', 'wpbb_child_381042_save_protection_settings' );

function wpbb_child_381042_protection_settings_markup() {
    $keys = wpbb_child_381042_protection_keys();
    $enabled = wpbb_child_381042_protection_enabled();
    ?><div class="notice" style="padding:0;border-left:4px solid #253E5B;box-shadow:0 1px 3px rgba(0,0,0,.08)"><div style="padding:18px 20px"><h2 style="margin:0 0 8px">Frontend Demo Protection</h2><p style="max-width:760px">Protect only the public frontend. WP Admin, AJAX and REST requests remain available. The initial password is <code>wp@demo</code>; enter a new password below only when you want to replace it.</p><?php if ( isset( $_GET['wpbb_protection_saved'] ) ) : ?><p style="color:#16813b;font-weight:700">Settings saved.</p><?php endif; ?><form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="display:grid;grid-template-columns:minmax(240px,340px) minmax(240px,420px) auto;gap:14px;align-items:end;max-width:980px"><input type="hidden" name="action" value="wpbb_child_381042_save_protection"><?php wp_nonce_field( 'wpbb_child_381042_save_protection' ); ?><label style="display:flex;gap:8px;align-items:center;min-height:40px"><input type="checkbox" name="enabled" value="1" <?php checked( $enabled ); ?>> <strong>Enable frontend password protection</strong></label><label><strong style="display:block;margin-bottom:6px">Change password</strong><input class="regular-text" type="password" name="password" autocomplete="new-password" placeholder="Leave blank to keep the current password"></label><button class="button button-primary" type="submit">Save protection settings</button></form></div></div><?php
}
function wpbb_child_381042_theme_settings_fallback() {
    echo '<div class="wrap"><h1>' . esc_html__( 'Theme Settings', 'wp-theme' ) . '</h1>';
    wpbb_child_381042_protection_settings_markup();
    echo '</div>';
}
function wpbb_child_381042_register_theme_settings_fallback() {
    global $submenu;
    $exists = false;
    foreach ( (array) ( $submenu['options-general.php'] ?? array() ) as $item ) if ( ( $item[2] ?? '' ) === 'wp-theme-settings' ) { $exists = true; break; }
    if ( ! $exists ) {
        $GLOBALS['wpbb_child_381042_settings_fallback'] = true;
        add_options_page( __( 'Theme Settings', 'wp-theme' ), __( 'Theme Settings', 'wp-theme' ), 'manage_options', 'wp-theme-settings', 'wpbb_child_381042_theme_settings_fallback' );
    }
}
add_action( 'admin_menu', 'wpbb_child_381042_register_theme_settings_fallback', 99 );
function wpbb_child_381042_inject_protection_settings() {
    if ( ! current_user_can( 'manage_options' ) || ( $_GET['page'] ?? '' ) !== 'wp-theme-settings' || ! empty( $GLOBALS['wpbb_child_381042_settings_fallback'] ) ) return;
    wpbb_child_381042_protection_settings_markup();
}
add_action( 'admin_notices', 'wpbb_child_381042_inject_protection_settings', 20 );
