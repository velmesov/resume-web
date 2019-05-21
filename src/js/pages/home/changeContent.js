import $ from 'jquery'

let obj = {
    menu: $('#menu'),
    content: $('#content')
}

/**
 * Переключение пунктов меню
 */
function selectMenuItem() {
    let li = obj.menu.find('li')

    li.click(function () {
        li.removeClass('active')
        $(this).addClass('active')
        changeContent($(this))
    })
}

/**
 * Переключение контента
 * 
 * @param {object} e
 */
function changeContent(e) {
    let menuItem = e.attr('data-item')
    let section = obj.content.find('.section[data-menu-item="' + menuItem + '"]')

    obj.content.find('.section').hide()
    section.fadeIn(300)
}

export { selectMenuItem }