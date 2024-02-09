@php
    $total = 0;
@endphp
@foreach ($cartes as $item)
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <span>Name: {{ $item->product->name }}</span>
        <i class="bi bi-plus-square ml-5 plus" id="{{ $item->product->id }}"></i> <span
            class="ml-3">{{ $item->amount }}</span> <i class="bi bi-dash-square ml-3 minus"
            id="{{ $item->product->id }}"></i>
        <span class="ml-3">{{ $item->product->price }}</span>
        <button type="button" class="btn-close" id="{{ $item->product->id }}" data-bs-dismiss="alert"
            aria-label="Close"></button>
    </div>
    @php
        $total += $item->product->price * $item->amount;
    @endphp
@endforeach
