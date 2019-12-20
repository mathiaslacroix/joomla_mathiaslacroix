/**
* PLEASE DO NOT MODIFY THIS FILE. WORK ON THE ES6 VERSION.
* OTHERWISE YOUR CHANGES WILL BE REPLACED ON THE NEXT BUILD.
**/

/**
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// Helper function for IE11
function getClosest(el, tag) {
  // this is necessary since nodeName is always in upper case
  const elementTag = tag.toUpperCase();
  let element = el;

  do {
    if (element.nodeName === elementTag) {
      // tag name is found! return
      return element;
    }

    element = element.parentNode;
  } while (element != null); // Not found


  return null;
}
/**
 * JavaScript behavior to allow shift select in administrator grids
 */


(Joomla => {
  'use strict';

  class JMultiSelect {
    constructor(formElement) {
      this.tableEl = document.querySelector(formElement);

      if (this.tableEl) {
        this.boxes = [].slice.call(this.tableEl.querySelectorAll('input[type=checkbox]'));
        this.rows = [].slice.call(document.querySelectorAll('tr[class^="row"]'));
        this.checkallToggle = document.querySelector('[name="checkall-toggle"]');
        this.onCheckallToggleClick = this.onCheckallToggleClick.bind(this);
        this.onRowClick = this.onRowClick.bind(this);

        if (this.checkallToggle) {
          this.checkallToggle.addEventListener('click', this.onCheckallToggleClick);
        }

        if (this.rows.length) {
          this.rows.forEach(row => {
            row.addEventListener('click', this.onRowClick);
          });
        }
      }
    } // Changes the background-color on every cell inside a <tr>
    // eslint-disable-next-line class-methods-use-this


    changeBg(row, isChecked) {
      // Check if it should add or remove the background colour
      if (isChecked) {
        [].slice.call(row.querySelectorAll('td, th')).forEach(elementToMark => {
          elementToMark.classList.add('row-selected');
        });
      } else {
        [].slice.call(row.querySelectorAll('td, th')).forEach(elementToMark => {
          elementToMark.classList.remove('row-selected');
        });
      }
    }

    onCheckallToggleClick(event) {
      const isChecked = event.target.checked;
      this.rows.forEach(row => {
        this.changeBg(row, isChecked);
      });
    }

    onRowClick(event) {
      // Do not interfere with links or buttons
      if (event.target.tagName && (event.target.tagName.toLowerCase() === 'a' || event.target.tagName.toLowerCase() === 'button')) {
        return;
      }

      if (!this.boxes.length) {
        return;
      }

      const currentRowNum = this.rows.indexOf(navigator.userAgent.indexOf('MSIE ') > -1 || navigator.userAgent.indexOf('Trident/') > -1 ? getClosest(event.target, 'tr') : event.target.closest('tr'));
      const currentCheckBox = this.checkallToggle ? currentRowNum + 1 : currentRowNum;
      let isChecked = this.boxes[currentCheckBox].checked;

      if (currentCheckBox >= 0) {
        if (!(event.target.id === this.boxes[currentCheckBox].id)) {
          // We will prevent selecting text to prevent artifacts
          if (event.shiftKey) {
            document.body.style['-webkit-user-select'] = 'none';
            document.body.style['-moz-user-select'] = 'none';
            document.body.style['-ms-user-select'] = 'none';
            document.body.style['user-select'] = 'none';
          }

          this.boxes[currentCheckBox].checked = !this.boxes[currentCheckBox].checked;
          isChecked = this.boxes[currentCheckBox].checked;
          Joomla.isChecked(this.boxes[currentCheckBox].checked, this.tableEl.id);
        }

        this.changeBg(this.rows[currentCheckBox - 1], isChecked); // Restore normality

        if (event.shiftKey) {
          document.body.style['-webkit-user-select'] = 'none';
          document.body.style['-moz-user-select'] = 'none';
          document.body.style['-ms-user-select'] = 'none';
          document.body.style['user-select'] = 'none';
        }
      }
    }

  }

  const onBoot = () => {
    if (!Joomla) {
      // eslint-disable-next-line no-new
      new JMultiSelect('#adminForm');
    } else if (Joomla.getOptions && typeof Joomla.getOptions === 'function' && Joomla.getOptions('js-multiselect')) {
      if (Joomla.getOptions('js-multiselect').formName) {
        // eslint-disable-next-line no-new
        new JMultiSelect("#".concat(Joomla.getOptions('js-multiselect').formName));
      } else {
        // eslint-disable-next-line no-new
        new JMultiSelect('#adminForm');
      }
    }
  };

  document.addEventListener('DOMContentLoaded', onBoot);
})(Joomla);