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

                    <!-- Vertical Form -->
                    <form class="row g-3" action="{{ route('product.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="col-12">
                            <label for="inputNanme4" class="form-control">Category name
                                @error('category')
                                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                                @enderror
                                <select name="category" id="category" class="form-control mt-1">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                        </div>
                        <div class="col-12">
                            <label for="inputNanme4" class="form-label">Product
                                Name</label>
                            @error('name')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                            <input type="text" name="name" class="form-control" id="inputNanme4">
                        </div>
                        <div class="col-6">
                            <label for="inputNanme4" class="form-label">Product
                                Price</label>
                            @error('price')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                            <input type="number" name="price" class="form-control" id="inputNanme4">
                        </div>
                        <div class="col-6">
                            <label for="inputNanme4" class="form-label">Product
                                Amount</label>
                            @error('amount')
                                <div class="alert alert-danger mt-1">{{ $message }}</div>
                            @enderror
                            <input type="number" name="amount" class="form-control" id="inputNanme4">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </div>
                    </form><!-- Vertical Form -->

                </div>
            </div>
        </section>

    </main><!-- End #main -->
@endsection
