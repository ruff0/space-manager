import Medium from "../plugins/medium";

export default {
    twoWay: true,
    params: ['mode'],
    update: function (newValue, oldValue) {
        let mode = 'richMode'
        let placeholder = ''
        if (this.params) {
            if (this.params.mode) {
                mode = this.params.mode + 'Mode'
            }
        }

        if (this.el.attributes) {
            if (this.el.attributes.placeholder) {
                placeholder = this.el.attributes.placeholder.value
            }
        }

        let medium = new Medium({
            element: this.el,
            mode: Medium[mode],
            placeholder: placeholder
        })

        if (newValue == "" ){
            this.set(newValue)
        }

        medium.element.addEventListener('keyup', () => {
            this.set(medium.value().replace(/(<([^>]+)>)/ig, ""))
        })
    }


}

