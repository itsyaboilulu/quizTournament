@extends('/layouts/main')
@section('head')
    <link rel="stylesheet" href="{{URL::asset('resources/css/play.min.css')}}" />
@endsection
@section('content')
        <article class="box post">
            <form autocomplete="off" action="result" method="POST">
                @csrf
                <input type="hidden" name="tid" value="{{ $tid }}" />
                <ul class="questions">
                    @for($i=0;$i<count($questions);$i++)
@php
    $q = $questions[$i];
    $option =  unserialize ( $q->option ) ;
    shuffle( $option );
@endphp
                        <li>
                            <strong><h3>{{ html_entity_decode($q->question, ENT_QUOTES) }}</h3></strong><br>
                            <ul class="answers">
                                @foreach ( $option as $ans)
                                    <div class="radiobtn">
                                        <input type="radio" name="a{{ $i }}" value="{{ $ans }}" id='{{ $ans }}'  required/>
                                        <label for="{{ $ans }}">{{ html_entity_decode($ans, ENT_QUOTES) }}</label>
                                    </div>
                                @endforeach
                            </ul>
                        </li>
                    @endfor
                    <li style="text-align: center">
                        <input type="submit" value="finnish" />
                    </li>
                </ul>
            </form>
        </article>


@endsection
