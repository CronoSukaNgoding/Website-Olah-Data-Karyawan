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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Action</th>
                            <th>Name</th>
                            <th>Grade</th>
                            <th>Basic Salary</th>
                            <th>Bonus Rate</th>
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

</div>
<?php $this->endSection();?>
<?php $this->section('javascript');?>
<script src="/js/service/generateTable.js"></script>
<script>
    const domain = window.location.host.match(/localhost/g) ? `http://${window.location.host}` : `https://${window.location.host}`;

    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
    }

    function formatPercent(value) {
        return value + '%';
    }
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
                        <a class="btn btn-outline-secondary btn-sm" href="${domain}/dashboard/position/edit/${data}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                        <a class="btn btn-outline-danger btn-sm" onclick="cbModal('${data}')"><i class="fas fa-trash"></i></a>
                    `;
                }
            },
            { data: 'name'},
            { data: 'grade'},
            { data: 'basic_salary',
                render: function(data, type, row) {
                if(data == null) {
                    return '-';
                } else {
                    return formatCurrency(data);
                }
            }},
            { data: 'bonus_rate',
                render: function(data, type, row) {
                if(data == null) {
                    return '-';
                } else {
                    return formatPercent(data);
                }
            }},
        ];
            
        var order = [
            [0, 'asc']
        ];

        generateTable('#dataTable', '/dashboard/position/list', columns, order);

    });

    


</script>
<?php $this->endSection();?>