<?php 
/**
 * Plugin Name: WP Hide
 * Description: Hides page elements
 * Author: André Keher
 * Author URI: https://github.com/andrekeher
 **/

class WPHide
{
    public function __construct()
    {
        add_action('admin_menu', array($this, 'menu'));
        add_action('wp_head', array($this, 'execute'));
    }
    
    public function menu()
    {
        add_menu_page('Hide elements', 'Hide elements', 'manage_options', 'hide_elements', array($this, 'page'));
    }
    
    public function page()
    {
        if (isset($_POST['hide_elements']) && !empty($_POST['hide_elements'])) {
            extract($_POST);
            update_option('hide_elements', strip_tags($hide_elements));
        }
        $hideElements = get_option('hide_elements');
        ?>
        <h1>Hide elements</h1>
        <form method="post">
            <textarea class="widefat" name="hide_elements"><?php echo $hideElements; ?></textarea>
            <i>Informe um elemento por linha.</i>
            <?php submit_button(); ?>
        </form>
        <?php
    }
    
    public function execute()
    {
        $hideElements = get_option('hide_elements');
        $hideElements = str_replace(PHP_EOL, ', ', $hideElements);
        if (!empty($hideElements)) {
            ?>
            <style type="text/css">
            <?php echo $hideElements; ?> {
                visibility: hidden;
            }
            </style>
            <?php
        }
    }
}
new WPHide();
