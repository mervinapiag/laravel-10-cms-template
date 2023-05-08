$(function () {
    defineHttpStatus();
    defineStatus();
    defineMessages();
    defineAjaxRequest();
});

function defineHttpStatus() {
    HttpStatus = {
        SUCCESS: 200,
        NO_CONTENT: 204,
        FOUND: 302,
        HTTP_NOT_ACCEPTABLE: 406,
        HTTP_CONFLICT: 409,
        UNKNOWN_STATUS: 419,
        UNPROCESSABLE_ENTITY: 422,
        INTERNAL_SERVER_ERROR: 500,
        INPUT_ERROR: 501,
        NOT_FOUND: 404,
        HTTP_BAD_REQUEST: 400,
    };
}

function defineStatus() {
    Status = {
        PENDING: 0,
        COMPLETED: 1,

        APPROVAL: 0,
        APPROVED: 1,
        DECLINED: 2,

        OFF: 0,
        ON: 1,

        TRUE: 1,
        FALSE: 0,
    };
}

function defineMessages() {
    var tryAgainClause =
        "\n Please try again. \n If the problem persists, \n please contact admin@rsc.com.";

    Message = {
        UNKNOWN_STATUS: "An error has occurred \n" + tryAgainClause,
        INTERNAL_SERVER_ERROR:
            "An error has occurred \n while connecting to the database. " +
            tryAgainClause,
        UNHANDLED_ERROR_MESSAGE:
            "A server error has occurred. " + tryAgainClause,
        NO_CONTENT: "Please fill out required fields",
        UNPROCESSABLE_ENTITY: "Please fill out required fields",
        SUCCESS: "Success!",
        SUCCESS_INSERT: "Success!",
        SUCCESS_UPDATE: "Success!",
        SUCCESS_DELETE: "Success!",
        SERVER_ERROR: "A server error has occurred",
        GET_DATA_ERROR: "An error has occurred while trying to get the data",
        UPDATE_DATA_ERROR: "An error has occurred while updating the data"
    };
}

