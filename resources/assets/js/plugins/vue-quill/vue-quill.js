var Quill = require('./Quill.vue');

module.exports = {
    install: function (Vue, options) {
        Vue.component('quill', Quill);

        Vue.filter('quill-preview', function (value, limit) {
            const text = value.ops.map(function (op) {
                return op.insert
            }).join(' ')

            if (typeof limit !== 'undefined' && text.length > limit) {
                return text.substring(0, parseInt(limit, 10)) + '...'
            }

            return text
        });
    },
}