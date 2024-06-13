<?php $this->extend('Inc/Main');?>
<?php $this->section('css');?>
<?php $this->endSection();?>
<?php $this->section('isKonten');?>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800"><?=$title?></h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" >
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Username</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                   
                </table>
                <div class="loader-container">
                    <div class="loader"></div>
                    <p class="loader-p">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="noticeDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">DELETE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formDelete" method="post">
                    <input value="DELETE" type="hidden" name="_method" name="id">
                    <div class="modal-body">
                        <p>Are you sure want to delete this data?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btnCloseModal" class="btn btn-primary">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection();?>
<?php $this->section('javascript');?>
<script src="/js/service/generateTable.js"></script>
<script>
    const domain = window.location.host.match(/localhost/g) ? `http://${window.location.host}` : `https://${window.location.host}`;
    $(document).ready(function () {
        var columns =  [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            {
                data: 'id',
                render: function (data, type, row, meta) {
                    return `
                        <a class="btn btn-outline-secondary btn-sm" href="${domain}/dashboard/userManagement/edit/${data}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-outline-danger btn-sm" onclick="cbModal('${data}')"><i class="fas fa-trash"></i></a>
                    `;
                }
            },
            { data: 'name'},
            { data: 'email'},
            { data: 'username'},
            { data: 'roleName'}
        ];
            
        var order = [
            [0, 'asc']
        ];

        generateTable('#dataTable', '/dashboard/userManagement/list', columns, order);

    });

    


</script>
<script>

    let dataYangAkanDihapus = null;

    function cbModal(data) {
        dataYangAkanDihapus = data;
        $('#noticeDelete').modal('show');
    }

    document.getElementById('formDelete').addEventListener('submit', function (event) {
        event.preventDefault();
        if (dataYangAkanDihapus) {
            const form = document.getElementById('formDelete');
            form.action = '/dashboard/userManagement/delete/' + dataYangAkanDihapus; 
            form.submit();
        }
    });

</script>

<?php $this->endSection();?>