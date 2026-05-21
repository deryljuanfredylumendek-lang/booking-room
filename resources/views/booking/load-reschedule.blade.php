<div class="table-responsive text-nowrap px-4 py-3">
  @if($reschedules->isEmpty())
    <div class="alert alert-secondary mb-0">
      Tidak ada permintaan reschedule saat ini.
    </div>
  @else
    <table class="table align-middle" id="reschedule-table">
      <thead class="table-light">
        <tr>
          <th>No</th>
          <th>Ruangan</th>
          <th>Waktu</th>
          <th>Alasan</th>
          <th class="text-center">Status Reschedule</th>
          <th class="text-center">Status Booking</th>
          <th class="text-end">Action</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($reschedules as $reschedule)
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
              <div class="text-primary me-3">
                {{ $reschedule->room->name }}
              </div> 
            </td>
            <td>
              <div class="me-3 text-wrap">
                {{ $reschedule->bookingList->date->format('Y-m-d') }}
                <br>
                {{ $reschedule->bookingList->start->format('H:m A') }} - 
                {{ $reschedule->bookingList->end->format('H:m A') }}
              </div> 
            </td>
            <td class="text-wrap">
              {{ $reschedule->message }}
            </td>
            <td class="text-center">
              @switch($reschedule->reschedule)
                @case('yes')
                  @php $badge = 'success' @endphp
                  @break
                @case('no')
                  @php $badge = 'danger' @endphp
                  @break
              
                @default
                  @php $badge = 'secondary' @endphp
                  @break
                  
              @endswitch
              <span class="badge bg-label-{{ $badge }} me-1">{{ (isset($reschedule->reschedule)) ? (($reschedule->reschedule == 'yes') ? 'Ya' : 'Tidak') : '-' }}</span>
            </td>
            <td>
              @php
                switch($reschedule->bookingList->status) {
                  case 'rejected': $bookingBadge = 'danger'; break;
                  case 'approved': $bookingBadge = 'success'; break;
                  case 'pending': $bookingBadge = 'info'; break;
                  case 'rescheduled': $bookingBadge = 'warning'; break;
                  case 'canceled': $bookingBadge = 'dark'; break;
                  default: $bookingBadge = 'secondary';
                }
              @endphp
              <span class="badge bg-label-{{ $bookingBadge }} me-1">{{ $reschedule->bookingList->status }}</span>
            </td>
            <td class="text-end">
              <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                  <i class="bx bx-dots-vertical-rounded"></i>
                </button>
                @if($reschedule->reschedule == null)
                  @if($reschedule->bookingList->status == 'rejected')
                    <div class="dropdown-menu">
                      <a class="dropdown-item" href="#" onclick="openModal('{{ $reschedule->id }}', '{{ $reschedule->message }}', '{{ $reschedule->bookingList->id }}')"
                        ><i class="bx bx-check me-1"></i> Konfirmasi</a
                      >
                    </div>
                  @endif
                @endif
              </div>
            </td>
          </tr>
      @endforeach
    </tbody>
  </table>
  @endif
</div>