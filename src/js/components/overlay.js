import $ from 'jquery'

let overlay = $('#overlay')

overlay.click(hideOverlay)

/**
 * Показ оверлея
 * 
 * @param {string} name_func 
 */
function showOverlay(name_func = '') {
    overlay.addClass('overlay_show')
    overlay.attr('data-execute', name_func)
}

/**
 * Скрытие оверлея
 */
function hideOverlay() {
    let name_func = overlay.attr('data-execute')

    // TODO: Переписать на обычное закрытие, не вызывая функцию
    if (name_func !== '') {
        window[name_func]()
    }

    if (name_func == 'hideSubModal') {
        overlay.attr('data-execute', 'hideModal').css('z-index', 97)
    }
    else {
        overlay.attr('data-execute', '').removeClass('overlay_show')
    }
}

export { showOverlay, hideOverlay }