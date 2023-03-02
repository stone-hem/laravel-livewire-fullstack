<div>
    <div class="card">
        <div class="card-body">
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-12">
                    <h2 class="py-3 text-center font-bold font-up blue-text">Departments</h2>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->

            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-12" style="display: flex; justify-content:space-between">
                    <button class="btn btn-primary btn-sm rounded-0" type="button" data-bs-toggle="modal"
                        data-bs-target="#exampleModal" data-placement="top" title="Add"><i
                            class="fa fa-table"></i></button>
                    <!-- Search form -->
                    <div style="display: flex">
                        <i class="fas fa-search" aria-hidden="true"></i>
                        <div class="spinner-border text-primary" role="status" wire:loading>
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <input wire:model.lazy="search" class="form-control form-control-sm ml-3 w-75" type="text"
                            placeholder="Search" aria-label="Search">
                    </div>
                </div>
                <!-- Grid column -->
                @if (session()->has('department-message'))
                    <div class="alert alert-success">
                        {{ session('department-message') }}
                    </div>
                @endif
            </div>
            <!-- Grid row -->
            <!--Table-->
            <table class="table table-hover table-responsive mb-0" wire:loading.remove>
                <!--Table head-->
                <thead>
                    <tr>
                        <th scope="row">#</th>
                        <th class="th-lg"><a href="">Department Name</a></th>
                        <th class="th-lg"><a href="">Created time</a></th>
                        <th class="th-lg"><a href="">Updated time</a></th>
                        <th class="th-lg"><a href="">Actions</a></th>
                    </tr>
                </thead>
                <!--Table head-->
                <!--Table body-->
                <tbody>
                    @forelse ($departments as $department)
                        <tr>
                            <th scope="row">{{ $department->id }}</th>
                            <td>{{ $department->name }}</td>
                            <td>{{ $department->created_at }}</td>
                            <td>{{ $department->updated_at }}</td>
                            <td>
                                <!-- Call to action buttons -->
                                <ul class="list-inline m-0">
                                    <li class="list-inline-item">
                                        <button wire:click="editShowModal({{ $department->id }})"
                                            class="btn btn-success btn-sm rounded-0" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></button>
                                    </li>
                                    <li class="list-inline-item">
                                        <button wire:click="deleteDepartment({{ $department->id }})"
                                            class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip"
                                            data-placement="top" title="Delete"><i class="fa fa-trash"></i></button>
                                    </li>
                                </ul>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th>No responses...</th>
                        </tr>
                    @endforelse
                </tbody>
                <!--Table body-->
            </table>
            <!--Bottom Table UI-->
            <div class="d-flex justify-content-center">
                <!--Pagination -->
               {{ $departments->links('pagination::bootstrap-5') }}
                <!--/Pagination -->
            </div>
            <!--Bottom Table UI-->
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    @if ($editMode)
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Department</h1>
                    @else
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create new Department</h1>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <!-- name input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form1Example1" class="form-control"
                                wire:model.defer="name" />
                            <label class="form-label" for="form1Example1">name</label>
                        </div>
                        @error('name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                    @if ($editMode)
                        <button type="button" class="btn btn-primary" wire:click="update()">Edit</button>
                    @else
                        <button type="button" class="btn btn-primary" wire:click="store()">Save</button>
                    @endif
                    <div class="spinner-border text-primary" role="status" wire:loading>
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


