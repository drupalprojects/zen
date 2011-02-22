ZEN'S STYLESHEETS
-----------------

In these stylesheets, we have included all of the classes and IDs from this
theme's tpl.php files. We have also included many of the useful Drupal core
styles to make it easier for theme developers to see them.

Many of these styles are over-riding Drupal's core stylesheets, so if you remove
a declaration from them, the styles may still not be what you want since
Drupal's core stylesheets are still styling the element. See the
drupal6-reference.css file for a list of all Drupal 6.x core styles.

In addition to the style declarations in these stylesheets, other Drupal styles
that you might want to override or augment are those for:

  Book Navigation  See line 74  of drupal6-reference.css file
  Forum            See line 197 of drupal6-reference.css file
  Menus            See line 667 of drupal6-reference.css file
  News Aggregator  See line 20  of drupal6-reference.css file
  Polls            See line 287 of drupal6-reference.css file
  Search           See line 320 of drupal6-reference.css file
  User Profiles    See line 945 of drupal6-reference.css file


INTERNET EXLORER HATES YOU
--------------------------

All versions of IE limit you to 31 stylesheets total. What that means is that
only the first 31 stylesheets will load, ignoring the others. So you'll have
missing styles in IE7 and later and a broken layout in IE6.

This is a known bug in IE: http://support.microsoft.com/kb/262161

Please read http://john.albin.net/css/ie-stylesheets-not-loading for the gory
details.
