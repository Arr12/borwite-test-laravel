@extends('app.layouts.app')

@push('after-script')
<script>
    function DataTravel() {
        $.ajax({
            type: 'GET',
            url: "{{ route('api.travel.create')}}",
            success: function(json) {
                $('#FormTabel').html(
                    "<table id='Tabel' class='table table-bordered table-striped table-hover mt-5'></table>"
                );
                let columns = [
                    {title : "No."},
                    {title: "Type"},
                    {title: "Request By"},
                    {title: "Destination"},
                    {title: "Reason to Travel"},
                    {title: "Letter Date"},
                    {title: "Start & End Date"},
                    {title: "Approval Status"},
                    {title: "Opsi"}
                ]
                let data = [];
                json?.data?.data?.map((v, i) => {
                    data.push([
                        i + 1,
                        v.type,
                        v.user.name,
                        v.destination,
                        v.reason_to_travel,
                        v.letter_date,
                        v.date_end + '-' + v.date_start,
                        v.approval_status,
                        `
                        <button class='btn btn-danger m-2' type='button' id='btn_delete' data-id='${v.id}'><i class='bi bi-trash'></i></button>
                        <button class='btn btn-primary m-2' type='button' id='btn_edit'
                            data-id='${v.id}'
                            data-type='${v.type}'
                            data-letter_date='${v.letter_date}'
                            data-destination='${v.destination}'
                            data-reason_to_travel='${v.reason_to_travel}'
                            data-date_start='${v.date_start}'
                            data-date_end='${v.date_end}'
                            data-approval_status='${v.approval_status}'
                            data-cash_advance_status='${v.cash_advance_status}'
                            data-user_id='${v.user.name}'><i class='bi bi-pencil'></i>
                        </button>
                        `
                    ])
                })

                $('#Tabel').DataTable({
                    columns: columns,
                    data: data
                });
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    $(document).ready(function() {
        DataTravel();
        $('#form-travel').submit(function(e) {
            $(this).attr('disabled', 'disabled');
            e.preventDefault(); // Prevent the default form submission

            // Get form data
            var formData = $(this).serializeArray();

            Swal.fire({
                title: "Do you want to save the changes?",
                showCancelButton: true,
                confirmButtonText: "Save",
            }).then((result) => {
                if (result.isConfirmed) {
                    let url = "{{ route('api.travel.store')}}";
                    if($('#modal_type').val() == 'edit'){
                        let id = $('#travel_id').val();
                        url = "{{ route('api.travel.update', ['id' => ':id'])}}";
                        url = url.replace(':id', id);
                    }
                    console.log($('#modal_type').val());
                    $.ajax({
                        url: url,
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify({
                            "_token": "{{ csrf_token() }}",
                            "type": formData[0].value,
                            "letter_date": formData[3].value,
                            "destination": formData[5].value,
                            "reason_to_travel": formData[6].value,
                            "start_end_date": formData[4].value,
                            "approval_status": formData[2].value,
                            "cash_advance_status": false,
                            "user_id": "{{ auth()->user()->id }}"
                        }),
                        success: function(json) {
                            $('#save-form-travel').removeAttr('disabled', 'disabled');
                            $("#modalFormTravel").modal('hide');
                            Swal.fire({
                                position: "top-end",
                                icon: "success",
                                title: "Your work has been saved",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            DataTravel();
                        },
                        error: function() {
                            $('#save-form-travel').removeAttr('disabled', 'disabled');
                        }
                    });
                }
            });
        });
        $(document).on('click', '#btn_edit', function () {
            $("#modalFormTravel").modal('show');
            $("#modal_type").val('edit');
            $('#travel_id').val($(this).attr('data-id'));
            $('#type').val($(this).attr('data-type'));
            $('#type').change();
            $('#letter_date').val($(this).attr('data-letter_date'));
            $('#destination').val($(this).attr('data-destination'));
            $('#reason').val($(this).attr('data-reason_to_travel'));
            $('#date_start').val($(this).attr('data-date_start'));
            $('#date_end').val($(this).attr('data-date_end'));
            $('#approval_status').val($(this).attr('data-approval_status'));
            $('#cash_advance_status').val($(this).attr('data-cash_advance_status'));
            $('#user_id').val($(this).attr('data-user_id'));
        });
        $(document).on('click', "#btn_add", function() {
            $("#modalFormTravel").modal('show');
            $("#modal_type").val('add');
            $('#type').val('');
            $('#type').change();
            $('#letter_date').val('');
            $('#destination').val('');
            $('#reason').val('');
            $('#date_start').val('');
            $('#date_end').val('');
            $('#approval_status').val('');
            $('#cash_advance_status').val('');
            $('#user_id').val('');
        });
        $(document).on('click', "#btn_delete", function() {
            let id = $(this).attr('data-id');
            var destroyUrl = "{{ route('api.travel.update', ['id' => ':id']) }}";
            destroyUrl = destroyUrl.replace(':id', id);
            Swal.fire({
                title: "Do you want to save the changes?",
                showCancelButton: true,
                confirmButtonText: "Save",
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: destroyUrl,
                        method: 'POST',
                        success: function(json) {
                            DataTravel();
                            Swal.fire("Saved!", "", "success");
                        },
                    });
                }
            });
        });
    });
</script>
@endpush
@section('content')
<div class="px-5">
    <h2>Official Travel</h2>
    <div class="mt-3 text-right">
        <button class="btn btn-primary flex flex-row align-items-center" type="button" id="btn_add">
            <i class="bi bi-plus-lg"></i>
            <span>Add</span>
        </button>
    </div>
    <div class="teble-responsive mt-3" id="FormTabel">
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Office</th>
                    <th>Age</th>
                    <th>Start date</th>
                    <th>Salary</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Tiger Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>61</td>
                    <td>2011-04-25</td>
                    <td>$320,800</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="modalFormTravel" tabindex="-1" role="dialog" aria-labelledby="modalFormTravelTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg w-modal-auto-xl" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modalFormTravelTitle">Add Official Travel</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form id="form-travel">
                    <input type="hidden" id="modal_type" value="add">
                    <input type="hidden" id="travel_id" value="">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="type">Travel Type *</label>
                                <select class="js-example-basic-single" id="type" name="type" required>
                                    <option value="">Select Travel Type</option>
                                    <option value="Perjalanan Dinas">Perjalanan Dinas</option>
                                    <option value="Mutasi Career">Mutasi Career</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="request">Request By</label>
                                <input type="text" class="form-control" id="request" name="request" placeholder="Request By" value="{{ auth()->user()->name }}" readonly />
                            </div>
                            <div class="form-group">
                                <label for="request">Approval Status</label>
                                <input type="text" class="form-control" id="request" name="approval-status" placeholder="" value="NEW" readonly />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="letter-date">Letter Date *</label>
                                <input class="form-control" type="date" id="letter-date" name="letter-date" value="{{ date('Y-m-d') }}" readonly />
                            </div>
                            <div class="form-group">
                                <label for="start-end-date">Start & End Date *</label>
                                <input class="form-control daterange" type="text" id="start-end-date" name="start-end-date" value="10/24/1984" required />
                            </div>
                            <div class="form-group">
                                <label for="destination">Destination *</label>
                                <input type="text" class="form-control" id="destination" name="destination" placeholder="Destionation" required />
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label for="reason">Reason to Travel *</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="save-form-travel" class="btn btn-primary">Save & Submit</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
