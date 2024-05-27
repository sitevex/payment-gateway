@extends('layouts.zc_app')
@section('title','Comprobante')
@section('content')
<h1>Detalles de la Transacción</h1>
<pre>{{ json_encode($transactionDetails, JSON_PRETTY_PRINT) }}</pre>
@endsection
@push('script-app')
@endpush