import $ from 'jquery'

/**
 * Основные настройки
 */
let ajax_options = {
    type: 'post',
    dataType: 'json',
    timeout: 10000,
    url: conf.site
}

function setupAjax() {
    $.ajaxSetup({
        type: ajax_options.type,
        dataType: ajax_options.dataType,
        timeout: ajax_options.timeout,
        url: ajax_options.url
    })
}

export { setupAjax }