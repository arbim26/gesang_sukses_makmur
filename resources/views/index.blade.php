@extends('adminlte::page')

@section('title', 'Daftar Invoice')

@section('content_header')
    <h1>Daftar Invoice</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <a href="{{ route('invoice.create') }}" class="btn btn-primary">Buat Invoice Baru</a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped" id="invoice-table">
                <thead>
                    <tr>
                        <th>No Invoice</th>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Pegawai</th>
                        <th>Grand Total</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->no_invoice }}</td>
                        <td>{{ $invoice->tanggal }}</td>
                        <td>{{ $invoice->customer->pic ?? '-' }}</td>
                        <td>{{ $invoice->ceo->Nama_Pegawai ?? '-' }}</td>
                        <td>{{ number_format($invoice->grand_total, 2) }}</td>
                        <td>
                            <a href="{{ route('invoice.show', $invoice->id) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('invoice.edit', $invoice->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST" style="display:inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#invoice-table').DataTable();
        });
    </script>
@stop
