if (typeof checkLevelAll === 'undefined') {
	/**
	 * checkLevelAll
	 *
	 * @param   {boolean}   checked
	 *
	 * @return  {void}
	 */
	function checkLevelAll (checked) {
		'use strict';

		let obj_checkbox = document.getElementsByName('smsLevel[]');

		for (let i = 0; i < obj_checkbox.length; i++) {
			obj_checkbox[i].checked = checked;
		}
	}
}

if (typeof setSmsByte === 'undefined') {
	/**
	 * setSmsByte
	 *
	 * @param   {string}    text
	 * @param   {object}    obj
	 *
	 * @return  {void}
	 */
	function setSmsByte (text, obj) {
		obj.innerText = getSmsByte(text) + ' Byte';
	}
}

if (typeof getSmsByte === 'undefined') {
	/**
	 * getSmsByte
	 *
	 * @param   {string}    text
	 *
	 * @return  {number}    length
	 */
	function getSmsByte (text) {
		let length = 0;
		let intTextLength = text.length;

		for (let i = 0; i < intTextLength; i++) {
			if (text.charCodeAt(i) > 128) {
				// 한글
				length += 2;
			} else {
				length++;
			}
		}

		return length;
	}
}