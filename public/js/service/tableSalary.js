var column =  [
    {
        data: null,
        render: function (data, type, row, meta) {
            return meta.row + 1;
        }
    },
    { data: 'salary_date',
        render: function (data, type, row, meta) {
            return data;
        }
    },
    { data: null,
        render: function (data, type, row, meta) {
            return row.first_name + " " + row.last_name;
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