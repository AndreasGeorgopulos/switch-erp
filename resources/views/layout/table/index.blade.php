@section('content')
    @include('layout.messages')
    <div class="box content box-primary"
         id="listTable"
         @if(!empty($data_current_page)) data-init-current-page="{{ $data_current_page }}" @endif
         @if(!empty($data_init_sort)) data-init-sort="{{ $data_init_sort }}" @endif
         @if(!empty($data_init_direction)) data-init-direction="{{ $data_init_direction }}" @endif
    ></div>
@endsection