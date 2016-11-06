<template>
    <div>
        <div v-el:dropzone class="dropzone" v-if="!uploaded"></div>
        <div v-el:preview class="preview" v-if="uploaded && image">
            <img :src="image">
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            url: {
                type: String,
                default: 'SomeUrlToInitialize'
            },
            autoProcessQueue: {
                type: Boolean,
                default: true
            },
            files: {
                type: Array,
                default: () => []
            }
        },
        data(){
            return {
                uploaded : false,
                image: null
            }
        },
        ready () {
            const dropzone = new Dropzone(this.$els.dropzone, {
                url: this.url,
                autoProcessQueue: this.autoProcessQueue,
                uploadMultiple: false,
                maxFiles: 1,
                sending: (file, xhr, formData) => {
                    // Pass token. You can use the same method to pass any other values as well such as a id to associate the image with for example.
                    formData.append("_token", document.querySelector('#token').getAttribute('value')); // Laravel expect the token post value to be named _token by default
                },
            });

            dropzone.on('thumbnail', (file, thumbnail) => {
                this.files.push({file, thumbnail});
            });

            dropzone.on('success', (file) => {
                let response = JSON.parse(file.xhr.response)
                this.image = "/" + response.pathname
                this.uploaded = true
            });
        },
        destroyed () {
            this.files = [];
        }
    };
</script>
<style lang="sass">
    @import "../../../../../node_modules/dropzone/src/basic.scss";
    @import "../../../../../node_modules/dropzone/src/dropzone.scss";

    .preview {
        height: 360px;
        overflow: hidden;
        max-width: 100%;
        img {
            max-width: 100%;
        }
    }

    .dropzone {
        padding : 0;
        height : 360px;
        background: rgba(255, 255, 255, 0.901961);
        border: none;
        border-radius: 0;
    }
</style>