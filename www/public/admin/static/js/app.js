$(document).ready(function() {
    deleteEntity()
    toggleSidebar()
    toggleSidebarDropdown()
    disablePjaxBtnBeforeSubmit()
    handlePjaxComplete()

})

function toggleSidebar() {
    $('.header-button-toggle').on('click', function(e) {
        $('.sidebar .sidebar-items ul').toggleClass('toggled')
    })
}


function handlePjaxComplete() {
    $(document).on('pjax:complete', function() {
        deleteEntity()
    })
}

function disablePjaxBtnBeforeSubmit() {
    $(document).on('beforeSubmit', 'form', function() {
        $(this).find('button[type="submit"]').attr('disabled', true)
    })
}

function toggleSidebarDropdown() {
    $('.dropdown').on('click', function(e) {
        $(this).toggleClass('dropdown-open')
    })
}

function deleteEntity() {
    let modalConfig = {
        type: 'confirmOrClose',
        theme: 'danger',
        icon: 'icon-exclamation-triangle',
        title: 'Alert',
        text: 'Do you want to delete this item permanently?',
        apiUrl: '/file/clear-model-file-field',
        startCallback: () => {},
        finishCallback: () => {},
    }
    $('[data-action="delete"]').each(function(i, el) {
        $(el).on('click', function(e) {
            e.preventDefault()
            let deleteUrl = $(el).data('url')
            modalConfig.apiUrl = deleteUrl;
            let modal = new Modal(modalConfig);
            modal.init()
        })
    })
}
