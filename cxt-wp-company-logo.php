<?php
/*
Plugin Name:    Context Company Term Logo & Favicon Organiser
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

// Settings (Company favicons)
$icons_acf_field_key    = 'field_6140aa849827e';    // key of ACF image field storing Company favicons
$icons_folder           = '/companies/favicons';    // wp-content/companies/{sub-folder}


/**
 * ==============================================================================
 *              FILTER COMPANY LOGO UPLOADS TO SPECIFIC FOLDER
 *  cf. https://support.advancedcustomfields.com/forums/topic/change-file-upload-path-for-one-specific-field/
 * ==============================================================================
 */

add_filter('acf/upload_prefilter/key=' . $logos_acf_field_key, 'prefilter_logo_upload');
function prefilter_logo_upload($errors)
{
  // in this filter we add a WP filter that alters the upload path
  add_filter('upload_dir', 'modify_logo_upload_dir');
  return $errors;
}

// second filter
function modify_logo_upload_dir($uploads_logos)
{
  // here is where we later the path
  $uploads_logos['path'] = $uploads_logos['basedir'] . $logos_folder;
  $uploads_logos['url'] = $uploads_logos['baseurl'] . $logos_folder;
  // $uploads_logos['subdir'] = 'logos';
  return $uploads_logos;
}



/**
 * ==============================================================================
 *              FILTER COMPANY FAVICON UPLOADS TO SPECIFIC FOLDER
 *  cf. https://support.advancedcustomfields.com/forums/topic/change-file-upload-path-for-one-specific-field/
 * ==============================================================================
 */

add_filter('acf/upload_prefilter/key=' . $icons_acf_field_key, 'prefilter_favicon_upload');
function prefilter_favicon_upload($errors)
{
  // in this filter we add a WP filter that alters the upload path
  add_filter('upload_dir', 'modify_favicon_upload_dir');
  return $errors;
}

// second filter
function modify_favicon_upload_dir($uploads_favicons)
{
  // here is where we later the path
  $uploads_favicons['path'] = $uploads_favicons['basedir'] . $icons_folder;
  $uploads_favicons['url'] = $uploads_favicons['baseurl'] . $icons_folder;
  // $uploads_favicons['subdir'] = 'favicons';
  return $uploads_favicons;
}


?>