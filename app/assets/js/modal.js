 var modal = document.getElementById("modal");
 var btn = document.getElementById("btn_modal_window");
 var span = document.getElementsByClassName("close_modal_window")[0];

 btn.onclick = function () {
    modal.style.display = "block";
 }

 span.onclick = function () {
    modal.style.display = "none";
 }

 window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

/**
 * Вывод данных в модальное окно
 *
 */
 function getData(id) {
 	var tr = document.getElementById(id);
 	var hid = tr.attributes[2].nodeValue;
 	var name = tr.childNodes[1].textContent;
 	var address = tr.childNodes[2].textContent;
 	var phone = tr.childNodes[3].textContent;

 	modal.style.display = "block";

 	var inputId = document.getElementById('input-id');
 	inputId.setAttribute('value', id);

 	var inputHid = document.getElementById('input-hid');
 	var optionHid = document.getElementById('option-' + hid);

 	if (optionHid !== null) {
 		optionHid.setAttribute('selected', '');
 		inputHid.setAttribute('value', hid);
 	} else if (optionHid == null) {
 		var options = document.querySelectorAll('option');

 		options.forEach(function(item, i, options) {
 			item.removeAttribute('selected');
 		})
 		
 		optionHid = document.getElementById('option-0');
 		optionHid.setAttribute('selected', '');
 		inputHid.setAttribute('value', '');
 	}

 	var inputName = document.getElementById('input-name');
 	inputName.setAttribute('value', name);

 	var inputAddress = document.getElementById('input-address');
 	inputAddress.setAttribute('value', address);

 	var inputPhone = document.getElementById('input-phone');
 	inputPhone.setAttribute('value', phone);
 }