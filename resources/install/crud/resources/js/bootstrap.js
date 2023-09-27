import _ from 'lodash';
window._ = _;

// Import all of Bootstrap's JS
import * as bootstrap from 'bootstrap'
window.bootstrap = bootstrap;

// Import all of AdmilLTE JS
import * as adminlte from 'admin-lte/dist/js/adminlte'
window.adminlte = adminlte;

// Import Quill
import Quill from 'quill/dist/quill.js'
window.Quill = Quill

// Import Axios
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';