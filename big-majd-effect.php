<?php
/**
 * @package BigBangPlugin
*/

/**
  
 * 
 * Plugin name: BiG Bang Login Page Particle Effect
 * Description: this plugin is developed to add a particle effect to the wordpress login page by Majd eldeen Naje
 * Author:            Big Bang Information Technology Solutions
 * Author URI:        https://its.ae/
 * Version: 1.0
*/

/**
 * This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <https://www.gnu.org/licenses/>.
*/
if(! defined('ABSPATH')){
    die;
}



class bble_BigBangLoginEffect  {
    public function __construct() {
        
    }
    function bble_activate(){
        if(!get_option('bble_settings'))
        {
            $bble_defaults=array(
                'bble_login_logo_url'=>'https://www.its.ae/',
                'bble_logo_image_id'=>null
                );
            add_option('bble_settings',$bble_defaults,'','no');
        }
            
        
      
    } 
    function bble_deactivate()
    {
       // echo 'Plugin deactivated';
    }
    function bble_uninstall()
    {
       if(get_option('bble_settings'))
       delete_option( 'bble_settings' );
    }
    function bble_add_scripts_to_login_page()
    {
      
       wp_enqueue_script( 'bble', plugin_dir_url(__FILE__).'/particles/particles.min.js', array('jquery'), '1.0.0', false );
       wp_enqueue_script( 'bble_activate', plugin_dir_url(__FILE__).'activation_snippet.js', array('jquery'), '1.0.0', true );
    }
    function bble_add_load()
    {
       echo '<script type="text/javascript">
       jQuery(document).ready(function($){
        $("body").attr("id", "effect");
        particlesJS.load("effect","'.plugin_dir_url(__FILE__).'particle-cfg.json");
       })
       </script>';
       wp_enqueue_style( 'login-style-bigeffect', plugin_dir_url(__FILE__).'style.css', array() );
    }
    function bble_register_options_page() {
        add_options_page('BIGBANG tools Settings', 'BIGBANG', 'manage_options', 'bble_options', 'bble_options_page');
    }
   
    
}
if(class_exists('bble_BigBangLoginEffect')){
    $bble_logineffect=new bble_BigBangLoginEffect();
}

//activation
register_activation_hook( __FILE__, array($bble_logineffect,'bble_activate') );
//deactivation
register_deactivation_hook( __FILE__, array($bble_logineffect,'bble_deactivate') );
//uninstall
register_uninstall_hook(  __FILE__, array($bble_logineffect,'bble_uninstall') );

//enqueue script action
add_action( 'login_enqueue_scripts', array($bble_logineffect,'bble_add_scripts_to_login_page') );
// force add load script
add_action( 'login_footer', array($bble_logineffect,'bble_add_load') );

add_action('admin_menu', array($bble_logineffect,'bble_register_options_page'));

 function bble_options_page(){
        ?>
               <div>
  <h2>BIGBANG Tools Options</h2>
  <form method="post" action="options.php">
  <?php
  settings_fields('myplug_options_group');
  $bble_options = get_option('bble_settings');
  ?>
  
   
  
 
  <table class="form-table" role="presentation">

<tr>
<th scope="row"><label for="blogname">Site Title</label></th>
<td><input name="blogname" type="text" id="blogname" value="BigBang" class="regular-text" /></td>
</tr>

<tr>
<th scope="row">
    
    <label for="bble_login_logo_url">Login Logo Link:</label>
    </th>
<td>
    <input name="bble_login_logo_url" type="url" id="logo-link" aria-describedby="tagline-description" value="<? echo $bble_options['bble_login_logo_url']?>" class="regular-text" />
<p class="description" id="tagline-description">the url for the logo displayed in the login page.</p></td>
</tr>
</table>
  <?php submit_button(); ?>
  </form>
</div>
        <?
    }
