<?php $this->extend('Inc/Main');?>
<?php $this->section('css');?>
<style>

  input[type="date"] {
    /* width: 100%; */
    padding: 8px;
    margin-bottom: 10px;
    border-radius:15px;
    box-sizing: border-box;
  }
  card-filter{
    border-radius:15px;
    box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
  }



</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


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
        <p class="card-title">Filter Tanggal</p>
            <div class="mb-3">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date">
            </div>

            <div class="mb-3">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date">
            </div>

            <button id="filter_button"class="btn btn-primary">Filter</button>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Employee Name</th>
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
<!-- <script src="/js/service/generateTable.js"></script> -->
<script>
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
</script>
<script src="/js/service/tableSalary.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css"> 
    <script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> 
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<!-- <script src="/assets/libs/jquery/jquery.min.js"></script> -->
<script href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"></script>
<script>
    const domain = window.location.host.match(/localhost/g) ? `http://${window.location.host}` : `https://${window.location.host}`;
    var EmployeeID = `<?=$employeeID?>`;
    

    function filterData() {
        var formattedStartDate = $("#start_date").val();
        var formattedendDate = $("#end_date").val();
        if(formattedStartDate  === "" && formattedendDate === ""){
            var employeeID = EmployeeID;

            if (dataTable) {
            dataTable.destroy();
            }
            dataTable = generateTable('#dataTable', '/dashboard/salary/list', column, order, "", "",employeeID);
        }else{
            try {
                var startDateObj = new Date(formattedStartDate);
                var endDateObj = new Date(formattedendDate);

                if (endDateObj < startDateObj) {
                    alert("End date cannot be less than start date.");
                    return;
                }

                endDateObj.setHours(23, 59, 59, 999);

                var startDate = new Date(startDateObj.getTime() - (startDateObj.getTimezoneOffset() * 60000)).toISOString().slice(0, 19).replace("T", " ");
                var endDate = new Date(endDateObj.getTime() - (endDateObj.getTimezoneOffset() * 60000)).toISOString().slice(0, 19).replace("T", " ");

                // Convert to local string
                startDate = new Date(startDateObj.getTime() ).toISOString().slice(0, 19).replace("T", " ");
                endDate = new Date(endDateObj.getTime() + (7 * 60 * 60 * 1000)).toISOString().slice(0, 19).replace("T", " ");

                var employeeID = EmployeeID;


                if (dataTable) {
                dataTable.destroy();
                }
                dataTable = generateTable('#dataTable', '/dashboard/salary/list', column, order, startDate, endDate,employeeID);
            } catch (error) {
                alert(error);
                return;
            }
        }
    }
    $(document).ready(function () {
        dataTable = generateTable('#dataTable', '/dashboard/salary/list', column, order,'','',EmployeeID);
        $("#filter_button").on("click", filterData);
    });

    function generateTable(idTable, url, columns, order, startDate, endDate,employeeID) {
        const jmlCol = columns.length;
        var newDataTable = $(idTable).DataTable({
            columns: columns,
            order: order,
            fixedColumns: true,
            scrollCollapse: true,
            scrollY: 300,
            scrollX: true,
            processing: false,
            serverSide: false,
            dom: 'Bfrtip',
            buttons: ["copy", "excel", "pdf"],
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
        });

        var requestData = {
            employeeID:employeeID,
            startDate: startDate,
            endDate: endDate
        };

        $.ajax({
            url: url,
            method: 'POST',
            data: requestData,
            dataSrc: 'data',
            beforeSend: function () {
                $(idTable + " tbody").empty();
                $(idTable + " tbody").append(
                "<tr>" +
                "<td colspan='" + jmlCol + "'>" +
                "<center>" +
                "<div class='loader' id='loader-1'></div>" +
                "</center>" +
                "</td>" +
                "</tr>"
                );
            },
            success: function (response) {
                if (response && response.error === 'No data found') {
                    newDataTable.clear().draw();
                    $(".loader-container").hide();
                } else if (response.response && response.response.data) {
                    var data = response.response.data;
                    if (data.length > 0) {
                        $(".loader-container").show();
                        newDataTable.clear().rows.add(data).draw();
                        $(".loader-container").hide();
                    } else {
                        newDataTable.clear().draw();
                        $(".loader-container").hide();
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: " + xhr);
            }
        });
        
        return newDataTable;
    }
    
   

    

    


</script>
<?php $this->endSection();?>