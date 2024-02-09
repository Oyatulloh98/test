@extends('dashboard/app')
@section('title', 'Admin Panel HashTag')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Product</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div class="col-12">
                    <!-- Top Selling -->
                    <div class="col-12">
                        <div class="card top-selling overflow-auto">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                        class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li><a class="dropdown-item" href="{{ route('product.create') }}">create</a></li>
                                    <li><a class="dropdown-item" href="#">trash</a></li>
                                </ul>
                            </div>

                            <div class="card-body pb-0">
                                <h5 class="card-title">Top Product <span>| Today</span></h5>

                                <table class="table table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Qr_Code</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Created_at</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $item)
                                            <tr>
                                                <th scope="row">{{$item->id}}</th>
                                                <td>{{$item->related_category_child->name}}</td>
                                                <td>{{$item->code}}</td>
                                                <td>{{$item->name}}</td>
                                                <td class="fw-bold">{{$item->amount}}</td>
                                                <td>{{$item->price}} $</td>
                                                <td>{{$item->created_at}}</td>
                                                <td>action here</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>

                        </div>
                    </div><!-- End Top Selling -->
                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
