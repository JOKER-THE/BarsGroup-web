
/**
 * Отображаем первичные родительские классы
 *
 */
var parents = document.getElementsByName('elem');
parents.forEach(element => element.removeAttribute('hidden'));

/**
 * Получаем все элементы
 *
 */
var element = document.querySelectorAll('[name^=elem]');
element.forEach(function(item, i, element) {
	var id = item.id;

	/**
	 * Проверяем, есть ли у родительского элемента дочерние
	 *
	 */
	var hid = document.querySelectorAll('[hid^="' + id + '"]');

	/**
	 * Если их нет, нам необходимо скрыть кнопки "развернуть"
	 *
	 */
	if (hid.length === 0) {
		var buttons = document.getElementsByName('button' + id);
		buttons.forEach(button => button.setAttribute('hidden', ''));
	}
})

/**
 * Переключатель видимости дочерних элементов
 *
 */
function getChild(id) {
	var buttons = document.querySelectorAll('span[data-id="' + id + '"]');
	var array = Array.prototype.slice.call(buttons);

	if (array[0].lastChild.nodeValue === '+') {
		array[0].lastChild.nodeValue = '-';
	} else {
		array[0].lastChild.nodeValue = '+';
	}

	var child = document.getElementsByName('elem' + id);
	child.forEach(function(item, i, child) {
		var attr = item.hasAttribute('hidden');
  		if (attr === true) {
  			item.removeAttribute('hidden');
  		} else {
  			closeChild(item.id);
  			item.setAttribute('hidden', '');
  		}
	})
}

/**
 * Рекурсивная функция, которая отключает все дочерние
 * элементы при закрытии одного из родителей
 *
 */
function closeChild(id) {
	var buttons = document.querySelectorAll('span[data-id="' + id + '"]');
	var array = Array.prototype.slice.call(buttons);

	array.forEach(function(elem, i, array) {
		elem.lastChild.nodeValue = '+';
	})

	var list = document.querySelectorAll('[hid="' + id + '"]');
	list.forEach(function(item, i, list){
		item.setAttribute('hidden', '');
		var hid = item.id;
		closeChild(hid);
	})
}

/**
 * Рекурсивная функция, которая открывает все
 * элементы
 *
 */
function openChild(id) {
	var buttons = document.querySelectorAll('span[data-id="' + id + '"]');
	var array = Array.prototype.slice.call(buttons);

	array.forEach(function(elem, i, array) {
		elem.lastChild.nodeValue = '-';
	})

	var list = document.querySelectorAll('[hid="' + id + '"]');
	list.forEach(function(item, i, list){
		item.removeAttribute('hidden');
		var hid = item.id;
		openChild(hid);
	})
}

/**
 * Развернуть/свернуть все элементы
 *
 */
function changeAll() {
	var element = document.querySelectorAll('[name^=elem]');
	var id = element[0].id;
	var status = element[0].firstChild.firstChild.firstChild.firstChild.data;		
	if (status === '+') {
		element.forEach(function(item, i, element) {
			openChild(item.id);
		})
	} else {
		element.forEach(function(item, i, element) {
			closeChild(item.id);
		})
	}
}