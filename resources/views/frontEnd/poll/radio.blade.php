<h3 class="vothead">{{ $question }} </h3>
<form method="POST" action="{{ route('poll.vote', $id) }}" class="radform" id="pollform">
    @csrf

    @foreach($options as $id => $name)
        <input value="{{ $id }}" type="radio" name="options" class="radblock">{{ $name }}<br>
    @endforeach
    <!-- <input type="submit" class="button mgt40 smvibtn" value="تصويت" /> -->
</form>
<a href="#" class="button mgt40 smvibtn" onclick="document.getElementById('pollform').submit();"><span>تصويت</span></a>
