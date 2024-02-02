@extends('layouts.app')

@section('content')
    @if (Session::has('success'))
        <div class="col-lg-5 p-5">
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> {{ Session::get('success') }}
            </div>
        </div>
    @elseif (Session::has('danger'))
        <div class="col-lg-5 p-5">
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="fa fa-check-circle-o mr-2" aria-hidden="true"></i> {{ Session::get('danger') }}
            </div>
        </div>
    @endif
    <div class="container">

        <div class="row">

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('TaskTracker.store') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Task Name:</label>
                                    <input type="text" name="task" class="form-control" required>
                                    <span class="text-danger name"></span>
                                    @error('task')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editexampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Task</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('TaskTracker.update') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="recipient-name" class="col-form-label">Task Name:</label>
                                    <input type="text" name="task" class="form-control task" required>
                                    <span class="text-danger name"></span>
                                    @error('task')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                    <input name="id" class="id" type="hidden" />
                                </div>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-10">
                <button type="button" class="btn btn-primary" style="margin-bottom: 30px;" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    Add Task
                </button>


                <div class="row">
                    <form action="{{ route('home') }}" method="GET">
                        <div class="col-md-8" style="display: flex;justify-content:center;">
                            <div class="mb-3">
                                <label for="recipient-name" class="col-form-label">FormDate:</label>
                                <input type="date" name="formdate" value="{{ $formdate }}" class="form-control" required>
                            </div>
                            <div class="mb-3" style="margin-left: 30px;">
                                <label for="recipient-name" class="col-form-label">ToDate:</label>
                                <input type="date" name="todate" value="{{ $todate }}" class="form-control">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-secondary"
                                    style="margin-top: 35px; margin-left:30px;">Load</button>
                            </div>
                        </div>
                    </form>

                </div>


                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Task Name</th>
                            <th>Create Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>



                    <tbody>

                        @foreach ($creator_task as $key => $item)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->task }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary edit" value="{{ $item->id }}"
                                        data-bs-toggle="modal" data-bs-target="#editexampleModal">
                                        Edit
                                    </button>

                                    <a class="btn btn-danger deletE btn-xs"
                                        href="{{ route('TaskTracker.destroy', ['id' => $item->id]) }}"
                                        onclick="return confirm('Are You Sure You Want To Delete ??')">

                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#example').dataTable();
        });
    </script>
    <script>
        $(document).ready(function() {

            $('.edit').on('click', function() {
                var id = $(this).val();

                $.ajax({
                    type: "GET",
                    url: "{{ route('TaskTracker.edit') }}",
                    data: {
                        id: id
                    },
                    success: function(data) {
                        $('.id').val(data[0]['id']);
                        $('.task').val(data[0]['task']);

                    }
                });
            });
        });
    </script>
@endsection
