/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    var datatable;
    function fulldata() {
        datatable = $('#newsDataTable').DataTable({
            "destroy": true,
            "lengthMenu": [[10, 20, 30, -1], [10, 20, 30, "All"]],
            "searching": true,
            "ordering": true,
            "order": [[0, "desc"]],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo $this->url('home', array('action'=>'getAll'));?>",
                "type": "POST"
            },
            "columnDefs": [{
                    "targets": 0,
                    "data": "ISIN",
                    "orderable": false,
                    "render": function (data, type, full, meta) {
                        return data;
                    }
                }, {
                    "targets": 1,
                    "data": "trading_market",
                    "orderable": false,
                    "render": function (data, type, full, meta) {
                        return data.xname;
                    }
                }, {
                    "targets": 2,
                    "data": "currency",
                    "orderable": false,
                    "render": function (data, type, full, meta) {
                        return data.code;
                    }
                }, {
                    "targets": 3,
                    "data": "issuer",
                    "orderable": false,
                    "render": function (data, type, full, meta) {
                        return data.xname;
                    }
                }, {
                    "targets": 4,
                    "data": "issuerprice",
                    "render": function (data, type, full, meta) {
                        return data;
                    }
                }, {
                    "targets": 5,
                    "data": "currentprice",
                    "render": function (data, type, full, meta) {
                        return data;
                    }
                }, {
                    "targets": 6,
                    "data": "id",
                    "orderable": false,
                    "render": function (data, type, full, meta) {
                        var activeicon = 'fa fa-close';
                        var activemsg = 'Activate';
                        if (full.active) {
                            activeicon = 'fa fa-check';
                            activemsg = 'Deactivate';
                        }
                        return "<a rel='" + data + "' class='btn btn-xs chstatus' data-toggle='tooltip' data-placement='top' title='" + activemsg + "'><i class='" + activeicon + "'></i></a>"
                                + "<a href='<?php echo $this->url('certificate', array('action'=>'edit'));?>" + data + "' class='btn btn-xs' data-toggle='tooltip' data-placement='top' title='Edit'><i class='fa fa-edit'></i></a>"
                                + "<a rel='" + data + "' class='btn btn-xs delete' data-toggle='tooltip' data-placement='top' title='Delete'><i class='fa fa-trash'></i></a>"
                                + "<a href='<?php echo $this->url('certificate', array('action'=>'displayAsHtml'));?>" + data + "' class='btn btn-xs' data-toggle='tooltip' data-placement='top' title='Display As HTML'><i class='fa fa-edit'></i></a>"
                                + "<a href='<?php echo $this->url('certificate', array('action'=>'displayAsXml'));?>" + data + "' class='btn btn-xs' data-toggle='tooltip' data-placement='top' title='Display As XML'><i class='fa fa-edit'></i></a>";
                    }
                }]
        });
    };
    
    fulldata();
    
    $('#newsDataTable tbody').on('click', '.chstatus', function () {
        var data = $(this).attr('rel');
        var el = this;
        $.post(
                "<?php echo $this->url('certificate', array('action'=>'chstatus'));?>" + data,
                function (data) {
                    if (data.done === 'true') {
                        //fulldata();
                        if ($(el).attr('title') === "Activate") {
                            $(el).attr('title', "Deactivate");
                            $(el).find(".fa.fa-close").attr('class', 'fa fa-check');
                        } else {
                            $(el).attr('title', "Activate");
                            $(el).find(".fa.fa-check").attr('class', 'fa fa-close');
                        }
                    } else {
                        $('#error').html('<h4>Error In Submit!</h4><p>' + data.message + '</p>');
                        $('#error').show(150);
                    }
                }
        );
    });
});
