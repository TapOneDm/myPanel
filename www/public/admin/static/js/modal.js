class Modal {

    modalOptions;
    modalUuid;

    constructor(modalOptions) {
        this.modalOptions = this.getModalOptions(modalOptions);
        this.setModalUuid();
    }

    getModal() {
        return `<div id="${this.getModalUuid()}" class="modal-wrapper">
            <div class="modal modal-${this.modalOptions.theme}">
                <div class="modal-content">
                    <div class="modal-title">
                        <i class="${this.modalOptions.icon}"></i>
                        <span>${this.modalOptions.title}</span>
                    </div>
                    <div class="modal-text">${this.modalOptions.text}</div>
                    <div class="modal-buttons">
                        ${this.getModalButtonsMarkup()}
                    </div>
                </div>
            </div>
        </div>`;
    }

    getModalOptions(modalOptions) {
        if (!modalOptions) {
            return this.getDefaultModalOptions()
        }
        return modalOptions;
    }

    getDefaultModalOptions() {
        return {
            type: 'closeOnly',
            theme: 'confirm',
            icon: 'icon-exclamation-triangle',
            title: 'Attention',
            text: 'Please, confirm action',
        };
    }

    getModalButtonsMarkup() {
        switch (this.modalOptions.type) {
            case 'closeOnly':
                return `
                    <button class="modal-close">Ok</button>
                `;

            case 'confirmOrClose':
                return `
                    <button class="modal-confirm">Yes</button>
                    <button class="modal-close">No</button>
                `;

            default:
                return `
                    <button class="modal-close">Ok</button>
                `;
        }
    }

    getModalUuid() {
        return this.modalUuid;
    }

    setModalUuid() {
        this.modalUuid = "10000000-1000-4000-8000-100000000000".replace(/[018]/g, c =>
            (c ^ crypto.getRandomValues(new Uint8Array(1))[0] & 15 >> c / 4).toString(16)
        );
    }

    init() {
        return new Promise((resolve) => {
            $('body').append($(this.getModal()))
            resolve(this.handleModalEvents(this.modalOptions))
        })
    }

    close() {
        let modal = $(`.modal-wrapper[id="${this.getModalUuid()}"]`);
        modal.off()
        modal.remove()
    }

    handleModalEvents() {
        return new Promise((resolve) => {
            $(`.modal-wrapper[id="${this.getModalUuid()}"]`).on('click', (e) => {
                if ($(e.target).hasClass('modal-close')) {
                    this.close()
                    resolve(true)
                }

                if ($(e.target).hasClass('modal-confirm')) {
                    if (this.modalOptions.apiUrl) {
                        this.modalOptions.startCallback()
                        ApiService.post(this.modalOptions.apiUrl, this.modalOptions.data).then((data) => {
                            this.modalOptions.finishCallback()
                            this.close()
                            resolve(data)
                        }).catch(() => {
                            this.modalOptions.finishCallback()
                            this.close()
                        })
                    } else {
                        this.close()
                        resolve(true)
                    }
                }
            })
        })
    }
}