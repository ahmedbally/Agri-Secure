@if($cat==44)
    @if($repIndex==1)
        @foreach($ListArr as $row)
            <tr class="bg-cloro2">
              <th style="width: 10%">{{$row->year}}</th>
              <th style="width: 10%">{{$row->type}}</th>
              <th style="width: 10%">{{$row->farms}}</th>
              <th style="width: 10%">{{$row->dormit_act}}</th>
              <th style="width: 10%">{{$row->dormit_deact}}</th>
              <th style="width: 10%">{{$row->dormit_total}}</th>
              <th style="width: 10%">{{$row->f_capacity_item}}</th>
              <th style="width: 10%">{{$row->f_capacity_prod}}</th>
              <th style="width: 10%">{{$row->a_capacity_item}}</th>
              <th style="width: 10%">{{$row->a_capacity_prod}}</th>
            </tr>
        @endforeach
    @elseif($repIndex==2)
        @foreach($ListArr as $row)
            <tr class="bg-cloro2">
              <th style="width: 17%">{{$row->year}}</th>
              <th style="width: 17%">{{$row->work_factories}}</th>
              <th style="width: 17%">{{$row->full_capacity}}</th>
              <th style="width: 17%">{{$row->act_production}}</th>
            </tr>
        @endforeach
    @endif
@elseif($cat==46)
    @foreach($ListArr as $row)
        <tr class="bg-cloro2">
          <th style="width: 10%">{{$row->year}}</th>
          <th style="width: 10%">{{$row->exp_quantity}}</th>
          <th style="width: 10%">{{$row->exp_value}}</th>
          <th style="width: 10%">
             @if($row->count_exp)
               <a class="btn btn-info" href="{{url('databases/46?countries=exp&item='.$item.'&item2='.$item2.'&year='.$row->year.'&type_group='.$row->item)}}">تفاصيل</a>
             @endif
          </th>
          <th style="width: 10%">{{$row->imp_quantity}}</th>
          <th style="width: 10%">{{$row->imp_value}}</th>
          <th style="width: 10%">
            @if($row->count_imp)
              <a class="btn btn-info" href="{{url('databases/46?countries=imp&item='.$item.'&item2='.$item2.'&year='.$row->year.'&type_group='.$row->item)}}">تفاصيل</a>
            @endif
          </th>
        </tr>
    @endforeach
@else
 @if($repIndex==1)
        @foreach($ListArr as $row)
            <tr class="bg-cloro2">
              <th style="width: 17%">{{$row->year}}</th>
              <th style="width: 17%">{{$row->animal_type}}</th>
              <th style="width: 17%">{{$row->animal_count}}</th>
            </tr>
        @endforeach
    @elseif($repIndex==2)
        @foreach($ListArr as $row)
            <tr class="bg-cloro2">
              <th style="width: 17%">{{$row->year}}</th>
              <th style="width: 17%">{{$row->work_factories}}</th>
              <th style="width: 17%">{{$row->full_capacity}}</th>
              <th style="width: 17%">{{$row->act_production}}</th>
            </tr>
        @endforeach
    @endif
@endif
