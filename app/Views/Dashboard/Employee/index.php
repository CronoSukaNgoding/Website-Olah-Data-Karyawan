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
                            <th>Name</th>
                            <th>NIP</th>
                            <th>Position</th>
                            <th>Address</th>
                            <th>Birth Date</th>
                            <th>Hire Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                   
                </table>
            </div>
        </div>
    </div>

</div>
<?php $this->endSection();?>
<?php $this->section('javascript');?>
<script src="/js/service/generateTable.js"></script>
<script>
    const domain = window.location.host.match(/localhost/g) ? `http://${window.location.host}` : `https://${window.location.host}`;
    function formatDate(dateStr) {
        const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                        "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        const date = new Date(dateStr);
        const year = date.getFullYear();
        const month = months[date.getMonth()];
        const day = date.getDate();

        return `${year} ${month} ${day}`;
    }
    $(document).ready(function () {
        var columns =  [
            {
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: null,
                render: function (data, type, row, meta) {
                    return row.first_name + " " + row.last_name;
                }
            },
            { data: 'nip'},
            { data: 'positionName'},
            { data: 'address'},
            { data: 'birth_date',
                render: function (data, type, row, meta) {
                    return formatDate(data);
                }
            },
            { data: 'hire_date',
                render: function (data, type, row, meta) {
                    return formatDate(data);
                }
            }
        ];
            
        var order = [
            [0, 'asc']
        ];

        generateTable('#dataTable', '/dashboard/employee/list', columns, order);

    });

    


</script>
<?php $this->endSection();?>