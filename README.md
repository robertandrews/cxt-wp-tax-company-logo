# Context WP Company Term ACF Logo & Favicon Organiser

Tested up to: 5.9.1  
Tags: wordpress, acf, image  
Contributors: robertandrews  

## Description

For those with:

* "company" custom taxonomy  .
* ACF Image fields on "company" term-edit pages, for company  and favicon.

On upload to the field, logo and favicon images will be:

* renamed to match the company term slug (eg. logo uploaded to term Microsoft will become `microsoft.png`).
* housed in a dedicated sub-folder you specficy, for better organisation.

## Setup

### Prerequisite ACF setup

You must already have an Advanced Custom Fields group added to your Company custom taxonomy edit page ("Show this field group if" "Taxonomy" "is equal to" "Company).

The field group must contain two Image fields:

* Logo
* Favicon

The new image uploaders will appear on your Company taxonomy-term edit pages in the Dashboard (Edit Company).

### Image organisation

Beneath `/wp-content/uploads`, create a new sub-directory to house your logo files (eg. "`/companies/logos`" for "`/wp-content/uploads/companies/logos`").

Similarly, create a new sub-directory to house your favicon files (eg. "`/companies/favicons`" for "`/wp-content/uploads/companies/favicons`").

## Settings

You must then edit the plugin to add four variables:

```PHP
// Settings (Company logos)
$logos_acf_field_key    = 'field_6140aa779827d';    // key of ACF image field storing Company logos
$logos_folder           = '/companies/logos';       // wp-content/companies/{sub-folder}
```

* `$logos_acf_field_key`: the database key corresponding to this field. Find this most easily by using Hookturn's ACF add-on Theme Code Pro, or else by inspecting page source on the Image button.
* `$logos_folder`: path to sub-folder of `/wp-contents/companies` (eg. `/companies/logos`). Include leading slash but not trailing slash. (Reminder: you must already have created this folder).

```PHP
// Settings (Company favicons)
$icons_acf_field_key    = 'field_6140aa849827e';    // key of ACF image field storing Company favicons
$icons_folder           = '/companies/favicons';    // wp-content/companies/{sub-folder}

```

* `$icons_acf_field_key`: the database key corresponding to this field. Find this most easily by using Hookturn's ACF add-on Theme Code Pro, or else by inspecting page source on the Image button.
* `$icons_folder`: path to sub-folder of `/wp-contents/compiconsanies` (eg. `/companies/icons`). Include leading slash but not trailing slash. (Reminder: you must already have created this folder).

## Acknowledgements

This plugin ostensibly packages up [code contributed](https://support.advancedcustomfields.com/forums/topic/change-file-upload-path-for-one-specific-field/) by John Huebner to ACF's support forum.

## Notes

This plugin stores no database information directly.

The ACF Image field, of course, both uploads an image and sets a database binding between the image object and a Company term.
