
@php
    $page_title = $tournament->name . " Settings";
@endphp
@extends('/layouts/main')
@section('head')
    <link rel="stylesheet" href="{{URL::asset('resources/css/settings.min.css')}}" />
@endsection
@section('content')
    <article class="box post">
        <h3>Join Link</h3>
        <div class="joinLink" onclick="copy(this)">
            <i class="fas fa-copy"></i>
            <i>join?id={{ $tournament->id }}@if ($tournament->password) &password={{ $tournament->password }} @endif </i>
        </div>
        <hr>
        <h3>Scoreboard System</h3>
            <form method="POST" action="changesetting">
                @csrf
                <input type="hidden" name='type' value="scoreboard" />
                <input type="hidden" name='tid' value="{{ $tournament->id }}" />
                <select name='setting' onchange="showdesc(this)" id='sd' required>
                    <option value="0" @if (isset($settings->scoreboard) && $settings->scoreboard == 0) selected="selected" @endif>Points</option>
                    <option value="1" @if (isset($settings->scoreboard) && $settings->scoreboard == 1) selected="selected" @endif>Score</option>
                </select>
                <br>
                <p id='ssp'></p>
                <input type="submit" value="Save"/>
            </form>
        <hr>
        <h3>Players</h3>
        <ul>
            @foreach ($players as $p)
                <li> {{ $p->name }} </li>
            @endforeach
        </ul>
    </article>
@endsection
@section('script')
    <script>
        var ss = [
            "Players will get points based on the position each day (e.g. 1st = 5, 2nd = 4, etc)",
            "Players score each day is added to the total"
        ]
        function showdesc($this){ document.getElementById('ssp').innerHTML = ss[$this.value]; }

        function copy($this){
            var str = $this.children[1].innerHTML;
            const el = document.createElement('textarea');
            el.value = str;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
        };
        showdesc(document.getElementById('sd'));
    </script>
@endsection
