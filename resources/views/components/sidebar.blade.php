<div class="p-4 bg-white shadow-sm position-fixed top-0 start-0 d-flex flex-column justify-content-between overflow-auto"
    style="width: 320px; min-width: 300px; height: 100vh; z-index: 1030;">
    <div>
        <h5 class="fw-bold mb-4">Menu</h5>

        <!-- COMBINED SEARCH & FILTER FORM -->
        <form method="GET">

            {{-- SEARCH BAR --}}
            <div class="position-relative mb-3">
                <input type="text" name="search" id="search" class="form-control ps-5" placeholder="Search"
                    value="{{ request('search') }}">
                <span class="position-absolute start-0 ms-3 text-muted" style="top: 44%; transform: translateY(-50%);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                </span>
            </div>

            {{-- FILTER: SORT --}}
            <div class="mb-3">
                <select name="sort_by" id="sort_by" class="form-select">
                    <option value="">Sort By</option>
                    <option value="due_date" {{ request('sort_by') == 'due_date' ? 'selected' : '' }}>Deadline
                        (Terdekat)</option>
                    <option value="status" {{ request('sort_by') == 'status' ? 'selected' : '' }}>Status</option>
                </select>
            </div>

            {{-- FILTER: STATUS --}}
            <div class="mb-3">
                <select name="status" id="status" class="form-select">
                    <option value="">Filter Status</option>
                    <option value="penting_sekali" {{ request('status') == 'penting_sekali' ? 'selected' : '' }}>Penting
                        Sekali</option>
                    <option value="menengah" {{ request('status') == 'menengah' ? 'selected' : '' }}>Menengah</option>
                    <option value="tidak_harus" {{ request('status') == 'tidak_harus' ? 'selected' : '' }}>Tidak Harus
                    </option>
                </select>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <!-- TASK MENU -->
        <div class="mb-4">
            <h6 class="text-uppercase text-muted fw-bold small">Tasks</h6>
            <ul class="list-unstyled">
                <li class="d-flex justify-content-between align-items-center mb-2">
                    <a href="{{ route('tasks.index', ['is_completed' => 0]) }}" class="text-decoration-none text-dark">
                        <span class="me-2"
                            style="display:inline-block; width: 12px; height: 12px; background-color: #fac000; border-radius: 2px;"></span>
                        Upcoming
                    </a>
                    <span class="badge bg-light text-dark">{{ $upcomingCount ?? '0' }}</span>
                </li>
                <li class="d-flex justify-content-between align-items-center mb-2">
                    <a href="{{ route('tasks.index', ['due_soon' => 1]) }}" class="text-decoration-none text-dark">
                        <span class="me-2"
                            style="display:inline-block; width: 12px; height: 12px; background-color: #ee0f0f; border-radius: 2px;"></span>
                        Due in 3 Days
                    </a>
                    
                    <span class="badge bg-light text-dark">{{ $dueInThreeDaysCount ?? '0' }}</span>
                </li>

                

                {{-- <li class="mb-2">
                    <a href="#" class="text-decoration-none text-dark">
                        <i class="bi bi-calendar-event me-2"></i>Calendar
                    </a>
                </li> --}}
            </ul>
        </div>
        <hr>

        <!-- LIST MENU -->
        <div class="mb-4">
            <h6 class="text-uppercase text-muted fw-bold small">Lists</h6>
            <ul class="list-unstyled">
                <li class="d-flex justify-content-between align-items-center mb-2">
                    <a href="{{ route('student.teacher_tasks') }}" class="text-decoration-none text-dark">
                        <span class="me-2"
                            style="display:inline-block; width: 12px; height: 12px; background-color: #1e3a8a; border-radius: 2px;"></span>
                        Assignment
                    </a>
                    <span class="badge bg-light text-dark">{{ $teacherTaskCount ?? 0 }}</span>
                </li>

                <li class="d-flex justify-content-between align-items-center mb-2">
                    <a href="#" class="text-decoration-none text-dark">
                        <span class="me-2"
                            style="display:inline-block; width: 12px; height: 12px; background-color: #9bc1bc; border-radius: 2px;"></span>
                        Work
                    </a>
                    <span class="badge bg-light text-dark">{{ $workCount ?? 0 }}</span>
                </li>
                <li class="d-flex justify-content-between align-items-center mb-2">
                    <a href="#" class="text-decoration-none text-dark">
                        <span class="me-2"
                            style="display:inline-block; width: 12px; height: 12px; background-color: #e3b45c; border-radius: 2px;"></span>
                        List 1
                    </a>
                    <span class="badge bg-light text-dark">{{ $list1Count ?? 0 }}</span>
                </li>
                {{-- <li>
            <a href="#" class="text-decoration-none text-dark">
                <i class="bi bi-plus-lg me-2"></i>Add New List
            </a>
        </li> --}}
            </ul>
        </div>



    </div>

    <!-- USER INFO -->
    @auth
        <div>
            <hr>
            <div class="d-grid mb-3">
                <a href="{{ route('tasks.create') }}" class="btn btn-outline-primary">Tambah Tugas</a>
            </div>
            <p class="mb-1">Hello, <strong>{{ Auth::user()->name }}</strong></p>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger w-100">Logout</button>
            </form>
        </div>
    @endauth
</div>
