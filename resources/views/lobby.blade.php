
@php
    $page_title = $tournament->name . " Lobby";
@endphp
@extends('/layouts/main')
@section('head')
    <link rel="stylesheet" href="{{URL::asset('resources/css/lobby.min.css')}}" />
@endsection
@section('content')

            <article class="box post">
                @if (isset($today))
                    <h3>
                        {{$today->score}}/10 In {{$today->time}} Seconds<br>
                        Score of {{ ( ($today->score * 100) - $today->time ) }}!
                    </h3>
                @else
                    <div style="text-align: center">
                        <a class="button" href="play?tid={{ $tournament->id }}">Play</a>
                    </div>
                @endif
                    <hr>
                    <span class="tableHeaders">
                        <h4 class="selected" pos=0>Todays Scores </h4>
                        <h4 pos=1>Total Scores</h4>
                    </span>
                    <div class="resTable" >
                        @if ( count($score) == 0 )
                            <p><br>No ones played the quiz today, be the first</p>
                        @else
                            <table>
                                <thead>
                                    <th>Name</th>
                                    <th>/10</th>
                                    <th>Score</th>
                                    <th>Points</th>
                                </thead>
                                @for ($i = 0; $i < count($score); $i++)
                                    <tr @if ( $score[$i]->name == Auth::user()->name ) class='leaderboard_user' @endif >
                                        <td>{{ $score[$i]->name }}</td>
                                        <td>{{ $score[$i]->score }}</td>
                                        <td>{{ $score[$i]->points }}</td>
                                        @switch($i)
                                            @case(0)
                                                    <td>5</td>
                                                @break
                                            @case(1)
                                                    <td>4</td>
                                                @break
                                            @case(2)
                                                    <td>3</td>
                                                @break
                                            @default
                                                @if($i > 2 && $i < 9)
                                                    <td>2</td>
                                                @else
                                                    <td>1</td>
                                                @endif
                                        @endswitch
                                    </tr>
                                @endfor
                            </table>
                        @endif
                    </div>
                    <div class="resTable" style="display: none">
                        @if ( count($total) != 0 )
                            <table>
                                <thead>
                                    <th>Name</th>
                                    <th>Points</th>
                                </thead>
                                @foreach ($total as $t)
                                    <tr @if ( $t->name == Auth::user()->name ) class='leaderboard_user' @endif >
                                        <td> {{$t->name}} </td>
                                        <td> {{$t->points}} </td>
                                    </tr>
                                @endforeach
                            </table>
                        @endif
                    </div>
            </article>

@endsection
@section('script')
    <script>
        var i,j;
        var th  = document.getElementsByClassName('tableHeaders')[0].children;
        var t   = document.getElementsByClassName('resTable');
        for(i=0;i<th.length;i++){
            th[i].addEventListener('click',function(){
                if (!this.classList.contains('selected')){
                    for(j=0;j<t.length;j++){
                        th[j].classList.remove('selected');
                        t[j].style.display = 'none';
                    }
                    this.classList.add('selected');
                    t[this.getAttribute('pos')].style.display = '';
                }
            });
        }

    </script>
@endsection
