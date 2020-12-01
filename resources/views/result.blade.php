@php
    $page_title = 'Result';
@endphp
@extends('/layouts/main')
@section('head')
    <link rel="stylesheet" href="{{URL::asset('resources/css/result.min.css')}}" />
@endsection
@section('content')
        <article class="box post">
            <h2 style="text-align:center"> {{ $score }} / 10 in {{$time}} Seconds</h2>
            <br>
            <a style="text-align: center" class="button" href="lobby?tid={{$result['tid']}}">To Leaderboards</a>
            <br>
            <ul class="questions">
                @for($i=0;$i<count($questions);$i++)
@php
    $q = $questions[$i];
    $option =  unserialize ( $q->option ) ;
    shuffle( $option );
    $r_answer = $result['a'.$i];
@endphp
                    <li>
                        <strong><h3>{{ $q->question }}</h3></strong>
                        <ul class="answers">
                            @if ( $r_answer == $q->answer )
                                <strong class="answer-item correct">{{ $r_answer }}</strong>
                            @else
                                <strong class="answer-item incorrect">{{ $r_answer }}</strong>
                                <strong class="answer-item correct">{{ $q->answer }}</strong>
                            @endif
                        </ul>
                    </li>
                @endfor
            </ul>
            <br>
            <a style="text-align: center" class="button" href="lobby?tid={{$result['tid']}}">To Leaderboards</a>
        </article>
@endsection
