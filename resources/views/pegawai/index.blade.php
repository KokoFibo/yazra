@extends('app')
@section('content')
    <div class="container">
        <div class="card mt-3">
            <div class="card-header">
                <h3>Data Pegawai
                    <button class="btn btn-primary tombol-tambah float-end">
                        Add
                    </button>
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @include('pegawai.modal')
    @include('pegawai.script')
@endsection
