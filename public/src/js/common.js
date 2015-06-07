requirejs.config({
    baseUrl: '/src/js',
    urlArgs: "bust=" +  (new Date()).getTime(),
    paths: {
        'text': 'lib/requirejs-text',
        'jquery': 'lib/jquery-1.9.1',
        'jquery.ui' : 'lib/jquery-ui.min',
        "jquery.fracs": 'lib/jquery.fracs-0.15.0',
        'dropzone': 'lib/dropzone.js',
        "jquery.throttle-debounce": 'lib/jquery.ba-throttle-debounce.min',
        'knockout': 'lib/knockout-3.2.0.debug'
    },
    shim: {
        "jquery.fracs": ["jquery"],
        "jquery.throttle-debounce": ["jquery"]
    }
});