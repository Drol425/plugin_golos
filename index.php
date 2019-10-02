<?php
/*
Plugin Name: Beauty contest - Missprincessa
Description: Add post types for movies and movie reviews
Author: Drol
*/
 
// Hook <strong>lc_custom_post_movie()</strong> to the init action hook
add_action( 'init', 'lc_custom_post_movie1' );
 
// The custom function to register a movie post type
function lc_custom_post_movie1() {
 
  // Set the labels, this variable is used in the $args array
  $labels = array(
    'name'               => __( 'Моделі' ),
    'singular_name'      => __( 'Movie' ),
    'add_new'            => __( 'Додати модель' ),
    'add_new_item'       => __( 'Додати модель' ),
    'edit_item'          => __( 'Редагувати' ),
    'new_item'           => __( 'Нова модель' ),
    'all_items'          => __( 'Всі моделі' ),
    'view_item'          => __( 'Показати голосування' ),
    'search_items'       => __( 'Пошук' ),
    'featured_image'     => 'Poster',
    'set_featured_image' => 'Add Poster'
  );
 
  // The arguments for our post type, to be entered as parameter 2 of register_post_type()
  $args = array(
    'labels'            => $labels,
    'description'       => 'Holds our movies and movie specific data',
    'public'            => true,
  );
 
  // Call the actual WordPress function
  // Parameter 1 is a name for the post type
  // Parameter 2 is the $args array
  register_post_type( 'movie', $args);
}
add_action( 'init', 'lc_custom_post_movie_reviews1' );
 
// The custom function to register a movie review post type
function lc_custom_post_movie_reviews1() {
 
  // Set the labels, this variable is used in the $args array
    $labels = array(
    'name'               => __( 'Голосування' ),
    'singular_name'      => __( 'Movie' ),
    'add_new'            => __( 'Додати голосування' ),
    'add_new_item'       => __( 'Додати голосування' ),
    'edit_item'          => __( 'Редагувати' ),
    'new_item'           => __( 'Нове голосування' ),
    'all_items'          => __( 'Всі голосування' ),
    'view_item'          => __( 'Показати голосування' ),
    'search_items'       => __( 'Пошук' ),
  );
 
  // The arguments for our post type, to be entered as parameter 2 of register_post_type()
  $args = array(
    'labels'            => $labels,
    'description'       => 'Holds our movie reviews',
    'public'            => true
  );
 
  // Call the actual WordPress function
  // Parameter 1 is a name for the post type
  // $args array goes in parameter 2.
  register_post_type( 'review', $args);
}



function my_custom_submenu_page_callback() {
    // контент страницы
    wp_safe_redirect( 'edit.php?post_type=movie' );

}
/*add_action('admin_menu', 'register_my_custom_submenu_page1');

function register_my_custom_submenu_page1() {
    add_submenu_page( 'edit.php?post_type=review', 'Дополнительная страница инструментов', 'Додаті модель', 'manage_options1', 'my-custom-submenu-page1', 'my_custom_submenu_page_callback1' ); 
}
*/
function my_custom_submenu_page_callback1() {
    // контент страницы
    wp_safe_redirect( 'post-new.php?post_type=movie' );

}
 
// Hook <strong>lc_custom_post_movie_reviews()</strong> to the init action hook
add_action( 'init', 'lc_custom_post_movie_reviews1' );
 
// The custom function to register a movie review post type

add_action('add_meta_boxes', 'my_extra_fields', 1);

function my_extra_fields() {
    add_meta_box( 'extra_fields', 'Дополнительные поля', 'extra_fields_box_func1', 'movie', 'normal', 'high'  );

}
add_action('add_meta_boxes', 'my_extra_fields1', 1);
function my_extra_fields1() {
    add_meta_box( 'extra_fields', 'Шорткоды', 'extra_fields_box_func_rew1', 'review', 'normal', 'high'  );

}

