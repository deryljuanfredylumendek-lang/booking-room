<div class="table-responsive text-nowrap px-4 py-3">
  <table class="table" id="list-table">
    <thead class="table-light">
      <tr>
        <th>No</th>
        @admin <th>Pemesan</th> @endadmin
        <th class="text-center">Ruangan</th>
        <th>Tanggal</th>
        <th>Waktu</th>
        <th>Keperluan</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody class="table-border-bottom-0">
      @foreach ($lists as $list)
          <tr>
            <td>{{ $loop->iteration }}</td>
            @admin
            <td>
              <div class="text-primary me-3">
                {{ $list->user->name }}
              </div> 
            </td>
            @endadmin
            <td class="text-center">
              @if(isset($list->room->photo)) <img src="{{ asset($list->room->photo) }}" style="object-fit: cover;" height="125" alt="Photo Ruangan {{ $list->room->name }}"> @else - @endif
              <br> <small class="text-muted mt-2 me-3">{{ $list->room->name }}</small>
            </td>
            <td>
              <div class="me-3 text-wrap">
                {{ $list->date->isoformat('dddd, D MMM Y') }}
              </div> 
            </td>
            <td>
              <small class="me-3 text- text-wrap">
                {{ $list->start->format('h:i A') }} - {{ $list->end->format('h:i A') }}
              </small> 
            </td>
            <td class="text-wrap">{{ $list->need }}</td>
            <td>
              @php $statusLabel = $list->status; @endphp
              @switch($list->status)
                @case('pending')
                  @php $badge = 'info' @endphp
                  @break
                @case('approved')
                  @php $badge = 'success' @endphp
                  @break
                @case('rejected')
                  @php $badge = 'danger' @endphp
                  @break
                @case('used')
                  @php $badge = 'warning'; $statusLabel = 'On Going'; @endphp
                  @break
                @case('canceled')
                  @php $badge = 'dark' @endphp
                  @break
                @case('done')
                  @php $badge = 'primary'; $statusLabel = 'Finish'; @endphp
                  @break
                @case('expired')
                  @php $badge = 'secondary' @endphp
                  @break
                @case('rescheduled')
                  @php $badge = 'success' @endphp
                  @break
              
                @default
                  
              @endswitch
              <span class="badge bg-label-{{ $badge }} me-1">{{ $statusLabel }}</span>
            </td>
            @admin 
            <td class="text-end">
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                @if($list->status == 'pending')
                <div class="dropdown-menu">
                  <a class="dropdown-item" href="#" onclick="openModal('{{ $list->id }}', '{{ $list->room_id }}', 'setuju')"
                    ><i class="bx bx-check me-1"></i> Setujui</a
                  >
                  <a class="dropdown-item" href="#" onclick="openModal('{{ $list->id }}', '{{ $list->room_id }}', 'tolak')"> <i class="bx bx-x me-1"></i> Tolak</a>
                </div>
                @endif
              </div>
            </td>
            @else
            @php $canModify = $list->date->gt(now()->addDay()); @endphp
            <td class="text-end">
              @if($canModify && in_array($list->status, ['pending', 'approved']))
                <div class="dropdown">
                  <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="bx bx-dots-vertical-rounded"></i>
                  </button>
                  <div class="dropdown-menu">
                    @if($list->status == 'pending')
                      <a class="dropdown-item" href="{{ route('booking.edit', $list->id) }}"
                        ><i class="bx bx-edit-alt me-1"></i> Edit</a
                      >
                      <a class="dropdown-item" href="#" onclick="openModal('{{ $list->id }}', '{{ $list->room_id }}', 'batalkan')"
                        ><i class="bx bx-trash me-1"></i> Batalkan</a
                      >
                    @elseif($list->status == 'approved')
                      <a class="dropdown-item" href="#" onclick="openModal('{{ $list->id }}', '{{ $list->room_id }}', 'reschedule')"
                        ><i class="bx bx-refresh me-1"></i> Reschedule</a
                      >
                      <a class="dropdown-item" href="#" onclick="openModal('{{ $list->id }}', '{{ $list->room_id }}', 'batalkan')"
                        ><i class="bx bx-trash me-1"></i> Batalkan</a
                      >
                    @endif
                  </div>
                </div>
              @else
                <span class="text-muted small">Tidak bisa diubah dalam 2 hari sebelum jadwal</span>
              @endif
            </td>
            @endadmin
          </tr>
      @endforeach
    </tbody>
  </table>
</div>