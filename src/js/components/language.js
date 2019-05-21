import $ from 'jquery'
import { showNotice } from './notifications'

/**
 * Получаем текущие языковые фразы
 */
function getLanguage() {
    $.ajax({
        data: {
            handler: 'Language',
            exec: 'get'
        }
    }).fail(function (jqXHR, textStatus, errorThrown) {
        showNotice('error', 'Ошибка загрузки файла локализации')
    }).done(function (data, textStatus, jqXHR) {
        conf.lang = data.lang
    })
}

export { getLanguage }