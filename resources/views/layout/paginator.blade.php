<div class="paginator">
    <div class="total">
        <label>Találatok száma:</label> {{$paginator->total()}}
    </div>

    <div class="items_per_page">
        <label>Sorok laponként:</label>
        <select class="select_lengths input-sm">
            @foreach($paginator_config['lengths'] as $item)
                <option value="{{url()->current() . '?paginator_per_page=' . $item}}" @if($item == $paginator->perPage()) selected="selected" @endif>{{$item}}</option>
            @endforeach
        </select>
    </div>

    <div class="pages">
        <label>Lap:</label>
        <select class="select_pages input-sm">
            @for($item = 1; $item <= $paginator->lastPage(); $item++)
                <option value="{{$paginator->url($item)}}" @if($item == $paginator->currentPage()) selected="selected" @endif>{{$item}}</option>
            @endfor
        </select>
    </div>

    <div class="navigator input-group">
        <a href="{{$paginator->url(1)}}" class="btn btn-default btn-first @if($paginator->currentPage() == 1) disabled @endif">
            <i class="fa fa-angle-double-left"></i>
        </a>

        <a href="{{$paginator->previousPageUrl()}}" class="btn btn-default btn-prev @if($paginator->currentPage() == 1) disabled @endif">
            <i class="fa fa-chevron-left"></i>
        </a>

        <a href="{{$paginator->nextPageUrl()}}" class="btn btn-default btn-next @if($paginator->currentPage() == $paginator->lastPage()) disabled @endif">
            <i class="fa fa-chevron-right"></i>
        </a>

        <a href="{{$paginator->url($paginator->lastPage())}}" class="btn btn-default btn-last @if($paginator->currentPage() == $paginator->lastPage()) disabled @endif">
            <i class="fa fa-angle-double-right"></i>
        </a>
    </div>
</div>