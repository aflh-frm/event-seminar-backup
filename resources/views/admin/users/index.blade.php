@extends('layouts.admin.app')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Manajemen Pengguna</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Peserta & Event Organizer</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Tanggal Bergabung</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $key => $user)
                        <tr>
                            <td>{{ $users->firstItem() + $key }}</td>
                            <td>
                                <span class="font-weight-bold text-dark">{{ $user->name }}</span>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'eo')
                                    <span class="badge badge-info px-2 py-1">Mitra EO</span>
                                @else
                                    <span class="badge badge-secondary px-2 py-1">Peserta Umum</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td class="text-center">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('HATI-HATI! Menghapus user akan menghapus semua data event mereka. Yakin?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                        <span class="text">Hapus Akun</span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada pengguna terdaftar.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $users->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

@endsection