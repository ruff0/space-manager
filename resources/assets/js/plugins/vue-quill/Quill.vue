<template>
    <div>
        <div v-el:toolbar class="ui top attached menu toolbar ql-toolbar ql-snow">
            <slot name="toolbar">
                <div class="ql-format-group">
                    <a class="ql-format-button ql-bold"></a>
                    <span class="ql-format-separator"></span>
                    <a class="ql-format-button ql-underline"></a>
                    <span class="ql-format-separator"></span>
                    <a class="ql-format-button ql-italic"></a>
                </div>
                <div class="ql-format-group">
                    <a class="ql-format-button ql-list"></a>
                    <span class="ql-format-separator"></span>
                    <a class="ql-format-button ql-bullet"></a>
                    <span class="ql-format-separator"></span>
                    <span title="Text Alignment" class="ql-align ql-picker">
                        <span class="ql-picker-label" data-value="left"></span>
                        <span class="ql-picker-options">
                            <span data-value="left" class="ql-picker-item ql-selected"></span>
                            <span data-value="center" class="ql-picker-item"></span>
                            <span data-value="right" class="ql-picker-item"></span>
                            <span data-value="justify" class="ql-picker-item"></span>
                        </span>
                    </span>
                </div>
            </slot>
        </div>
        <div class="ui attached segment" v-el:quill @click.prevent="focusEditor"></div>
    </div>
</template>

<script>
    const Quill = require('quill')
    export default {
        props: {
            content: {},

            author: {},

            formats: {
                type: Array,
                default() {
                    return []
                },
            },

            keyBindings: {
                type: Array,
                default() {
                    return []
                },
            },

            output: {
                default: 'delta'
            },

            keyup: {
                default: null
            },

            config: {
                default() {
                    return {

                    }
                },
            },
        },

        data() {
            return {
                editor: {},
            }
        },

        ready() {
            this.editor = new Quill(this.$els.quill, this.config)

            this.formats.map((format) => {
                this.editor.addFormat(format.name, format.options)
            })

            if (this.output != 'delta') {
                this.editor.setHTML(this.content);
            } else {
                this.editor.setContents(this.content);
            }

            this.editor.on('text-change', (delta, source) => {
                this.$dispatch('text-change', this.editor, delta, source)
                this.content = this.output != 'delta' ? this.editor.getHTML() : this.editor.getContents()
            })

            this.editor.on('selection-change', (range) => {
                this.$dispatch('selection-change', this.editor, range)
            })

            if (typeof this.author !== 'undefined') {
                this.editor.addModule('authorship', {
                    authorId: this.author,
                })
            }

            if (this.keyBindings.length) {
                const keyboard = this.editor.getModule('keyboard')

                this.keyBindings.map((binding) => {
                    keyboard.addHotkey({key: binding.key, metaKey: true}, binding.method.bind(this))
                })
            }
        },

        events: {
            'set-content': function (content) {
                this.editor.setContents(content)
            },

            'set-html': function (html) {
                this.editor.setHTML(html)
            },

            'focus-editor': function () {
                this.focusEditor()
            }
        },

        methods: {
            focusEditor(e) {

                if (e && e.srcElement) {
                    let classList = e.srcElement.classList, isSegment = false;

                    classList.forEach((className) => {
                        if (className === 'segment') {
                            isSegment = true
                            return
                        }
                    })

                    if (!isSegment) return;
                }

                this.editor.focus()

                this.editor.setSelection(this.editor.getLength() - 1, this.editor.getLength())


            }

        },
    }
</script>