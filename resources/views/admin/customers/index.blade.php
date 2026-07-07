@extends('admin.layouts.admin')

@section('title', 'Customers')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <div>
        <h4>Customers</h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Customers</li>
            </ol>
        </nav>
    </div>
    <div>
        <button class="btn btn-soft-primary"><i class="fas fa-download me-1"></i> Export</button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="search-box" style="position:relative;width:100%;">
                    <i class="fas fa-search" style="position:absolute;left:14px;top:50%;transform:translateY(-50%);color:#adb5bd;font-size:14px;"></i>
                    <input type="text" class="form-control" placeholder="Search customers..." style="padding-left:40px;">
                </div>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">Order Count</option>
                    <option>Any</option>
                    <option>1 - 5</option>
                    <option>6 - 10</option>
                    <option>10+</option>
                </select>
            </div>
            <div class="col-md-2">
                <select class="form-select">
                    <option value="">Date Joined</option>
                    <option>All Time</option>
                    <option>This Month</option>
                    <option>Last 3 Months</option>
                    <option>This Year</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-soft-primary w-100"><i class="fas fa-filter me-1"></i> Filter</button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th style="text-align:center;">Orders</th>
                        <th>Total Spent</th>
                        <th>Joined</th>
                        <th style="width:80px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $customers = [
                            ['name' => 'Priya Sharma', 'email' => 'priya.sharma@example.com', 'phone' => '+91 98765 43210', 'orders' => 12, 'spent' => 389200, 'joined' => 'Jan 15, 2025'],
                            ['name' => 'Ananya Gupta', 'email' => 'ananya.gupta@example.com', 'phone' => '+91 87654 32109', 'orders' => 8, 'spent' => 245500, 'joined' => 'Mar 22, 2025'],
                            ['name' => 'Riya Patel', 'email' => 'riya.patel@example.com', 'phone' => '+91 76543 21098', 'orders' => 15, 'spent' => 521800, 'joined' => 'Feb 10, 2025'],
                            ['name' => 'Neha Verma', 'email' => 'neha.verma@example.com', 'phone' => '+91 65432 10987', 'orders' => 5, 'spent' => 123400, 'joined' => 'Jun 5, 2025'],
                            ['name' => 'Meera Joshi', 'email' => 'meera.joshi@example.com', 'phone' => '+91 54321 09876', 'orders' => 3, 'spent' => 89200, 'joined' => 'Aug 18, 2025'],
                            ['name' => 'Kavita Singh', 'email' => 'kavita.singh@example.com', 'phone' => '+91 43210 98765', 'orders' => 20, 'spent' => 784500, 'joined' => 'Nov 30, 2024'],
                            ['name' => 'Sunita Reddy', 'email' => 'sunita.reddy@example.com', 'phone' => '+91 32109 87654', 'orders' => 7, 'spent' => 198600, 'joined' => 'Apr 12, 2025'],
                            ['name' => 'Deepika Kumar', 'email' => 'deepika.kumar@example.com', 'phone' => '+91 21098 76543', 'orders' => 10, 'spent' => 312400, 'joined' => 'Jul 8, 2025'],
                            ['name' => 'Anjali Desai', 'email' => 'anjali.desai@example.com', 'phone' => '+91 10987 65432', 'orders' => 4, 'spent' => 95600, 'joined' => 'Sep 25, 2025'],
                            ['name' => 'Pooja Nair', 'email' => 'pooja.nair@example.com', 'phone' => '+91 09876 54321', 'orders' => 6, 'spent' => 167300, 'joined' => 'Oct 14, 2025'],
                        ];
                    @endphp

                    @foreach($customers as $customer)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-sm" style="background:{{ ['#8B5CF6','#10b981','#f59e0b','#3b82f6','#ef4444','#6366f1','#ec4899','#14b8a6','#f97316','#06b6d4'][$loop->index % 10] }};">
                                    {{ preg_replace('/[^A-Z]/', '', $customer['name']) }}
                                </div>
                                <div>
                                    <div class="fw-semibold" style="font-size:14px;">{{ $customer['name'] }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="font-size:13px;">{{ $customer['email'] }}</td>
                        <td style="font-size:13px;">{{ $customer['phone'] }}</td>
                        <td style="text-align:center;"><span class="badge bg-light text-dark">{{ $customer['orders'] }}</span></td>
                        <td class="fw-semibold">${{ number_format($customer['spent'] / 100, 2) }}</td>
                        <td style="font-size:13px;color:#6c757d;">{{ $customer['joined'] }}</td>
                        <td>
                            <div class="action-btns">
                                <button class="btn btn-soft-primary btn-sm" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-soft-warning btn-sm" title="Send Email">
                                    <i class="fas fa-envelope"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex justify-content-between align-items-center">
        <span style="font-size:13px;color:#6c757d;">Showing 1 to 10 of 156 customers</span>
        <nav>
            <ul class="pagination pagination-sm">
                <li class="page-item disabled"><a class="page-link" href="#"><i class="fas fa-chevron-left"></i></a></li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item"><a class="page-link" href="#">4</a></li>
                <li class="page-item"><a class="page-link" href="#">...</a></li>
                <li class="page-item"><a class="page-link" href="#">16</a></li>
                <li class="page-item"><a class="page-link" href="#"><i class="fas fa-chevron-right"></i></a></li>
            </ul>
        </nav>
    </div>
</div>
@endsection
