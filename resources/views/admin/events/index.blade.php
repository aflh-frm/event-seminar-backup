@extends('layouts.admin.app')

@section('content')

    <h1 class="h3 mb-4 text-gray-800">Approval Event</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Event Menunggu Persetujuan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama EO</th>
                            <th>Judul Event</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $key => $event)
                        <tr>
                            <td>{{ $events->firstItem() + $key }}</td>
                            <td>
                                <span class="font-weight-bold">{{ $event->user->name }}</span>
                                <br>
                                <small class="text-muted">{{ $event->user->email }}</small>
                            </td>
                            <td>
                                {{ $event->title }}
                                @if($event->banner)
                                    <br>
                                    <a href="{{ asset('storage/'.$event->banner) }}" target="_blank" class="small text-primary">Lihat Poster</a>
                                @endif
                            </td>
                            <td>{{ $event->event_date }}</td>
                            <td class="text-center">
                                @if($event->status == 'draft')
                                    <span class="badge badge-warning">Draft (Pending)</span>
                                @elseif($event->status == 'published')
                                    <span class="badge badge-success">Published</span>
                                @else
                                    <span class="badge badge-danger">Closed/Rejected</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($event->status == 'draft')
                                    <div class="d-flex justify-content-center">
                                        <form action="{{ route('admin.events.approve', $event->id) }}" method="POST" class="mr-2">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm btn-icon-split" onclick="return confirm('Yakin ingin mem-publish event ini?')">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-check"></i>
                                                </span>
                                                <span class="text">Approve</span>
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.events.close', $event->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm btn-icon-split" onclick="return confirm('Tolak event ini?')">
                                                <span class="icon text-white-50">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                                <span class="text">Reject</span>
                                            </button>
                                        </form>
                                    </div>
                                @elseif($event->status == 'published')
                                    <button class="btn btn-secondary btn-sm" disabled>Disetujui</button>
                                @else
                                    <button class="btn btn-secondary btn-sm" disabled>Ditolak</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">Tidak ada event yang perlu diapprove saat ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $events->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>

@endsection