function extra_fields_box_func_rew1( $post ){
    $from = get_post_meta($post->ID, 'from', 1);
    $to = get_post_meta($post->ID, 'to', 1);



if($to == ''){
    $to ='2030-12-12';
}
if($from == ''){
    $from ='2019-01-01';
}
    
?>


Шорткод на головну<br />
<input type="text" value="[golos_girl girl=<?php echo $post->ID; ?> limit=4]" style="width:30%" /><br />

Шорткод для окремої сторінки<br />
<input type="text" value="[golos_girl girl=<?php echo $post->ID; ?>]" style="width:30%" /><br />
Голосування від<br />
<input name="extra[from]" type="date" value="<?php echo $from; ?>" style="width:30%" /><br />
Голосування до<br />
<input name="extra[to]" type="date" value="<?php echo $to; ?>" style="width:30%" /><br />
    <input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
	
<?php
}
?>
<?php
// код блока
function extra_fields_box_func1( $post ){
    if(function_exists( 'wp_enqueue_media' )){
    wp_enqueue_media();
}else{
    wp_enqueue_style('thickbox');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
}
    ?>
    

    Ім'я моделі(Українською)<br />
  <p><input type="text" name="extra[titleua]" value="<?php echo get_post_meta($post->ID, 'titleua', 1); ?>" style="width:30%" /><br />

    Ім'я моделі(Англійською)<br />
    <input type="text" name="extra[titlerus]" value="<?php echo get_post_meta($post->ID, 'titlerus', 1); ?>" style="width:30%" /> </label></p>


    <p><strong>Фото  конкурсантки:</strong><br />
                <img class="header_logo" src="<?php echo get_post_meta($post->ID, 'header_logo', 1); ?>" height="100" width="100"/>
                <input class="header_logo_url" type="text" name="extra[header_logo]" size="60" value="<?php echo get_post_meta($post->ID, 'header_logo', 1); ?>">
                <a href="#" class="header_logo_upload">Upload</a>

</p>
<br />
    Instagram<br />
<p><input type="text" name="extra[insta]" value="<?php echo get_post_meta($post->ID, 'insta', 1); ?>" style="width:30%" /><br />
    Facebook<br />
<p><input type="text" name="extra[face]" value="<?php echo get_post_meta($post->ID, 'face', 1); ?>" style="width:30%" /><br />
<p><strong>Голосів:</strong><br />
<?php
$golosiv = get_post_meta($post->ID, 'golos', 1);
if(!$golosiv){
$golosiv = 0;
}
?>
<p><input value="<?php echo $golosiv; ?>" style="width:5%" /></p><br />
<p><strong>Конкурс:</strong><br />
<?php
                $posts = get_posts( array(
    'post_type'   => 'review'
) );

		$check = get_post_meta($post->ID, 'taskOption', 1);
unset($post);
                echo '<select name="extra[taskOption]">';
                echo '<option value=""></option>';
                foreach( $posts as $post ){
                    setup_postdata($post);
			
				if($post->ID == $check){
					
					echo '<option value="'.$post->ID.'"selected>'.$post->post_title.'</option>';
				}else{
					echo '<option value="'.$post->ID.'">'.$post->post_title.'</option>';
				}
			
                    }

?>
</select></p>
<br />

    <input type="hidden" name="extra_fields_nonce" value="<?php echo wp_create_nonce(__FILE__); ?>" />
    <script>
    jQuery(document).ready(function($) {
        $('.header_logo_upload').click(function(e) {
            e.preventDefault();

            var custom_uploader = wp.media({
                title: 'Custom Image',
                button: {
                    text: 'Upload Image'
                },
                multiple: false  // Set this to true to allow multiple files to be selected
            })
            .on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                $('.header_logo').attr('src', attachment.url);
                $('.header_logo_url').val(attachment.url);

            })
            .open();
        });
    });
</script>

    <?php
}
add_action( 'save_post', 'my_extra_fields_update1', 0 );




function check_in_range($start_date, $end_date, $date_from_user) //функция проверки времени
{
  // Convert to timestamp
  $start_ts = strtotime($start_date);
  $end_ts = strtotime($end_date);
  $user_ts = strtotime($date_from_user);

  // Check that user date is between start & end
  return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
} //функция даты



