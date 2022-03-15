@extends('backEnd.layout')
@section('content')
<div class="padding">
<div class="box">
		<?php
			$poll= Inani\Larapoll\Poll::find(1);
			// print_r($poll); die();
		?>
    	{{ PollWriter::draw($poll) }}
    </div>
</div>
@endsection