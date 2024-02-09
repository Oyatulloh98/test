<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- Template Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">

    <!-- Styles -->

</head>


<body class="antialiased" style="background: rgb(8, 41, 41)">

    @include('sweetalert::alert')
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <a class="navbar-brand ml-3" href="#" style="color: aliceblue">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-5">
                <li class="nav-item active">
                    <a class="nav-link" href="#" style="color: aliceblue">Home <span
                            class="sr-only">(current)</span></a>
                </li>
                <li>
                    @if (Route::has('login'))
                        <div class="d-flex">
                            @auth
                                <a href="{{ url('/home') }}" class="nav-link" style="color: aliceblue">Home</a>
                            @else
                                <a href="{{ route('login') }}" class="nav-link" style="color: aliceblue">Login</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="nav-link" style="color: aliceblue">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </li>
            </ul>
        </div>
    </nav>

    <div class="row mt-5">
        <div class="col-12">
            <div class="col-6 offset-3" style="">
                <div class="row">
                    <div class="col-8 bg-dark">
                        <div class="input-group mt-2">
                            <input type="numeric" class="form-control" id="productgeter" name="product"
                                aria-label="Recipient's username" autocomplete="off" aria-describedby="button-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary btnadd" style="color: aliceblue" type="submit"
                                    id="button-addon2">add</button>
                            </div>
                        </div>

                        <ul id="cartitems" class="mt-3">

                            @foreach ($cartes as $item)
                                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                    <span>Name: {{ $item->product->name }}</span>
                                    <i class="bi bi-plus-square ml-5 plus" id="{{ $item->product->id }}"></i> <span
                                        class="ml-3">{{ $item->amount }}</span> <i
                                        class="bi bi-dash-square ml-3 minus" id="{{ $item->product->id }}"></i>
                                    <span class="ml-3">{{ $item->product->price }}</span>
                                    <button type="button" class="btn-close" id="{{ $item->product->id }}"
                                        data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endforeach
                        </ul>
                    </div>
                    <div class="box col-4 bg-dark">
                        <input type="text" id="alltotal" value="" disabled style="width: 90%; color:aliceblue;"
                            class="rounded-pill mt-2 p-1 alltotal">
                        <button type="submit" name="submit" style="width: 90%"
                            class="btn btn-primary rounded-pill mt-2 save">save </button>
                        <button type="button" style="width: 90%"
                            class="btn btn-danger rounded-pill mb-2 mt-2 reset">reset</button>
                        <button type="button" style="width: 90%" class="btn btn-secondary rounded-pill mb-2"><a
                                href="{{ route('product.index') }}" style="color: aliceblue">Back</a></button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js"
    integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    // let sum = 
    let productgeterTag = document.getElementById('productgeter');
    let cartitems = document.getElementById('cartitems');
    let code = '';
    let btnadd = document.querySelector('.btnadd');
    btnadd.addEventListener('click', () => {
        let code = productgeterTag.value;
        $.ajax({
            url: "{{ route('cart-items.store') }}",
            type: "POST",
            data: {
                code: code,
                // Add more fields as needed
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.status) {
                    swal("Good luck!", response.message, "success");
                    productgeterTag.value = '';
                    $('#cartitems').html('');
                    $('#cartitems').html(response.html);
                    document.getElementById('alltotal').value = response.total;
                    // console.log(response.total);
                    addListener();
                } else {
                    swal("Bad luck!", "Falseness of data code", "error");
                    productgeterTag.value = '';
                    // console.log(response.error);
                }
                // Handle success response
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error
            }
        });

    });

    function addListener() {
        let deletes = document.querySelectorAll('.btn-close');
        let pluses = document.querySelectorAll('.plus');
        let minuses = document.querySelectorAll('.minus');
        // let total = document.querySelector('.total');
        deletes.forEach(element => {
            element.addEventListener('click', () => {
                // console.log(element); // Log the clicked element for debugging purposes
                $.ajax({
                    url: '/cart-items/' + element.getAttribute(
                        'id'), // Use 'data-id' attribute to get the ID
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // console.log(response.message);
                        if (response.status) {
                            swal("Good luck!", response.message, "success");
                            $('#cartitems').html(response
                                .html); // Update cart items on success
                            document.getElementById('alltotal').value = response.total;
                            addListener();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle error
                    }
                });
            });
        });
        pluses.forEach(plus => {
            plus.addEventListener('click', () => {
                $.ajax({
                    url: '/pmfromcart/' + plus.getAttribute('id') +
                        '/plus', // Use 'data-id' attribute to get the ID
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // console.log(response.message);
                        if (response.status) {
                            swal("Good luck!", response.message, "success");
                            $('#cartitems').html(response
                                .html); // Update cart items on success
                            document.getElementById('alltotal').value = response.total;
                            // console.log(response.total);
                            addListener();
                        } else {
                            swal("Bad luck!", "Falseness of data code", "error");
                            // console.log(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle error
                    }
                });
            })
        });
        minuses.forEach(minus => {
            minus.addEventListener('click', () => {
                $.ajax({
                    url: '/pmfromcart/' + minus.getAttribute('id') +
                        '/minus', // Use 'data-id' attribute to get the ID
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        // console.log(response.message);
                        if (response.status) {
                            swal("Good luck!", response.message, "success");
                            $('#cartitems').html(response
                                .html); // Update cart items on success
                            document.getElementById('alltotal').value = response.total;
                            console.log(response.total);

                            addListener();
                        } else {
                            swal("Bad luck!", "Falseness of data code", "error");
                            // console.log(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        // Handle error
                    }
                });
            })
        });
    }
    addListener();
</script>

<script>
    let reset = document.querySelector('.reset');
    let save = document.querySelector('.save');
    reset.addEventListener('click', () => {
        $.ajax({
            url: '/cleancart/clean', // Use 'data-id' attribute to get the ID
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // console.log(response.message);
                if (response.status) {
                    swal("Good luck!", response.message, "success");
                    $('#cartitems').html(response
                        .html); // Update cart items on success
                    window.location.reload();
                } else {
                    swal("Bad luck!", "Falseness of data code", "error");
                    // console.log(response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error
            }
        });
    });
    save.addEventListener('click', () => {
        // console.log(save);
        $.ajax({
            url: '/savecart/save', // Use 'data-id' attribute to get the ID
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                // console.log(response.message);
                if (response.status) {
                    swal("Good luck!", response.message, "success");
                    $('#cartitems').html(response
                        .html); // Update cart items on success
                    window.location.reload();
                } else {
                    swal("Bad luck!", "Falseness of data code", "error");
                    // console.log(response.error);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Handle error
            }
        });
    });
</script>

</html>
