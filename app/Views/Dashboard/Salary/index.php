<?php $this->extend('Inc/Main');?>
<?php $this->section('css');?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
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
        <div class="row">
            <div class="col-lg-4 mb-3">
                <label class="form-label">Date Range</label>
                <input type="text" name="daterange" id="date-range" placeholder="Select Date Range" />
            </div>
            <div class="col-lg-12 mb-3">
                <button id="filter-button" class="btn btn-primary">Filter</button>
            </div>
        </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Employee Name</th>
                            <th>Salary Date</th>
                            <th>Basic Salary</th>
                            <th>Bonus</th>
                            <th>Tax</th>
                            <th>Total Salary</th>
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    const domain = window.location.host.match(/localhost/g) ? `http://${window.location.host}` : `https://${window.location.host}`;

    function formatCurrency(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
    }

    function formatPercent(value) {
        return value + '%';
    }

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
            { data: 'tglBuat',
                render: function (data, type, row, meta) {
                    return data;
                }
            },
            { data: null,
                render: function (data, type, row, meta) {
                    return row.first_name + " " + row.last_name;
                }
            },
            { data: 'salary_date',
                render: function (data, type, row, meta) {
                    return formatDate(data);
                }
            },
            { data: 'basic_salary',
                render: function(data, type, row) {
                if(data == null) {
                    return '-';
                } else {
                    return formatCurrency(data);
                }
            }},
            { data: 'bonus',
                render: function(data, type, row) {
                if(data == null) {
                    return '-';
                } else {
                    return formatCurrency(data);
                }
            }},
            { data: 'tax',
                render: function(data, type, row) {
                if(data == null) {
                    return '-';
                } else {
                    return formatCurrency(data);
                }
            }},
            { data: 'total_salary',
                render: function(data, type, row) {
                if(data == null) {
                    return '-';
                } else {
                    return formatCurrency(data);
                }
            }},

        ];
            
        var order = [
            [0, 'asc']
        ];

        generateTable('#dataTable', '/dashboard/salary/list', columns, order, '', '');

        $('input[name="daterange"]').daterangepicker({
            opens: 'left'
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));

            
        });

        
        $('#date-range').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM') + ' - ' + picker.endDate.format('YYYY-MM'));
        });

        // Event listener for clearing the date range
        $('#date-range').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        

        

    });

    


</script>
<?php $this->endSection();?>