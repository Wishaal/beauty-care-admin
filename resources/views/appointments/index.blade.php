@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop
@section('content')
    <!-- Content Header (Page header) -->
    @include('flash-message')
    <!-- /.content-header -->
    <div class="content">
        <div class="clearfix"></div>
        <div class="clearfix"></div>
        <div class="card">
            <div class="card-header">

            </div>
            <div class="card-body">
                <div id='calendar'></div>

                <div class="clearfix"></div>
            </div>
        </div>
        <button style="display: none" type="button" id="btnModal"
                class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open
            Modal
        </button>
        <!-- Modal -->
        <div id="myModal" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add/ Change Appointment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <input type="hidden" id="soort" value="false">
                            <input type="hidden" id="update_id" value="false">
                            <div class="form-group">
                                <label for="txtTitle">Client:</label>
                                <select name="txtClient" class="clientselect select2 form-control"
                                          id="txtClient"></select>
                            </div>
                            <div class="form-group">
                                <label for="txtTitle">Description:</label>
                                <textarea type="text" name="txtTitle" class="form-control"
                                          id="txtTitle"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="txtTitle">Phonenumber:</label>
                                <input type="text" name="txtPhone" class="form-control"
                                          id="txtPhone" value="597">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="btnBook" class="btn btn-default">Save</button>
                        <button type="button" class="btn btn-danger" disabled id="deleteEvent" data-id>Delete</button>
                    </div>
                </div>
            </div>
            </div>
    </div>
    @include('layouts.media_modal')
@endsection
@section('js')
    <script>
        $('#txtClient').on('change', function(){
            var phone = $('#txtClient').find('option:selected').data('number');
            if(phone){
                $('#txtPhone').val(phone);
            }

        });
        $(document).ready(function () {

            var SITEURL = "{{url('/')}}";

            $('#myModal').on('hidden.bs.modal', function () {
                $("#soort").val('false');
                $("#update_id").val('');
                $("#txtTitle").val('');
                $('#deleteEvent').prop("disabled", true);
                $('#calendar').fullCalendar('refetchEvents');
                $('#txtClient').val('').trigger('change');
                $('#txtPhone').val('597');
            });

            function getClients(){
                $.ajax({
                    url: SITEURL + "/appointments/clients",
                    type: "GET",
                    dataType: 'json',
                    success: function (dataSet) {
                        $.each(dataSet, function(i, data){
                            var option = $("<option>");
                            option.val(data.id);
                            option.text(data.name);
                            option.attr("data-number", data.number);
                            $("#txtClient").append(option);
                        });
                    }
                });
            }


            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var calendar = $('#calendar').fullCalendar({
                eventRender: function (event, element, view) {
                    if (event.color) {
                        element.css('background-color', event.color)
                    }
                },
                navLinks: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                allDaySlot: false,
                defaultView: 'agendaWeek',
                events: SITEURL + "/appointments",
                slotDuration: '00:15:00',
                slotEventOverlap:false,
                editable: true,
                minTime: '08:00:00',
                maxTime: '19:00:00',
                selectable: true,
                selectHelper: true,
                select: function (start, end, allDay) {
                    getClients();
                    var start = moment(start).format('YYYY-MM-DD HH:mm:ss');
                    var end = moment(end).format('YYYY-MM-DD HH:mm:ss');

                    $('.clientselect').select2(
                        { width: '100%', tags: true}
                    );

                    sessionStorage.setItem('start_date', start);
                    sessionStorage.setItem('end_date', end);
                    $('#myModal').modal();
                    calendar.fullCalendar('unselect');
                },
                eventResize: function (event) {
                    var start = moment(event.start).format('YYYY-MM-DD HH:mm:ss');
                    var end = moment(event.end).format('YYYY-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;
                    $.ajax({
                        url: SITEURL + '/appointments/update',
                        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                        type: "POST",
                        success: function () {
                            $('#calendar').fullCalendar('refetchEvents');
                        }
                    })
                },
                eventDrop: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: SITEURL + '/appointments/update',
                        data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                        type: "POST",
                        success: function (response) {
                            displayMessage("Updated Successfully");
                        }
                    });
                },
                eventClick: function (event) {
                    getClients();
                    var id = event.id;

                    $.ajax({
                        url: SITEURL + "/appointments/show",
                        type: "GET",
                        dataType: 'json',
                        data: {id: id},
                        success: function (data) {
                            $("#type_id").val(data.type_id).change();
                            $('#txtTitle').val(data[0].title);
                            $('#update_id').val(data[0].id);
                            $('#txtClient').val(data[0].client_id).trigger('change');
                            $('#soort').val('update');
                            $('#myModal').modal();
                        }
                    });

                    $('#deleteEvent').attr('data-id', id);

                    $('#deleteEvent').prop("disabled", false);

                    $("#deleteEvent").click( function (e) {

                        let deleteId = $(this).attr("data-id");
                        e.stopImmediatePropagation();
                        if (confirm("Are you sure you want to remove it?")) {
                            $.ajax({
                                url: SITEURL + "/appointments/delete",
                                type: "POST",
                                data: {id: deleteId},
                                // success: function (res){
                                //     console.log(res)
                                // }
                            });

                            //close model
                            $('#myModal').modal('hide');

                        }
                    });
                }
            });

            $("#btnBook").click(function () {
                var soort = $("#soort").val();
                var update_id = $("#update_id").val();
                var txtTitle = $("#txtTitle").val();
                var txtPhone = $("#txtPhone").val();
                var txtClient = $( "#txtClient option:selected" ).val();
                if(soort == 'update'){
                    $.ajax({
                        url: SITEURL + "/appointments/store",
                        type: "POST",
                        data: {
                            title: txtTitle,
                            type_id: txtType,
                            id: update_id
                        },
                        success: function (data) {
                            $('#myModal').modal('hide');
                        }
                    })
                }
                if (soort == 'false') {
                    $.ajax({
                        url: SITEURL + "/appointments/create",
                        type: "POST",
                        data: {
                            title: txtTitle,
                            client: txtClient,
                            number: txtPhone,
                            start: sessionStorage.getItem('start_date'),
                            end: sessionStorage.getItem('end_date')
                        },
                        success: function (data) {
                            sessionStorage.setItem('start_date', "");
                            sessionStorage.setItem('end_date', "");
                            $('#myModal').modal('hide');

                        }
                    })
                }
            });
        });
        function displayMessage(message) {
            $(".response").html("<div class='success'>"+message+"</div>");
            setInterval(function() { $(".success").fadeOut(); }, 1000);
        }
    </script>
@stop
