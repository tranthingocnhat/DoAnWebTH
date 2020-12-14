@extends('admin.layouts.masteradmin')
@section('css')
    <style>
        .card .card-body {
            padding: unset !important;
        }

    </style>
@endsection
@section('noidung')
    <div class="content-wrapper">
        <div class="card" style="padding: 2% !important">
            <div class="card-body">
                <h4 class="card-title">Danh Sách Tiện Nghi</h4>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="modal fade" id="exampleModal-4" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel-4" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel-4">Thêm Tiện Nghi mới</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="">
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="tenloai" class="col-form-label">Tên Tiện Nghi:</label>
                                                    <textarea class="form-control" name="tenloai" id="tenloai"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" name="btnthem" id="btnthem"
                                                    class="btn btn-success">Thêm</button>
                                                <button type="button" class="btn btn-light"
                                                    data-dismiss="modal">Hủy</button>
                                            </div>
                                        </form>


                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal-4"
                                data-whatever="@mdo">+ Tạo mới Tiện Nghi</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table id="order-listing" class="table text-center">
                                <thead>
                                    <tr>
                                        <th>ID Tiện Nghi</th>
                                        <th>Tên Tiện Nghi</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($tiennghis as $tiennghi)
                                        <tr>
                                            <td>{{ $tiennghi->id }}</td>
                                            <td>{{ $tiennghi->ten_tiennghi }}</td>
                                            <td>
                                                <div>
                                                    <button type="button" class="btn btn-outline-danger"
                                                        data-id="{{ $tiennghi->id }}"
                                                        onclick="deleteByID($(this).data('id'));">Xóa</button>
                                                    <button type="button" id="btnSua" class="btn btn-outline-danger"
                                                        data-toggle="modal" data-target="#sua" data-whatever="@mdo"
                                                        data-id="{{ $tiennghi->id }}"
                                                        data-ten="{{ $tiennghi->ten_tiennghi }}">Sửa</button>
                                                </div>
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- partial -->
        </div>
        <!-- partial -->
    </div>
    <!-- MODAL EDIT--->
    <div class="col-md-4 stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="modal fade" id="sua" tabindex="-1" role="dialog" aria-labelledby="id_title_edit"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="id_title_edit">Sửa Tiện Nghi</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label for="txt_Edit" class="col-form-label">Tên Tiện Nghi:</label>
                                        <textarea class="form-control" id="txt_Edit"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-success" id="confirm_Edit">Sửa</button>
                                <button type="button" class="btn btn-light" data-dismiss="modal">Hủy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MODAL EDIT--->
@endsection

@section('scripts')
    <!-- Custom js for this page-->
    <!-- DELETE -->
    <script>
        function deleteByID(e) {
            var id = e;
            Swal.fire({
                title: 'Xác nhận?<br>',
                text: "Bạn có chắn chắn muốn xóa tiện nghi có id = " + id + " ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Có?',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        }
                    });
                    $.ajax({
                        type: "DELETE",
                        url: "tiennghi/" + id,
                        dataType: 'json',
                        data: {
                            id: id
                        },
                        success: function(data) {
                            Swal.fire('Thành Công!',
                                'Bạn đã xóa thành công!<br>Đợi 2s để tự động cập nhật.',
                                'success');
                            setTimeout(location.reload.bind(location), 1500);
                        },
                        error: function() {
                            Swal.fire('Thất Bại!', 'Xảy ra sự cố, Vui lòng liên hệ QTV Website!',
                                'error');
                        }
                    })
                }
            });
        }

    </script>
    <!-- ADD -->
    <script>
        $(document).ready(function() {
            $("#btnthem").click(function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ route('them_admin_tiennghi') }}",
                    dataType: 'json',
                    data: {
                        'ten_tiennghi': $('#tenloai').val(),
                    },
                    success: function(msg) {
                        Swal.fire('Thành Công!',
                            'Công việc hoàn thành!<br>Đợi 2s để tự động cập nhật.',
                            'success');
                        $('#exampleModal-4').modal('hide');
                        setTimeout(location.reload.bind(location), 1500);
                    },
                    error: function(data) {
                        Swal.fire('Thất Bại!', 'Công việc thất bại!', 'error');
                        $('#exampleModal-4').modal('hide');
                    },
                })
            })
        })

    </script>
    <!-- EDIT-->
    <script>
        $(document).on("click", "#btnSua", function() {
            var myID = $(this).data('id');
            var myName = $(this).data('ten');

            $(".modal-body #txt_Edit").val(myName);
            $("#confirm_Edit").click(function(e) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                });
                $.ajax({
                    type: "PUT",
                    url: "tiennghi/" + myID,
                    dataType: 'json',
                    data: {
                        'ten_tiennghi': $('#txt_Edit').val(),
                    },
                    success: function(msg) {
                        Swal.fire('Thành Công!',
                            'Công việc hoàn thành!<br>Đợi 2s để tự động cập nhật.',
                            'success');
                        $('#exampleModal-4').modal('hide');
                        setTimeout(location.reload.bind(location), 1500);

                    },
                    error: function(data) {
                        Swal.fire('Thất Bại!', 'Công việc thất bại!', 'error');
                        $('#exampleModal-4').modal('hide');
                    },
                })
            })
        });

    </script>
@endsection
