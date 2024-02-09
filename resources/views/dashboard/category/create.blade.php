@extends('dashboard/app')
@section('title', 'Admin Panel HashTag')
@section('content')
    <main id="main" class="main">

        <div class="pagetitle">
            <h1>Dashboard</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item active">Category Create</li>
                    <!-- Full Screen Modal -->
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                <div class="col-12">
                    <div class="card col-8 offset-2">
                        <div class="card-body">
                            <h5 class="card-title">Vertical Form</h5>

                            <!-- Vertical Form -->
                            <form class="row g-3" action="{{ route('category.store') }}" method="POST" autocomplete="off">
                                @csrf
                                <div class="col-12">
                                    @error('cat_naem')
                                        <div class="alert alert-danger mt-1">{{ $message }}</div>
                                    @enderror
                                    <label for="inputNanme4" class="form-label">Category Name</label>
                                    <input type="text" name="cat_naem" class="form-control" id="inputNanme4">
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                </div>
                            </form><!-- Vertical Form -->

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