function defineAjaxRequest() {
    ajax = {
        /**
         * Description: Generalized Ajax Request For List
         * @Param url
         * @return
         */
        fetch: function (url) {
            return $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                contentType: "application/json",
                mimeType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            }).done(function (response) {
                switch (response.status) {
                    case HttpStatus.SUCCESS:
                        alertify.success(Message.SUCCESS);
                        break;
                    case HttpStatus.INTERNAL_SERVER_ERROR:
                        alertify.error(Message.INTERNAL_SERVER_ERROR);
                        break;
                    default:
                        alertify.error(response.message);
                }
            }).fail(function () {
                alertify.error(Message.GET_DATA_ERROR);
            });
        },
        update: function (url, id, data,dom) {
            return $.ajax({
                url: url + id,
                type: "PUT",
                data: JSON.stringify(data),
                dataType: "json",
                contentType: "application/json",
                mimeType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            }).done(function (response) {
                switch (response.status) {
                    case HttpStatus.SUCCESS:
                            $('.alert').addClass('alert-success');
                            $('.alert').html(response.message)
                            $('.alert').show();

                            intervalRemoveAlert();
                        break;
                    case HttpStatus.NO_CONTENT:
                        break;
                    case HttpStatus.UNKNOWN_STATUS:
                        break;
                    case HttpStatus.UNPROCESSABLE_ENTITY:
                        break;
                    case HttpStatus.INTERNAL_SERVER_ERROR:
                        break;
                        case HttpStatus.HTTP_BAD_REQUEST:
                        break;
                }
            }).fail(function(response) {
                switch (response.status) {
                    case HttpStatus.UNPROCESSABLE_ENTITY:
                        //display error warning
                        $('.alert').addClass('alert-warning');

                        $('.alert').empty();
                        $('.alert').append($('<ul />').attr('id', 'errorMessage'))
                        _.each(response.responseJSON.errors, function(error) {
                            $('#errorMessage').append($('<li />').html(error[0]))
                        });
                        removeBtnSpinner(dom);
                        $('.alert').show();
                    break;
                }
            });
        },
        remove: function (url, id) {
            return $.ajax({
                url: url + id,
                type: "DELETE",
                dataType: "json",
                contentType: "application/json",
                mimeType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            }).done(function (response) {
                switch (response.status) {
                    case HttpStatus.SUCCESS:
                        alertify.success(Message.SUCCESS_DELETE);
                        break;
                    case HttpStatus.INTERNAL_SERVER_ERROR:
                        alertify.error(Message.INTERNAL_SERVER_ERROR);
                        break;
                }
            });
        },
        search: function (url, object) {
            return $.ajax({
                url: url,
                type: "POST",
                dataType: "json",
                data: JSON.stringify(object),
                contentType: "application/json",
                mimeType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            }).done(function (response) {
                switch (response.status) {
                    case HttpStatus.SUCCESS:
                        alertify.success(Message.SUCCESS);
                        break;
                    case HttpStatus.NO_CONTENT:
                        alertify.warning(Message.NO_CONTENT);
                        break;
                    case HttpStatus.UNKNOWN_STATUS:
                        alertify.error(Message.UNKNOWN_STATUS);
                        break;
                    case HttpStatus.UNPROCESSABLE_ENTITY:
                        alertify.error(Message.UNPROCESSABLE_ENTITY);
                        break;
                    case HttpStatus.INTERNAL_SERVER_ERROR:
                        alertify.error(Message.INTERNAL_SERVER_ERROR);
                        break;
                }
            });
        },
        create: function (url, data, dom) {
            return $.ajax({
                type: "POST",
                url: url,
                data: JSON.stringify(data),
                dataType: "json",
                contentType: "application/json",
                mimeType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            }).done(function (response) {
                switch (response.status) {
                    case HttpStatus.SUCCESS:
                        $('.alert').addClass('alert-success');
                        $('.alert').html(response.message)
                        $('.alert').show();

                        //hide the alert after 3 secs
                        intervalRemoveAlert();
                    case HttpStatus.NOT_FOUND:
                        break;
                    case HttpStatus.NO_CONTENT:
                        break;
                    case HttpStatus.UNKNOWN_STATUS:
                        break;
                    case HttpStatus.UNPROCESSABLE_ENTITY:
                        break;
                    case HttpStatus.INTERNAL_SERVER_ERROR:
                        break;
                    case HttpStatus.HTTP_BAD_REQUEST:
                        break;

                }
            }).fail(function(response) {
                switch (response.status) {
                    case HttpStatus.UNPROCESSABLE_ENTITY:
                        //display error warning
                        $('.alert').addClass('alert-warning');

                        $('.alert').empty();
                        $('.alert').append($('<ul />').attr('id', 'errorMessage'))
                        _.each(response.responseJSON.errors, function(error) {
                            $('#errorMessage').append($('<li />').html(error[0]))
                        });
                        removeBtnSpinner(dom);
                        $('.alert').show();
                    break;
                }
            });
        },
        createWithFile: function (url, data, dom) {
            return $.ajax({
                type: "POST",
                url: url,
                data: data,
                dataType: "json",
                contentType: false,
                processData: false,
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            }).done(function (response) {
                switch (response.status) {
                    case HttpStatus.SUCCESS:
                        alertify.success(Message.SUCCESS_INSERT);
                        break;
                    case HttpStatus.NO_CONTENT:
                        alertify.warning(Message.NO_CONTENT);
                        break;
                    case HttpStatus.UNKNOWN_STATUS:
                        alertify.error(Message.UNKNOWN_STATUS);
                        break;
                    case HttpStatus.UNPROCESSABLE_ENTITY:
                        // alertify.error(Message.UNPROCESSABLE_ENTITY);
                        break;
                    case HttpStatus.INTERNAL_SERVER_ERROR:
                        alertify.error(Message.INTERNAL_SERVER_ERROR);
                        break;
                    case HttpStatus.HTTP_BAD_REQUEST:
                        alertify.error(response.message);
                        break;
                }
            });
        },
    };
}

const addBtnSpinner=(dom)=> {
    $(dom).prop("disabled", true);
    $(dom).html(
        `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
      );
}

const removeBtnSpinner = (dom)=> {
    $(dom).prop("disabled", false);
    $(dom).children().remove();
    $(dom).html('Save changes')
}

const intervalRemoveAlert=()=> {
       //hide the alert after 3 secs
    const intervalId = setInterval(function(){
        $('.alert').hide();
        clearInterval(intervalId);
    }, 3000);

}
