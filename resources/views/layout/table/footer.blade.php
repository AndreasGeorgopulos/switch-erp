<div class="row">
    <div class="col-sm-5">
        <div class="dataTables_info" role="status" aria-live="polite">
        {{trans('Találatok száma')}}: {{$list->total()}},
{{trans('Elemek')}}: {{ (($list->perPage() * $list->currentPage()) - $list->perPage()) + 1 }} - {{$list->perPage() * $list->currentPage()}}
        </div>
    </div>
    <div class="col-sm-7">
        @if ($list->lastPage() > 1)
        <div class="dataTables_paginate paging_simple_numbers">
            <ul class="pagination">
                <li class="paginate_button btn-sm previous @if($list->currentPage() == 1) disabled @endif">
                    <a href="#" data-page="{{$list->currentPage() - 1}}">{{trans('Előző')}}</a>
                </li>

                @for ($i = 1; $i <= $list->lastPage(); $i++)
                    <li class="paginate_button btn-sm @if($i == $list->currentPage()) active @endif">
                        <a href="#" data-page="{{$i}}">{{$i}}</a>
                    </li>
                @endfor

                <li class="paginate_button btn-sm next @if($list->currentPage() == $list->lastPage()) disabled @endif">
                    <a href="#" data-page="{{$list->currentPage() + 1}}">{{trans('Következő')}}</a>
                </li>
            </ul>
        </div>
        @endif
    </div>
</div>