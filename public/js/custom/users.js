$(function() {
    initUserDatatable();
    attachSaveBtnListener();
    attachAddUserModalBtnListener();
    attachViewUserBtnListener();
    attachEditUserBtnListener();
    //init
    $('.alert').hide();
});
//global variable
let table = '';
let userId = 0;

const initUserDatatable= () => {
    table = $('#dataTable').DataTable({
        // order: [[0, "desc"]],
        processing: true,
        serverSide: true,
        ajax: "/admin/users",
        columns: [
            {  data: 'id', name:'id'},
            {  data: 'name', name:'name'},
            {  data: 'email', name:'email'},
            {  data: 'action', name:'action', orderable: false, searchable: false},
        ],
        oLanguage: {sProcessing:`<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`}
    });
}

const attachSaveBtnListener=()=> {
    $(document).on('click', '#saveBtn', function(){
        //request methods
        const requestMethod = $(this).data('method');
        console.log(requestMethod);
        //userObj
        const obj = {};
        obj.name = $('#name').val();
        obj.email = $('#email').val();

        //remove class except alert class
        $('.alert').attr('class', 'alert');

        //add spinner
        let dom = $(this);
        addBtnSpinner(dom);

        //POST Method
        if($(this).hasClass('methodPOST')) {
            //get the row data when action button is clicked
            ajaxCreate(obj, dom);
        }
        else if($(this).hasClass('methodPUT')) {
            if(userId > 0) {
                ajaxUpdate(obj ,dom);
            } else {
                $('.alert').addClass('alert-warning');
                $('.alert').html('User not found!');
                $('.alert').show();
            }
        }else{
            return false;
        }


    });
};

const ajaxCreate = (obj, dom) => {
        $.when(ajax.create("/admin/users", obj, dom)).done(function(response) {
            switch (response.status) {
                case HttpStatus.SUCCESS:
                    removeBtnSpinner(dom);
                    //reload the datatable
                    table.ajax.reload(null, false);
                    //clear inputs
                    $('#name').val('');
                    $('#email').val('');
                break;
            }
        });
}

const ajaxUpdate = (obj, dom) => {
        $.when(ajax.update(`/admin/users/`, userId, obj, dom)).done(function(response) {
            switch (response.status) {
                case HttpStatus.SUCCESS:
                    removeBtnSpinner(dom);
                    //reload the datatable
                    table.ajax.reload(null, false);
                    userId = 0;
                break;
            }
        });
}

const attachAddUserModalBtnListener=()=> {
    $(document).on('click', '.actionAdd', function() {
        //change the save changes button method type to PUT
        appendSaveBtnWithRequestMethod('methodPOST');

        $('#userModalTitle').html('Add Users');
        $('#addUserBtn').show();
        //clear inputs
        $('#name').val('');
        $('#email').val('');
    })
}

const attachViewUserBtnListener = () => {
    $(document).on('click', '.actionView', function() {
        //show modal
        $('#userModal').modal('show');
        //get the row data when action button is clicked
        let data = table.row($(this).parents('tr')).data();

        $('#saveBtn').hide();
        $('#userModalTitle').html('View User Information')
        $('#name').val(data.name);
        $('#email').val(data.email);

        //change the save changes button method type to PUT
        appendSaveBtnWithRequestMethod('methodGET');
    });
}

const attachEditUserBtnListener = () => {
    $(document).on('click', '.actionEdit', function() {

        //show modal
        $('#userModal').modal('show');
        //get the row data when action button is clicked
        let user = table.row($(this).parents('tr')).data();

        //change the save changes button method type to PUT
        appendSaveBtnWithRequestMethod('methodPUT');
        $('#saveBtn').show();
        $('#userModalTitle').html('Edit User Information')
        $('#name').val(user.name);
        $('#email').val(user.email);
        userId = parseInt(user.id);
    });
}

const appendSaveBtnWithRequestMethod = (requestMethodClass) =>{
    console.log('APPEND BUTTON');
    $('#saveBtn').remove();

    if(requestMethodClass === 'methodGET') return false;
    $('#modalFooter').append($('<button />').attr({'id':'saveBtn','type':'button', 'class':`btn btn-primary ${requestMethodClass}`})
    .html('Save changes')
    );
}
