/**
* PLEASE DO NOT MODIFY THIS FILE. WORK ON THE ES6 VERSION.
* OTHERWISE YOUR CHANGES WILL BE REPLACED ON THE NEXT BUILD.
**/

/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
document.addEventListener('DOMContentLoaded', () => {
  document.getElementById('jform_image').addEventListener('change', event => {
    const flagSelectedValue = event.currentTarget.value;
    const flagimage = document.getElementById('flag').querySelector('img');
    const src = "".concat(Joomla.getOptions('system.paths').rootFull, "/media/mod_languages/images/").concat(flagSelectedValue, ".gif");

    if (flagSelectedValue) {
      flagimage.setAttribute('src', src);
      flagimage.setAttribute('alt', flagSelectedValue);
    } else {
      flagimage.removeAttribute('src');
      flagimage.setAttribute('alt', '');
    }
  }, false);
});