## Сохраняем данные, при сохранении поста
function my_extra_fields_update1( $post_id ){
    // базовая проверка
    if (
           empty( $_POST['extra'] )
        || ! wp_verify_nonce( $_POST['extra_fields_nonce'], __FILE__ )
        || wp_is_post_autosave( $post_id )
        || wp_is_post_revision( $post_id )
    )
        return false;


     add_post_meta($post_id, 'girl', 0);
    // Все ОК! Теперь, нужно сохранить/удалить данные
    $_POST['extra'] = array_map( 'sanitize_text_field', $_POST['extra'] ); // чистим все данные от пробелов по краям
    foreach( $_POST['extra'] as $key => $value ){
        if( empty($value) ){
            delete_post_meta( $post_id, $key ); // удаляем поле если значение пустое
            continue;
        }
	
        update_post_meta( $post_id, $key, $value ); // add_post_meta() работает автоматически
    }

	$get = get_post_meta($post_id,'to');

		if(!$get){
			update_post_meta( $post_id, 'to', '2030-01-01' );
		}

	$get1 = get_post_meta($post_id,'from');

		if(!$get1){
			update_post_meta( $post_id, 'from', '2019-01-01' );
		}

		


    return $post_id;
}


//шаблон голосования
function template_golos_girl($id_post){
        $limit = $id_post['limit'];
        $id_post = $id_post['girl'];

global $wpdb;

if($limit){
$posts = $wpdb->get_results("SELECT * FROM $wpdb->postmeta
WHERE  meta_value = '$id_post' ORDER BY meta_value ASC limit 999", ARRAY_A);
$idpost = array();

foreach ($posts as $key => $value) {
   
        $idd = $value['post_id'];
        //print_r($value);
        $posts1 = $wpdb->get_results("SELECT post_status FROM `$wpdb->posts` WHERE `ID` ='$idd' LIMIT 1", ARRAY_A);
        if($posts1[0]['post_status'] != 'trash'){
            $idpost[]['post_id'] = $idd;
            $cou +=1;
        }
    
        
}

}else{
$posts = $wpdb->get_results("SELECT * FROM $wpdb->postmeta
WHERE  meta_value = '$id_post'", ARRAY_A);
$idpost = array();
foreach ($posts as $key => $value) {
        $idd = $value['post_id'];
        //print_r($value);
        $posts1 = $wpdb->get_results("SELECT post_status FROM `$wpdb->posts` WHERE `ID` ='$idd' LIMIT 1", ARRAY_A);
        if($posts1[0]['post_status'] != 'trash'){
            $idpost[]['post_id'] = $idd;
        }
        
}
}

$posts = $idpost;

$cur_user_id = get_current_user_id();

    $golos_pos = '_golos'.$id_post;

    $user_term = get_user_meta( $cur_user_id,$golos_pos, true );
//    $posts1 = $wpdb->get_results("SELECT * FROM `$wpdb->usermeta` WHERE `user_id` ='$cur_user_id' AND meta_key = '$golos_pos' LIMIT 1", ARRAY_A);
  //  print_r($posts1);
    $from = get_post_meta($id_post , 'from', true );

    $to = get_post_meta($id_post , 'to', true );

       $date_from_user = date('Y-m-d');

   $check_range = check_in_range( $from, $to,$date_from_user);

if ($check_range){ //проверяем просрочился ли голосование
  if($user_term){ //проверяем голосовал ли юзер?

            $p = array();
foreach ($posts as $key => $value) {
        $slug_post_id = $value['post_id'];
        $girl = 'golos';

        $textLable = get_post_meta( $slug_post_id, $girl, true );

        $p[$slug_post_id] = $textLable;
}

    arsort($p); //сортировка по порядку
    if($limit){
        $sorti = 1;
    $sp = array();
    foreach ($p as $key1 => $value1) {
        # code...
        
        if((int)$sorti <= (int)$limit){
            $sp[$key1] = $value1;
         //   echo $key1 .' '.$value1.'<br />';
           // echo $sorti .' '.$limit.'<br />';
             //       echo $sorti.' '.$limit.'<br />';
        }
        $sorti +=1;

    }

    $p = $sp;
}

    }else{
$from = get_post_meta($id_post , 'from', true );

    $to = get_post_meta($id_post , 'to', true );

    $date_from_user = date('Y-m-d');

   $check_range = check_in_range( $from, $to,$date_from_user);

if ($check_range){

$p = array();
foreach ($posts as $key => $value) {
        $slug_post_id = $value['post_id'];
        $girl = 'golos';

        $textLable = get_post_meta( $slug_post_id, $girl, true );
        if(!$textLable){
            $textLable = 0;
        }
        $p[$slug_post_id] = $textLable;
}
    $keys = array_keys($p);
    shuffle($keys);
 
    $result = []; $i = 0;
    foreach ($p as $item)
        $result[$keys[$i++]] = $item;
 
    $p = $result;

            if($limit){
        $sorti = 1;
    $sp = array();
    foreach ($p as $key1 => $value1) {
        # code...
        
        if((int)$sorti <= (int)$limit){
            $sp[$key1] = $value1;
         //   echo $key1 .' '.$value1.'<br />';
           // echo $sorti .' '.$limit.'<br />';
             //       echo $sorti.' '.$limit.'<br />';
        }
        $sorti +=1;

    }
    
    $p = $sp;
}
}else{
$p = array();
foreach ($posts as $key => $value) {
        $slug_post_id = $value['post_id'];
        $girl = 'golos';

        $textLable = get_post_meta( $slug_post_id, $girl, true );

        $p[$slug_post_id] = $textLable;
}
    arsort($p);

        if($limit){
        $sorti = 1;
    $sp = array();
    foreach ($p as $key1 => $value1) {
        # code...
        
        if((int)$sorti <= (int)$limit){
            $sp[$key1] = $value1;
         //   echo $key1 .' '.$value1.'<br />';
           // echo $sorti .' '.$limit.'<br />';
             //       echo $sorti.' '.$limit.'<br />';
        }
        $sorti +=1;

    }
    
    $p = $sp;
}
}
    }
}else{
            $p = array();
foreach ($posts as $key => $value) {
        $slug_post_id = $value['post_id'];
        $girl = 'golos';

        $textLable = get_post_meta( $slug_post_id, $girl, true );

        $p[$slug_post_id] = $textLable;
}
    arsort($p);

        if($limit){
        $sorti = 1;
    $sp = array();
    foreach ($p as $key1 => $value1) {
        # code...
        
        if((int)$sorti <= (int)$limit){
            $sp[$key1] = $value1;
         //   echo $key1 .' '.$value1.'<br />';
           // echo $sorti .' '.$limit.'<br />';
             //       echo $sorti.' '.$limit.'<br />';
        }
        $sorti +=1;

    }
    
    $p = $sp;
}

}
 //Сортировака для авторизированных и не авторизированных 








$top = 1;
    foreach ($p as $key => $value) {
        $slug_post_id = $key;

         if(get_locale() == "en_GB") {
            $girl1 = get_post_meta($slug_post_id, 'titlerus', 1);
        }else{
            $girl1 = get_post_meta($slug_post_id, 'titleua', 1);
        }

        $img = get_post_meta($slug_post_id, 'header_logo', 1);
            $insta = get_post_meta($slug_post_id, 'insta', 1);
            $face = get_post_meta($slug_post_id, 'face', 1);

                $from = get_post_meta($id_post , 'from', true );

if ( is_user_logged_in() ) {
//Проверка пользователя на авторизацию
       $cur_user_id = get_current_user_id();
        
                    $gol1 = '_golos'.$id_post;
                
                    $user_term1 = get_user_meta( $cur_user_id,$gol1, true );
            
                    if($user_term1){
                        $girl = 'golos';
            
                        //$textLable = get_post_meta( $slug_post_id, $girl, true );
                        $textLable = get_post_meta( $slug_post_id, $girl, true );
            if(!$textLable){
                            $textLable = '0';
                        }
                    }else{
                        $textLable = 'Голосувати';
                    }

$from = get_post_meta($id_post , 'from', true );
                    //Если пользователь проголосовал или не проголосовал
   $to = get_post_meta($id_post , 'to', true );

    $date_from_user = date('Y-m-d');

   $check_range = check_in_range( $from, $to,$date_from_user);

if ($check_range == 1){
                    
                     if($textLable != 'Голосувати'){
                        $class = 'voit_number';
                     }else{
                        $class = 'but_voit';
                     }
                     echo '
                <div class="col-lg-3 col-md-4 col-sm-6 block_voite">
                    <div class="block">
                        <div class="img">

                            <img src="'.$img.'" alt="">
                        </div>

                        <div id="golos'.$slug_post_id.'" class="'.$class.' d-flex justify-content-center align-items-center"><span>';
            if($textLable == 'Голосувати'){
                pll_e('Vote');
            }else{
                
                echo $textLable;

            }

echo '</span></div>
                        <div class="name">'.$girl1.'</div>
                        ';

if($user_term){
                        echo '<div class="place"> '.$top.' ';
 pll_e('Place');
echo ' </div>';
}
$top +=1;
               echo '         <div class="d-flex justify-content-center soc">
                            <a class="in" href="'.$insta.'"></a>
                            <a class="fb" href="'.$face.'"></a>
                        </div>
                    </div>
                </div>';
                                ?>
                <script type="text/javascript">
        jQuery(function($){ // есть разные варианты этой строчки, но такая мне нравится больше всего, т.к. всегда работает
    $('#golos<?php echo $slug_post_id ?>').click(function(){ // при клике на элемент с id="misha_button" 
 
        $.ajax({
            url: '<?php echo admin_url("admin-ajax.php") ?>',
            type: 'POST',
            data: 'action=misha&param1=<?php echo $slug_post_id; ?>&param2=<?php echo $id_post; ?>', // можно также передать в виде объекта
            success: function( data ) {
                var girl1 = JSON.parse(data);
                if(girl1){
                                    $('#golos<?php echo $slug_post_id ?>').text(girl1["girl<?php echo $slug_post_id ?>"]);
                }
                <?php
                if($limit){
                    ?>

                    window.location.replace("https://missprincessa.com/storinka-holosuvannia/");
                    <?php
                }else{
                    ?>
                    
                    location.reload();
                    <?php
                }
                ?>
            }
        });
    });
});

        </script>
        <?php
        
}else{ //если время закончилось у авторизованных юезров
    
        $girl = 'golos';
        $textLable = get_post_meta( $slug_post_id, $girl, true );

    if(!$textLable){
        $textLable = '0';
        
    }
    $class = 'voit_number';

                                echo '
                <div class="col-lg-3 col-md-4 col-sm-6 block_voite">
                    <div class="block">
                        <div class="img">

                            <img src="'.$img.'" alt="">
                        </div>

                        <div id="golos'.$slug_post_id.'" class="'.$class.' d-flex justify-content-center align-items-center"><span>';
            
                
                echo $textLable;
            

echo '</span></div>
                        <div class="name">'.$girl1.'</div>
                        ';

                        echo '<div class="place"> '.$top.' ';
 pll_e('Place');
echo ' </div>';

               echo '         <div class="d-flex justify-content-center soc">
                            <a class="in" href="'.$insta.'"></a>
                            <a class="fb" href="'.$face.'"></a>
                        </div>
                    </div>
                </div>';
$top += 1;

}
    }else{
$from = get_post_meta($id_post , 'from', true );
        //Если пользователь не авторизирован
           $to = get_post_meta($id_post , 'to', true );

    $date_from_user = date('Y-m-d');

  $check_range = check_in_range( $from, $to,$date_from_user);

if ($check_range){
	
                echo '
                <div class="col-lg-3 col-md-4 col-sm-6 block_voite">
                    <div class="block">
                        <div class="img">

                            <img src="'.$img.'" alt="">
                        </div>

                        <div id="golos'.$slug_post_id.'" data-toggle="modal" data-target="#exampleModal" class="but_voit d-flex justify-content-center align-items-center"><span> ';
                        pll_e('Vote');
                        echo ' </span></div>
                        <div class="name">'.$girl1.'</div>
                        <div class="d-flex justify-content-center soc">
                            <a class="in" href="'.$insta.'"></a>
                            <a class="fb" href="'.$face.'"></a>
                        </div>
                    </div>
                </div>';
        }else{
             
        $girl = 'golos';
        $textLable = get_post_meta( $slug_post_id, $girl, true );

    if(!$textLable){
        $textLable = '0';
        
    }
    $class = 'voit_number';

                                echo '
                <div class="col-lg-3 col-md-4 col-sm-6 block_voite">
                    <div class="block">
                        <div class="img">

                            <img src="'.$img.'" alt="">
                        </div>
                        <div id="golos'.$slug_post_id.'" class="'.$class.' d-flex justify-content-center align-items-center"><span>';
            
                
                echo $textLable;
            

echo '</span></div>
                        <div class="name">'.$girl1.'</div>
                        ';

                        echo '<div class="place"> '.$top.' ';
 pll_e('Place');
echo ' </div>';

               echo '         <div class="d-flex justify-content-center soc">
                            <a class="in" href="'.$insta.'"></a>
                            <a class="fb" href="'.$face.'"></a>
                        </div>
                    </div>
                </div>';
$top += 1;
        }


    }
    ?>


    <?php
}
}
add_shortcode('golos_girl', 'template_golos_girl');

add_action( 'wp_ajax_misha', 'test_function1' ); // wp_ajax_{ЗНАЧЕНИЕ ПАРАМЕТРА ACTION!!}
add_action( 'wp_ajax_nopriv_misha', 'test_function1' );  // wp_ajax_nopriv_{ЗНАЧЕНИЕ ACTION!!}
// первый хук для авторизованных, второй для не авторизованных пользователей
 
function test_function1(){
 
   // $summa = $_POST['param1'] + $_POST['param2'];
    $cur_user_id = get_current_user_id();

    $golos_pos = '_golos'.$_POST['param2'];
    
    $user_term = get_user_meta( $cur_user_id,$golos_pos, true );

	$from = get_post_meta( $_POST['param2'], 'from', true );

	$to = get_post_meta( $_POST['param2'], 'to', true );

        $date_from_user = date('Y-m-d');

   $check_range = check_in_range( $from, $to,$date_from_user);

if ($check_range){

        if($user_term  != 1 or !$user_term){
            add_user_meta( $cur_user_id,$golos_pos, 1, true );

                $girl = 'golos';

                    $get_value = get_post_meta( $_POST['param1'], $girl, true );

                            $g_val = $get_value+1;

                                update_post_meta( $_POST['param1'], $girl, $g_val );

                                $get_value1 = get_post_meta( $_POST['param1'], $girl, true );


                                
                                $g = 'girl'.$_POST["param1"];
                                $array = array($g => $get_value1);

                                echo json_encode($array);

        }
}else{
    return;
}
    die; // даём понять, что обработчик закончил выполнение
}
add_action( 'init', function() {
    remove_post_type_support( 'movie', 'editor' );
}, 99);
add_action( 'init', function() {
    remove_post_type_support( 'review', 'editor' );
}, 99);
add_filter( 'manage_'.'movie'.'_posts_columns', 'add_views_column', 4 );
function add_views_column( $columns ){
	$num = 2; // после какой по счету колонки вставлять новые

	$new_columns = array(
		'views' => 'Конкурс',
	);

	return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
}

// заполняем колонку данными
// wp-admin/includes/class-wp-posts-list-table.php
add_action('manage_'.'movie'.'_posts_custom_column', 'fill_views_column1', 5, 4 );
function fill_views_column1( $colname, $post_id ){
	if( $colname === 'golos' ){
		$golos = get_post_meta( $post_id, 'golos', 1 );
		echo $golos;
	}
}

function add_views_column1( $columns ){
    $num = 2; // после какой по счету колонки вставлять новые

    $new_columns = array(
        'golos' => 'Голоси',
    );

    return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
}

// заполняем колонку данными
// wp-admin/includes/class-wp-posts-list-table.php
add_action('manage_'.'movie'.'_posts_custom_column', 'fill_views_column', 5, 2 );

function fill_views_column( $colname, $post_id ){
    if( $colname === 'views' ){
        $parent_id = get_post_meta( $post_id, 'taskOption', 1 );
        if($parent_id){
            echo get_the_title( $parent_id );
        }
    }
}

add_action( 'restrict_manage_posts', 'add_event_table_filters');
function add_event_table_filters( $post_type ){

global $wpdb;
$posts1 = $wpdb->get_results("SELECT * FROM $wpdb->posts
WHERE  post_type = 'review'", ARRAY_A);

                echo '<select name="sel_season">';
                echo '<option value="">- Конкурси -</option>';
                foreach( $posts1 as $post ){
			         echo '<option value="'.$post['ID'].'">'.$post['post_title'].'</option>';
                    }
	// для динамического построения селекта, можно использовать wp_dropdown_categories()
}

// Фильтрация: обработка запроса
add_action( 'pre_get_posts', 'add_event_table_filters_handler1' );
function add_event_table_filters_handler1( $query ) {
	if( ! is_admin() ) return; // выходим если не админка

	// убедимся что мы на нужной странице админки
	/*$cs = get_current_screen();
	if( empty($cs->post_type) || $cs->post_type != 'movie' || $cs->id != 'edit-movie' ) return;*/

	// сезон

	if( $_GET['sel_season']){
        echo $_GET['sel_season'];
		$selected_id = $_GET['sel_season'];
		$query->set( 'meta_query', array(
                                   array(
                                         'key' => 'taskOption',
                                         'value' => $selected_id,
					 'compare' => '=',
                                        )
                                   )
                              );

		
	} 

}
// [footag girl=1234]
