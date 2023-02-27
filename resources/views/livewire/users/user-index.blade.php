<div class="card">
    <div class="card-body">
        <!-- Grid row -->
        <div class="row">
            <!-- Grid column -->
            <div class="col-md-12">
                <h2 class="py-3 text-center font-bold font-up blue-text">Users</h2>
            </div>
            <!-- Grid column -->
        </div>
        <!-- Grid row -->

        <!-- Grid row -->
        <div class="row">
            <!-- Grid column -->
            <div class="col-md-12" style="display: flex; justify-content:space-between">
                <button type="submit" class="btn btn-primary">Add new</button>
                <!-- Search form -->
                <div style="display: flex">
                    <i class="fas fa-search" aria-hidden="true"></i>
                    <div class="spinner-border text-primary" role="status" wire:loading>
                        <span class="visually-hidden">Loading...</span>
                      </div>                      
                    <input wire:model="search" class="form-control form-control-sm ml-3 w-75" type="text" placeholder="Search"
                        aria-label="Search">
                </div>  
            </div>
            <!-- Grid column -->
        </div>
        <!-- Grid row -->
        <!--Table-->
        <table class="table table-hover table-responsive mb-0" wire:loading.remove>
            <!--Table head-->
            <thead>
                <tr>
                    <th scope="row">#</th>
                    <th class="th-lg"><a href="">First Name</a></th>
                    <th class="th-lg"><a href="">Last Name</a></th>
                    <th class="th-lg"><a href="">Username</a></th>
                    <th class="th-lg"><a href="">Email</a></th>
                    <th class="th-lg"><a href="">Username</a></th>
                    <th class="th-lg"><a href="">Actions</a></th>
                </tr>
            </thead>
            <!--Table head-->
            <!--Table body-->
            <tbody>
                @forelse ($users as $user)
                <tr>
                    <th scope="row">{{ $user->id }}</th>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>
                        <!-- Call to action buttons -->
                        <ul class="list-inline m-0">
                            <li class="list-inline-item">
                                <button class="btn btn-primary btn-sm rounded-0" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Add"><i
                                        class="fa fa-table"></i></button>
                            </li>
                            <li class="list-inline-item">
                                <button class="btn btn-success btn-sm rounded-0" type="button"
                                    data-toggle="tooltip" data-placement="top" title="Edit"><i
                                        class="fa fa-edit"></i></button>
                            </li>
                            <li class="list-inline-item">
                                <button class="btn btn-danger btn-sm rounded-0" type="button" data-toggle="tooltip"
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
            <nav class="my-4 pt-2">
                <ul class="pagination pagination-circle pg-blue mb-0">
                    <!--First-->
                    <li class="page-item disabled clearfix d-none d-md-block"><a class="page-link">First</a></li>
                    <!--Arrow left-->
                    <li class="page-item disabled">
                        <a class="page-link" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <!--Numbers-->
                    <li class="page-item active"><a class="page-link">1</a></li>
                    <li class="page-item"><a class="page-link">2</a></li>
                    <li class="page-item"><a class="page-link">3</a></li>
                    <li class="page-item"><a class="page-link">4</a></li>
                    <li class="page-item"><a class="page-link">5</a></li>
                    <!--Arrow right-->
                    <li class="page-item">
                        <a class="page-link" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                    <!--First-->
                    <li class="page-item clearfix d-none d-md-block"><a class="page-link">Last</a></li>
                </ul>
            </nav>
            <!--/Pagination -->
        </div>
        <!--Bottom Table UI-->
    </div>
</div>
