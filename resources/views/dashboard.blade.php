@extends('common.layout')

@section('title', 'Teacher App')

@section('main')

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Student Marks</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="" action="{{ route('student.add.marks') }}" method="post">
                    @csrf
                
                    <div class="form-grp">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}">
                    </div>
                    <div class="form-grp">
                        <label for="subject">Subject</label>
                        <select class="input-box" name="subject" id="subject">
                            <option disabled selected></option>
                            <option value="Physics" {{ old('subject') == 'Physics' ? 'selected' : '' }}>Physics</option>
                            <option value="Chemistry" {{ old('subject') == 'Chemistry' ? 'selected' : '' }}>Chemistry</option>
                            <option value="Maths" {{ old('subject') == 'Maths' ? 'selected' : '' }}>Maths</option>
                            <option value="Biology" {{ old('subject') == 'Biology' ? 'selected' : '' }}>Biology</option>
                            <option value="Computer" {{ old('subject') == 'Computer' ? 'selected' : '' }}>Computer</option>
                            <option value="English" {{ old('subject') == 'English' ? 'selected' : '' }}>English</option>
                        </select>
                    </div>
                    <div class="form-grp">
                        <label for="marks">Marks</label>
                        <input type="number" name="marks" id="marks" min="0" max="100" value="{{ old('marks') }}">
                    </div>
                
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" style="margin-left: 5px;">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="main-wrapper">
    <div class="table-wrapper">
        <table id="list" class="display">
            <thead>
                <tr>
                    <th width: 100px;>#</th>
                    <th>Name</th>
                    <th>Subject</th>
                    <th>Marks</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @php $i=1; @endphp
                @foreach ($studentList as $student)
                <tr>
                    <td>{{$i++}}</td>
                    <td>{{$student->name}}</td>
                    <td>{{$student->subject}}</td>
                    <td>{{$student->marks}}</td>
                    <td>
                        <span class="material-symbols-outlined text-primary" data-bs-toggle="modal" data-bs-target="#editModal{{$student->id}}" role="button" title="Edit">edit</span>

                        <span class="material-symbols-outlined text-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{$student->id}}" role="button" title="Delete">delete</span>
                    </td>
                </tr>

                <!-- edit modal -->
                <div class="modal fade" id="editModal{{$student->id}}" tabindex="-1" aria-labelledby="editModal{{$student->id}}Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editModal{{$student->id}}Label">Edit Student Marks</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="form" id="" action="{{ route('student.edit.marks') }}" method="post">
                                    @csrf
                                
                                    <input type="hidden" name="id" value="{{ $student->id }}">
                                    <div class="form-grp">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" value="{{$student->name}}">
                                    </div>
                                    <div class="form-grp">
                                        <label for="subject">Subject</label>
                                        <select class="input-box" name="subject" id="subject">
                                            <option value="Physics" {{ $student->subject == 'Physics' ? 'selected' : '' }}>Physics</option>
                                            <option value="Chemistry" {{ $student->subject == 'Chemistry' ? 'selected' : '' }}>Chemistry</option>
                                            <option value="Maths" {{ $student->subject == 'Maths' ? 'selected' : '' }}>Maths</option>
                                            <option value="Biology" {{ $student->subject == 'Biology' ? 'selected' : '' }}>Biology</option>
                                            <option value="Computer" {{ $student->subject == 'Computer' ? 'selected' : '' }}>Computer</option>
                                            <option value="English" {{ $student->subject == 'English' ? 'selected' : '' }}>English</option>
                                        </select>
                                    </div>
                                    <div class="form-grp">
                                        <label for="marks">Marks</label>
                                        <input type="number" name="marks" id="marks" min="0" max="100" value="{{ $student->marks }}">
                                    </div>
                                
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary" style="margin-left: 5px;">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                

                <!-- delete modal -->
                <div class="modal fade" id="deleteModal{{$student->id}}" tabindex="-1" aria-labelledby="deleteModal{{$student->id}}Label" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="deleteModal{{$student->id}}Label">Delete Student Marks</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to delete this student marks?</p>
                                <form class="form" id="" action="{{ route('student.delete.marks') }}" method="post">
                                    @csrf
                                
                                    <input type="hidden" name="id" value="{{ $student->id }}">
                                
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger" style="margin-left: 5px;">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <button type="button" class="btn btn-secondary add-marks" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Marks</button>

</div>
@endsection

@section('script')
<script>
    dataTable = $("#list").DataTable({
        /* Disable initial sort */
        "aaSorting": [],
        responsive: false,
        scrollX: true,
        "columnDefs": [{
                "orderable": false,
                "targets": [4],
            },
            {
                "orderable": true,
                "targets": [0, 1, 2, 3],
            }
        ]
    });
</script>
@endsection