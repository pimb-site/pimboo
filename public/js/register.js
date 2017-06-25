$(document).ready(function () {
	$("#register-submit").on('click', function() {
		var jqxhr = $.post( "/register", { name: $("#register_first_name").val(), email: $("#register_email").val(), password: $("#register_password").val(), password_confirmation: $("#register_confirm_password").val(), _token: $("#register_token").val() })
		jqxhr.always(function( data ) {
			if (jqxhr.status == 422) {
				json = JSON.parse(jqxhr.responseText);
				$( "#register-modal .modal-body .form .alerts" ).html( '' );
				$.each( json ,function( key, value ) {
				  $( "#register-modal .modal-body .form .alerts" ).append( '<div class="alert">' + value +  '</div>' );
				});
			}
			if (jqxhr.status == 200) {
				window.location.href = "/home"
			}
		});
	});
});

(function(){  // анонимная функция (function(){ })(), чтобы переменные "a" и "b" не стали глобальными
var a = document.querySelector('#aside1'), b = null;  // селектор блока, который нужно закрепить
window.addEventListener('scroll', Ascroll, false);
document.body.addEventListener('scroll', Ascroll, false);  // если у html и body высота равна 100%
function Ascroll() {
  if (b == null) {  // добавить потомка-обёртку, чтобы убрать зависимость с соседями
    var Sa = getComputedStyle(a, ''), s = '';
    for (var i = 0; i < Sa.length; i++) {  // перечислить стили CSS, которые нужно скопировать с родителя
      if (Sa[i].indexOf('overflow') == 0 || Sa[i].indexOf('padding') == 0 || Sa[i].indexOf('border') == 0 || Sa[i].indexOf('outline') == 0 || Sa[i].indexOf('box-shadow') == 0 || Sa[i].indexOf('background') == 0) {
        s += Sa[i] + ': ' +Sa.getPropertyValue(Sa[i]) + '; '
      }
    }
    b = document.createElement('div');  // создать потомка
    b.style.cssText = s + ' box-sizing: border-box; width: ' + a.offsetWidth + 'px;';
    a.insertBefore(b, a.firstChild);  // поместить потомка в цепляющийся блок
    var l = a.childNodes.length;
    for (var i = 1; i < l; i++) {  // переместить во вновь созданного потомка всех остальных потомков плавающего блока (итого: создан потомок-обёртка)
      b.appendChild(a.childNodes[1]);
    }
    a.style.height = b.getBoundingClientRect().height + 'px';  // если под скользящим элементом есть другие блоки, можно своё значение
    a.style.padding = '0';
    a.style.border = '0';  // если элементу присвоен padding или border
  }
  if (a.getBoundingClientRect().top <= 0) { // elem.getBoundingClientRect() возвращает в px координаты элемента относительно верхнего левого угла области просмотра окна браузера
    b.className = 'sticky';
  } else {
    b.className = '';
  }
  window.addEventListener('resize', function() {
    a.children[0].style.width = getComputedStyle(a, '').width
  }, false);  // если изменить размер окна браузера, измениться ширина элемента
}
})()