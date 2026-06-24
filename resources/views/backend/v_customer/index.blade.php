@extends('backend.v_layouts.app') 

@section('content')
<!-- Content Awal -->
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-body">

                <h5 class="card-title">{{ $judul }}</h5>
                <br>

                <div class="table-responsive">
                    <table id="zero_config" class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($index as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $row->user->nama }}</td>
                                    <td>{{ $row->user->email }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('backend.customer.destroy', $row->id) }}" style="display: inline-block;">
                                            @method('delete')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm show_confirm" data-konf-delete="{{ $row->user->nama }}" title="Hapus Data">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Content Akhir -->
@endsection
