<div>
    <div class="card">
        <div class="card-body">
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-12">
                    <h2 class="py-3 text-center font-bold font-up blue-text">Employees</h2>
                </div>
                <!-- Grid column -->
            </div>
            <!-- Grid row -->

            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-12" style="display: flex; justify-content:space-between">
                    {{-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Create modal
                    </button> --}}
                    <button class="btn btn-primary btn-sm rounded-0" type="button" data-bs-toggle="modal"
                        data-bs-target="#exampleModal" data-placement="top" title="Add"><i
                            class="fa fa-table"></i></button>
                    <!-- Search form -->
                    <div style="display: flex">

                        <i class="fas fa-search" aria-hidden="true"></i>
                        <div class="spinner-border text-primary" role="status" wire:loading>
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <input wire:model="search" class="form-control form-control-sm ml-3 w-75" type="text"
                            placeholder="Search" aria-label="Search">
                            &nbsp;
                        <!--Dept Filter Option -->
                        <div class="form-outline mb-2">
                            <select wire:model="filterDepartment" class="form-select form-select-sm"
                                aria-label=".form-select-sm example">
                                <option selected>All/Filter by Department</option>
                                @foreach (\App\Models\Department::all() as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            {{-- <label class="form-label" for="form1Example1">Department</label> --}}
                        </div>
                    </div>
                </div>
                <!-- Grid column -->
                @if (session()->has('employee-message'))
                    <div class="alert alert-success">
                        {{ session('employee-message') }}
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
                        <th class="th-lg"><a href="">Employee Name</a></th>
                        <th class="th-lg"><a href="">Country</a></th>
                        <th class="th-lg"><a href="">State</a></th>
                        <th class="th-lg"><a href="">City</a></th>
                        <th class="th-lg"><a href="">Department</a></th>
                        <th class="th-lg"><a href="">Date Hired</a></th>
                        <th class="th-lg"><a href="">Created time</a></th>
                        <th class="th-lg"><a href="">Updated time</a></th>
                        <th class="th-lg"><a href="">Actions</a></th>
                    </tr>
                </thead>
                <!--Table head-->
                <!--Table body-->
                <tbody>
                    @forelse ($employees as $employee)
                        <tr>
                            <th scope="row">{{ $employee->id }}</th>
                            <td>{{ $employee->first_name }} {{ $employee->last_name }}</td>
                            <td>{{ $employee->country->name }}</td>
                            <td>{{ $employee->state->name }}</td>
                            <td>{{ $employee->city->name }}</td>
                            <td>{{ $employee->department->name }}</td>
                            <td>{{ $employee->date_hired }}</td>
                            <td>{{ $employee->created_at }}</td>
                            <td>{{ $employee->updated_at }}</td>
                            <td>
                                <!-- Call to action buttons -->
                                <ul class="list-inline m-0">
                                    <li class="list-inline-item">
                                        <button wire:click="edit({{ $employee->id }})"
                                            class="btn btn-success btn-sm rounded-0" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></button>
                                    </li>
                                    <li class="list-inline-item">
                                        <button wire:click="destroy({{ $employee->id }})"
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
                {{ $employees->links('pagination::bootstrap-5') }}
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Employee</h1>
                    @else
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create new Employee</h1>
                    @endif
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <!--First name input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form1Example1" class="form-control"
                                wire:model.defer="first_name" />
                            <label class="form-label" for="form1Example1">First Name</label>
                        </div>
                        @error('first_name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                        <!--Last name input -->
                        <div class="form-outline mb-4">
                            <input type="text" id="form1Example1" class="form-control"
                                wire:model.defer="last_name" />
                            <label class="form-label" for="form1Example1">Last Name</label>
                        </div>
                        @error('last_name')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror


                        <!--Dept Option input -->
                        <div class="form-outline mb-4">
                            <select wire:model.defer="department_id" class="form-select form-select-sm"
                                aria-label=".form-select-sm example">
                                <option selected>Open this select menu</option>
                                @foreach (\App\Models\Department::all() as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label" for="form1Example1">Department</label>
                        </div>
                        @error('department_id')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                        <!--Country Option input -->
                        <div class="form-outline mb-4">
                            <select wire:model.defer="country_id" class="form-select form-select-sm"
                                aria-label=".form-select-sm example">
                                <option selected>Open this select menu</option>
                                @foreach (\App\Models\Country::all() as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label" for="form1Example1">Country</label>
                        </div>
                        @error('country_id')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                        <!--State Option input -->
                        <div class="form-outline mb-4">
                            <select wire:model.defer="state_id" class="form-select form-select-sm"
                                aria-label=".form-select-sm example">
                                <option selected>Open this select menu</option>
                                @foreach (\App\Models\State::all() as $state)
                                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label" for="form1Example1">State</label>
                        </div>
                        @error('state_id')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                        <!--City Option input -->
                        <div class="form-outline mb-4">
                            <select wire:model.defer="city_id" class="form-select form-select-sm"
                                aria-label=".form-select-sm example">
                                <option selected>Open this select menu</option>
                                @foreach (\App\Models\City::all() as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                            <label class="form-label" for="form1Example1">City</label>
                        </div>
                        @error('city_id')
                            <div class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror

                        <!--Date hired input -->
                        <div class="form-outline mb-4">
                            <input type="date" id="form1Example1" class="form-control"
                                wire:model.defer="date_hired" />
                            <label class="form-label" for="form1Example1">Date of Hire</label>
                        </div>
                        @error('date_hired')
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
