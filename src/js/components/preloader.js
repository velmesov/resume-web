/**
 * Создаёт прелоадер
 * 
 * @param {Object} parent
 * @param {Number} size
 */
function addPreloader(parent, size = 1) {
    let preloader =
        '<div class="preloader">' +
        '    <div class="preloader__spinner">' +
        '        <div class="spinner__circle circle_rotate_1"></div>' +
        '        <div class="spinner__circle circle_rotate_2"></div>' +
        '        <div class="spinner__circle circle_rotate_3"></div>' +
        '        <div class="spinner__circle circle_rotate_4"></div>' +
        '        <div class="spinner__circle circle_rotate_5"></div>' +
        '        <div class="spinner__circle circle_rotate_6"></div>' +
        '        <div class="spinner__circle circle_rotate_7"></div>' +
        '        <div class="spinner__circle circle_rotate_8"></div>' +
        '    </div>' +
        '</div>'

    parent.append(preloader);
    parent.children('.preloader').children('.preloader__spinner').css({
        'transform': 'scale(' + size + ')'
    });
}

/**
 * Удаляет прелоадер
 * 
 * @param {Object} parent
 */
function removePreloader(parent) {
    parent.children('.preloader').remove()
}

export { addPreloader, removePreloader }