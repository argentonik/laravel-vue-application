<template>
    <div>
        <div class="upload-image container">
            <div 
                class="panel" 
                v-show="isPanelShow"
            >
                <div 
                    class="button_outer" 
                    :class="buttonOuterClass"
                >
                    <div class="btn_upload btn btn-outline-primary">
                        <input 
                            type="file" 
                            id="upload_file" 
                            name="image" 
                            accept="image/*" 
                            onmouseover="this.title='';"
                            @change="onChangeImage"
                            :value="uploadedFile"
                        >Upload image
                    </div>
                    <div class="processing_bar"></div>
                    <div class="success_box"></div>
                </div>
            </div>
            <div class="error_msg">{{ error }}</div>
            <div 
                :class="'uploaded_file_view' + ' ' + uploadedViewClass" 
                 id="uploaded_view"
            >
                <img :src="imgPath" />
                <span 
                    class="file_remove" 
                    @click="onRemoveImage"
                >X</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        serverImage: {
            required: false,
            default: null
        }
    }, 
    data() {
        return {
            imageInput: null,
            imgPath: '',
            error: '',
            uploadedFile: null,
            buttonOuterClass: '',
            uploadedViewClass: '',
            isPanelShow: true
        }
    },
    mounted() {
        if (this.serverImage && this.serverImage.indexOf('default') == -1) {
            this.isPanelShow = false
            this.imgPath = this.serverImage
            this.uploadedViewClass = 'show';
        }
    },
    methods: {
        onChangeImage(e) {
            var ext = e.target.files[0].name.split('.').pop().toLowerCase();

            if (!['png','jpg','jpeg'].includes(ext)) {
                this.error = 'Not an Image...'
                this.uploadedFile = null
            } else {
                this.error = ''
                this.buttonOuterClass = 'file_uploading'
                let file = e.target.files[0]
                var uploadedFile = URL.createObjectURL(file)
                setTimeout(() => {
                    this.isPanelShow = false
                    this.imgPath = uploadedFile
                    this.$emit("changeImage", file)
                    this.uploadedViewClass = 'show';
                }, 3500)

            }
        },
        onRemoveImage() {
            if (this.serverImage) {
                this.createCookie('deletedServerImage', true, 1)
            }
            this.$emit("changeImage", '')
            this.uploadedFile = null
            this.uploadedViewClass = ''
            this.imgPath = ''
            this.buttonOuterClass = ''
            this.isPanelShow = true
        },
        createCookie(name, value, days) {
            var expires;
            if (days) {
                var date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toGMTString();
            }
            else {
                expires = "";
            }
            document.cookie = escape(name) + "=" + escape(value) + expires + "; path=/";
        },
        show(event) {
            targetId = event.currentTarget.id;
        }
    }
}
</script>

<style scoped>
    .panel {
        margin: 100px auto 40px; 
        max-width: 500px; 
        text-align: center;
    }
    .button_outer {
        border-radius:30px; 
        text-align: center; 
        height: 50px; 
        width: 250px; 
        display: inline-block; 
        transition: .2s; 
        position: relative; 
        overflow: hidden;
    }
    .btn_upload {
        cursor: auto !important;
        text-align: center; 
        position: relative; 
        display: inline-block; 
        overflow: hidden; 
        z-index: 3; 
        white-space: nowrap;
        
    }
    .btn_upload input {
        position: absolute; 
        width: 100%; 
        left: 0; 
        top: 0; 
        width: 100%; 
        height: 105%; 
        opacity: 0;
    }
    .file_uploading {
        width: 100%; 
        height: 10px; 
        margin-top: 20px; 
        background: #ccc;
    }
    .file_uploading .btn_upload {
        display: none;
    }
    .processing_bar {
        position: absolute; 
        left: 0; 
        top: 0; 
        width: 0; 
        height: 100%; 
        border-radius: 30px; 
        background:#83ccd3; 
        transition: 3s;
    }
    .file_uploading .processing_bar {
        width: 100%;
    }
    .success_box {
        display: none; 
        width: 50px; 
        height: 50px; 
        position: relative;
    }
    .file_uploaded .success_box {
        display: inline-block;
    }
    .file_uploaded {
        margin-top: 0; 
        width: 50px; 
        background:#83ccd3; 
        height: 50px;
    }
    .uploaded_file_view {
        max-width: 400px; 
        margin: 20px auto; 
        text-align: center; 
        position: relative; 
        transition: .2s; 
        opacity: 0; 
        padding: 15px;
    }
    .file_remove{
        width: 30px; 
        height: 30px; 
        border-radius: 50%; 
        display: block; 
        position: absolute; 
        background: #aaa; 
        line-height: 30px; 
        color: #fff; 
        font-size: 12px; 
        cursor: pointer; 
        right: -15px; 
        top: -15px;
    }
    .file_remove:hover {
        background: #222; 
        transition: .2s;
    }
    .uploaded_file_view img {
        max-width: 100%;
    }
    .uploaded_file_view.show {
        opacity: 1;
    }
    .error_msg {
        text-align: center; color: #f00
    }    
</style>