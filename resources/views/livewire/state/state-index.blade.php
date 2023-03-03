<div>
    <div class="card">
        <div class="card-body">
            <!-- Grid row -->
            <div class="row">
                <!-- Grid column -->
                <div class="col-md-12">
                    <h2 class="py-3 text-center font-bold font-up blue-text">States</h2>
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
                    </div>
                </div>
                <!-- Grid column -->
                @if (session()->has('state-message'))
                    <div class="alert alert-success">
                        {{ session('state-message') }}
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
                        <th class="th-lg"><a href="">State Name</a></th>
                        <th class="th-lg"><a href="">Country Name</a></th>
                        <th class="th-lg"><a href="">Created time</a></th>
                        <th class="th-lg"><a href="">Updated time</a></th>
                        <th class="th-lg"><a href="">Actions</a></th>
                    </tr>
                </thead>
                <!--Table head-->
                <!--Table body-->
                <tbody>
                    @forelse ($states as $state)
                        <tr>
                            <th scope="row">{{ $state->id }}</th>
                            <td>{{ $state->name }}</td>
                            <td>{{ $state->country->name }}</td>
                            <td>{{ $state->created_at }}</td>
                            <td>{{ $state->updated_at }}</td>
                            <td>
                                <!-- Call to action buttons -->
                                <ul class="list-inline m-0">
                                    <li class="list-inline-item">
                                        <button wire:click="editShowModal({{ $state->id }})"
                                            class="btn btn-success btn-sm rounded-0" type="button"
                                            data-toggle="tooltip" data-placement="top" title="Edit"><i
                                                class="fa fa-edit"></i></button>
                                    </li>
                                    <li class="list-inline-item">
                                        <button wire:click="deleteState({{ $state->id }})"
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
               {{ $states->links('pagination::bootstrap-5') }}
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit State</h1>
                    @else
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create new State</h1>
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

                        <!-- code input -->
                        <div class="form-outline mb-4">
                            <select wire:model.defer="country_id" class="form-select form-select-sm" aria-label=".form-select-sm example">
                                <option selected>Open this select menu</option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                              </select>
                            <label class="form-label" for="form1Example1">Country</label>
                        </div>
                        @error('country_code')
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

