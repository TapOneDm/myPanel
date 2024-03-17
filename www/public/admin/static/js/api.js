class ApiService {
    static get(url) {
        return $.get({
            type: "GET",
            url: url,
        }).done(function(response) {
            return response
        }).fail(function() {
            ApiService.processError()
        });
    }

    static post(url, data) {
        return $.post({
            type: "POST",
            url: url,
            data: data
        }).done(function(response) {
            return response
        }).fail(function(error) {
            setTimeout(() => {
                ApiService.processError()

            }, 1000)
        });
    }

    static processError() {
        let modal = new Modal({
            type: 'closeOnly',
            theme: 'danger',
            title: 'Sorry',
            icon: 'icon-wifi-slash',
            text: 'Something went wrong! We are fixing it',
        })
        modal.init()
    }
}