<?php
/*
Plugin Name:    Context Company Term Logo Organiser
Description:    Auto-rename organise Company term logo (ACF Image) to match term slug.
Text-Domain:    cxt-tax-company-logo
Version:        1.1
Author:         Robert Andrews
Author URI:     http://www.robertandrews.co.uk
License:        GPL v2 or later
License URI:    https://www.gnu.org/licenses/gpl-2.0.html
*/

// Settings (Company logos)
$logos_acf_field_key    = 'field_6140aa779827d';    // key of ACF image field storing Company logos
$logos_folder           = '/companies/logos';       // wp-content/companies/{sub-folder}


/**
 * ==============================================================================
 *              FILTER COMPANY LOGO UPLOADS TO SPECIFIC FOLDER
 *  cf. https://support.advancedcustomfields.com/forums/topic/change-file-upload-path-for-one-specific-field/
 * ==============================================================================
 */

 // Pre-filter the upload of company Image field "Logo"
add_filter('acf/upload_prefilter/key=' . $logos_acf_field_key, 'prefilter_logo_upload');
function prefilter_logo_upload($errors)
{
  // TODO:
  // Add filter to call rename function...
  // in this filter we add a WP filter that alters the upload path
  add_filter('upload_dir', 'modify_logo_upload_dir');
  return $errors;
}

// Second filter
function modify_logo_upload_dir($uploads_logos)
{
  // here is where we later the path
  global $logos_folder;
  $uploads_logos['path'] = $uploads_logos['basedir'] . $logos_folder;
  $uploads_logos['url'] = $uploads_logos['baseurl'] . $logos_folder;
  // $uploads_logos['subdir'] = 'logos';
  return $uploads_logos;
}





/* In equivalent cxt-user-avatar.php, there is other stuff here */

























/**
 * ==============================================================================
 *             RENAME UPLOADED IMAGE FILE WITH TERM SLUG
 *    When an image is uploaded to Edit Term form through an ACF field,
 *    rename file with the slug of said term.
 * ==============================================================================
 */

// 1. PASS TERM ID FROM TERM.PHP TO MEDIA UPLOADER, TO GET TERM SLUG
// cf. https://support.advancedcustomfields.com/forums/topic/force-an-image-file-upload-to-a-particular-directory/
// cf. https://wordpress.stackexchange.com/questions/395730/how-to-get-id-of-edit-user-page-during-wp-handle-upload-prefilter-whilst-in-med/395764?noredirect=1#comment577035_395764
add_filter('plupload_default_params', function ($params) {
  if (!function_exists('get_current_screen')) {
      return $params;
  }
  $current_screen = get_current_screen();
  if ($current_screen->id == 'user-edit') {
      $params['tag_ID'] = $_GET['tag_ID'];
      $params['taxonomy'] = $_GET['taxonomy'];
  }

  return $params;
});

 // 2. ON UPLOAD, DO THE RENAME
// Filter, cf. https://wordpress.stackexchange.com/questions/168790/how-to-get-profile-user-id-when-uploading-image-via-media-uploader-on-profile-pa
// p1: filter, p2: function to execute, p3: priority eg 10, p4: number of arguments eg 2
add_filter('wp_handle_upload_prefilter', 'company_logo_rename');
function company_logo_rename($file)
{

    global $acf_field_key;
    
    // Working with $POST contents of AJAX Media uploader
    $thetagid = $_POST['tag_ID'];         // Passed from term.php via plupload_default_params function
    $acffield  = $_POST['_acfuploader'];    // ACF field key, inherent in $_POST
    // If tag_ID was present AND ACF field is for logo Image
    if (($thetagid) && ($acffield == $acf_field_key)) {
        // Get ID's slug and rename file accordingly, cf. https://stackoverflow.com/a/3261107/1375163
        $term = get_term( $params['tag_ID'], $params['taxonomy'] );
        $info = pathinfo($file['name']);
        $ext  = empty($info['extension']) ? '' : '.' . $info['extension'];
        $name = basename($file['name'], $ext);
        $file['name'] = $term->slug . $ext;

        //
        add_action('add_attachment', 'my_set_image_meta_upon_image_upload');

        // Carry on
        return $file;
        // Else, just use original filename
    } else {
        return $file;
    }
}
?>