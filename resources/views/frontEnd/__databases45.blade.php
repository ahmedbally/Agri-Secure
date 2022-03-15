@if($repIndex==1)
    @foreach($ListArr as $row)
        <tr class="bg-cloro2">
          <th style="width: 25%">{{$row->year}}</th>
          <th style="width: 25%">{{$row->natural_sources}}</th>
          <th style="width: 25%">{{$row->fish_aquiculture}}</th>
          <th style="width: 25%">{{$row->total}}</th>
        </tr>
    @endforeach
@elseif($repIndex==2)
    @foreach($ListArr as $row)
        <tr class="bg-cloro2">
          <th style="width: 10%">{{$row->year}}</th>
          <th style="width: 10%">{{$row->apiaries}}</th>
          <th style="width: 10%">{{$row->beehives}}</th>
          <th style="width: 10%">{{$row->bees_honey}}</th>
          <th style="width: 10%">{{$row->bees_wax}}</th>
          <th style="width: 10%">{{$row->silk}}</th>
        </tr>
    @endforeach
@elseif($repIndex==3)
    @foreach($ListArr as $row)
        <tr class="bg-cloro2">
          <th style="width: 10%">{{$row->year}}</th>
          <th style="width: 12%">{{$row->item}}</th>
          <th style="width: 10%">{{$row->factories}}</th>
          <th style="width: 15%">{{$row->f_capacity}}</th>
          <th style="width: 15%">{{$row->q_supplied}}</th>
          <th style="width: 12%">{{$row->o_efficiency}}</th>
          <th style="width: 15%">{{$row->sugar_prod}}</th>
          <th style="width: 15%">{{$row->extraction}}</th>
        </tr>
    @endforeach
@elseif($repIndex==4)
    @foreach($ListArr as $row)
        <tr class="bg-cloro2">
          <th style="width: 10%">{{$row->year}}</th>
          <th style="width: 12%">{{$row->item}}</th>
          <th style="width: 10%">{{$row->era_machines}}</th>
          <th style="width: 15%">{{$row->squezed_cane}}</th>
          <th style="width: 15%">{{$row->molasses_production}}</th>
          <th style="width: 12%">{{$row->extraction}}</th>
        </tr>
    @endforeach
@elseif($repIndex==5)
    @foreach($ListArr as $row)
        <tr class="bg-cloro2">
          <th style="width: 10%">{{$row->year}}</th>
          <th style="width: 12%">{{$row->item}}</th>
          <th style="width: 10%">{{$row->factories}}</th>
          <th style="width: 15%">{{$row->f_capacity}}</th>
          <th style="width: 15%">{{$row->a_production}}</th>
        </tr>
    @endforeach
@endif
