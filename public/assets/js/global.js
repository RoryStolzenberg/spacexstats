// // Global functions that are written in jQuery. SpaceX Stats 4, Lukas Davia. 
// $(document).ready(function() {
	
// });

// // Classlist plugin
// (function ($) {
//     $.fn.classes = function (callback) {
//         var classes = [];
//         $.each(this, function (i, v) {
//             var splitClassName = v.className.split(/\s+/);
//             for (var j in splitClassName) {
//                 var className = splitClassName[j];
//                 if (-1 === classes.indexOf(className)) {
//                     classes.push(className);
//                 }
//             }
//         });
//         if ('function' === typeof callback) {
//             for (var i in classes) {
//                 callback(classes[i]);
//             }
//         }
//         return classes;
//     };
// })(jQuery);