<?php

/*
Plugin Name: Cookies Alert
Description: _e('Alerte pour prévenir les utilisateurs de l'utilisation de cookies sur le site')
Version: 1.0
Author: David Korhonen
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

//

add_action( 'admin_print_scripts', 'load_admin_scripts');
function load_admin_scripts($hook) 
{
	wp_enqueue_style('wp-color-picker');
	wp_register_script('color-script', plugins_url('js/acookies.js', __FILE__), array('wp-color-picker'), false, true );
	wp_enqueue_script('color-script');
}

//

add_action('admin_menu', 'acookies_options_page');
function acookies_options_page()
{
	add_options_page('Cookies Alert', 'Cookies Alert', 'manage_options', "cookies_alert", 'acookies_options');
}

//

add_action('admin_init', 'register_mysettings');
function register_mysettings() 
{ 
	register_setting( 'myoption-group', 'acookies_bcolor' );
	register_setting( 'myoption-group', 'acookies_color' );
	register_setting( 'myoption-group', 'acookies_message' );
} 

function acookies_options()
{
	?>
	<div class="wrap">
		<h2>Cookies Alert _e('options')</h2>
		<p>_e('You can create here your custom alert').</p>
		<form  method="post" action="options.php" >
			<?php settings_fields( 'myoption-group' ); ?>
			<?php do_settings_sections( 'myoption-group' ); ?>

	 <table class="form-table">
        <tr>
	        <th>_e('Background color')</th>
	        <td><input type="text" class='color-field' name="acookies_bcolor" value="<?php echo get_option('acookies_bcolor'); ?>" /></td>
    	</tr>
        <tr>
	        <th>_e('Text color')</th>
	        <td><input type="text" class='color-field' name="acookies_color" value="<?php echo get_option('acookies_color'); ?>" /></td>
    	</tr>
        <tr>
	        <th>_e('Message')</th>
	        <td><textarea type="text" name="acookies_message" rows="10" cols="100" ><?php echo get_option('acookies_message'); ?></textarea></td>
        </tr>
    </table>
				<?php 
					submit_button();
				?>
		</form>
	</div>

	<?php

}

//

add_filter('init', 'acookies_show');
function acookies_show()
{
	echo '<div id="acookies_id" style="background-color: '.get_option('acookies_bcolor').'; color: '.get_option('acookies_color').'">'.get_option('acookies_message').'<img src="'.plugins_url('images/bouton.png', __FILE__).'" id="acookies_id_img" /></div>';
}
add_action( 'init', 'acookies_style' );
function acookies_style() 
{
	wp_register_style( 'acookies_add_style', plugins_url('css/acookies.css',__FILE__ ));
	wp_enqueue_style('acookies_add_style');
	wp_register_script('bouton_script', plugins_url('js/bouton.js', __FILE__));
	wp_enqueue_script('bouton_script');
}

