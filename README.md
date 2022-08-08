INTRODUCTION
------------
With the help of this module we can add below field to generate country, state
and district drop-down in our content type.
This module have latest data like ... We have 247 country, 4,851
States/Regions and 1,15,547 district.

BENEFITS
--------
This module add 3 below field type :
 1) country state district type
    When user added this field type in any content type then while adding or
    editing choose the country, the state field is showed, than, when user
    select the state, the district field is showed.

 2) country state type
    When user added this field type in any content type then while adding or
    editing choose the country, the state field is showed.

 3) country only
  User can add this filed if they want only country drop-down.


REQUIREMENTS
------------
Drupal 8.x

INSTALLATION
------------

Install the Country state and district module:
  Using DRUSH: drush en cntry_ste_dst_la_lb_wrd
  -or-
  Download it from https://www.drupal.org/project/cntry_ste_dst_la_lb_wrd and i
  nstall it to your website.

CONFIGURATION
-------------
  a) Go to admin/structure. Here you two option one is Country state district
     interface and other is Import country state and district data.
  b) Now first go to the admin/config/country-state-field this link and import
     data as:
      1) First import country data
      2) Then after import state data
      3) Finally import district data
     Note: For importing district data, we have to wait sometime because we have
     more than 1 lack data for district so it takes time to import all.
  c) After importing all the data, now to the manage field section of any
     content type in which you want to add above field.
