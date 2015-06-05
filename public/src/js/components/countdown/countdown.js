define(['knockout', 'text!components/countdown/countdown.html'], function(ko, htmlString) {
    function CountdownViewModel(params) {
        var self = this;
    }

    return { viewModel: CountdownViewModel, template: htmlString };
});