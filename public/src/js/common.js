requirejs.config({
    urlArgs: "bust=" + (new Date()).getTime(),
    baseUrl: '/src/js',
    paths: {
        'text': 'lib/requirejs-text',
        'jquery': 'lib/jquery-2.1.4',
        'jquery.ui' : 'lib/jquery-ui.min',
        "jquery.fracs": 'lib/jquery.fracs-0.15.0',
        'dropzone': 'lib/dropzone',
        "jquery.throttle-debounce": 'lib/jquery.ba-throttle-debounce.min',
        'knockout': 'lib/knockout-3.2.0.debug',
        'ko.mapping': 'lib/knockout.mapping-latest',
        'ko.postbox': 'lib/knockout-postbox',
        'd3': 'lib/d3',
        'moment': 'lib/moment',
        'sticky': 'lib/sticky'
    },
    shim: {
        "jquery.fracs": ["jquery"],
        "jquery.throttle-debounce": ["jquery"]
    }
});