class File {
    selector;
    fileInput;
    preview;
    placeholder;
    actions;
    options;


    constructor(selector, options) {
        this.selector = selector;
        this.preview = this.getPreview(selector);
        this.placeholder = this.getPlaceholder(selector);
        this.actions = this.getActions(selector)
        this.fileInput = this.getFileInput(selector);
        this.options = options;
        this.onUpload();
        this.onDelete();
        this.acceptActions(true)

    }

    onUpload() {
        this.placeholder.click(() => {
           this.fileInput.trigger('click');
        });

        this.fileInput.on('change', (e) => {
            if (!e.target.files) {
                return
            }
            [...e.target.files].forEach(this.loadImage, this);
            this.showPreviewImage()
            this.acceptActions()
        })
    }

    onDelete() {
        $(".form-image .action-delete").on('click', (e) => {
            let model_table = this.preview.data('model_table');
            let file_field = this.preview.data('file_field');
            let model_id = this.preview.data('model_id');

            this.deleteImage({
                model_id: model_id,
                model_table: model_table,
                file_field: file_field,
            })



        })
    }

    loadImage(file) {
        const reader = new FileReader();
        $(reader).on('loadstart', () => {
            this.showLoader()
        })
        $(reader).on('load', () => {
            let previewImg = this.preview.find('img');
            if (previewImg[0]) {
                previewImg[0].src = reader.result;
                previewImg[0].alt = file.name;
            }
        });
        $(reader).on('loadend', () => {
            this.hideLoader()
        })
        reader.readAsDataURL(file);
    }

    deleteImage(data) {
        let modalConfig = {
            type: 'confirmOrClose',
            theme: 'danger',
            icon: 'icon-exclamation-triangle',
            title: 'Alert',
            text: 'Do you want to delete this image?',
        }
        modalConfig.apiUrl = '/file/clear-model-file-field'
        modalConfig.data = data
        modalConfig.startCallback = this.showLoader
        modalConfig.finishCallback = this.hideLoader

        let modal = new Modal(modalConfig);
        modal.init().then((data) => {
            if (data.result) {
                this.clearInputValue()
                this.hidePreviewImage()
                this.disableActions()
            }
        })
    }

    showPreviewImage() {
        let img = this.preview.find('img')
        img.fadeIn(0)
    }

    hidePreviewImage() {
        let img = this.preview.find('img')
        img.fadeOut(0)
    }

    clearInputValue() {
        this.fileInput.val(null)
    }

    acceptActions(onInit = false) {
        let src = this.preview.find('img').attr('src')
        if (onInit) {
            if (src.length) {
                this.actions.addClass('active')
            }
        } else {
            this.actions.addClass('active')
        }
    }

    disableActions() {
        this.actions.removeClass('active')
    }

    onDeleteSuccess() {
        console.log('success')
    }

    onDeleteError(error) {
        console.log(error)
    }

    showLoader() {
        $(document).find('.preview').find('.loader').addClass('active')

    }

    hideLoader() {
        $(document).find('.preview').find('.loader').removeClass('active')
    }

    getFileInput(selector) {
        return $(selector).find('input[type="file"]');
    }

    getPreview(selector) {
        return $(selector).find('.preview');
    }

    getPlaceholder(selector) {
        return $(selector).find('.preview-placeholder');
    }

    getActions(selector) {
        return $(selector).find('.form-image-actions')
    }
}
