import $ from 'jquery'

let notifications = {
    obj: $('#notifications'),
    fade: 500,
    duration: 3000
}

/**
 * Показ сообщения
 * 
 * @param {string} type 
 * @param {string} text 
 */
function showNotice(type, text) {
    let index = notifications.obj.find('.notice').length
    let html = '<div class="notice notice_' + type + '" data-index="' + index + '">' + text + '</div>'

    notifications.obj.append(html)
    notifications.obj.children('.notice[data-index="' + index + '"]').fadeIn(notifications.fade, function () {
        setTimeout(removeNotice, notifications.duration, index)
    })
}

/**
 * Удаление сообщения
 * 
 * @param {number} index
 */
function removeNotice(index) {
    notifications.obj.children('.notice[data-index="' + index + '"]').fadeOut(notifications.fade, function () {
        notifications.obj.children('.notice[data-index="' + index + '"]').remove()
    })
}

export { showNotice, removeNotice }