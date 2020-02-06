
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
	var child = document.getElementsByName('elem' + id);
	child.forEach(function(item, i, child) {
		var attr = item.hasAttribute('hidden');
  		if (attr === true) {
  			item.removeAttribute('hidden');
  		} else {
  			item.setAttribute('hidden', '');
  		}
	})
}