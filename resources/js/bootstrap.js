window._ = require('lodash');

import '@popperjs/core'

const bootstrap = require('bootstrap')

window.bootstrap = bootstrap

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import iziToast from "izitoast";
import 'izitoast/dist/css/iziToast.min.css';

window.toaster = (message = 'successful', title = 'Success', theme = 'light', color = 'green') => {
    return iziToast.show({
        title,
        message,
        theme,
        color,
        position: 'bottomRight'
    });
}
