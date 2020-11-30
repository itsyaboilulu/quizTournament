@php
    $page_title = 'Home';
@endphp
@extends('/layouts/main')
@section('head')
    <link rel="stylesheet" href="{{URL::asset('resources/css/welcome.min.css')}}" />
@endsection
@section('content')
        <article class="box post">
            <h3>Tournament's</h3>
            <br>
            <table>
                @foreach ($tournaments as $tor)
                    <tr class="lobby" tid='{{$tor->id}}'>
                        <td >{{$tor->name}}
                            <span>
                                @if ($tor->admin)
                                    <a class="settings" href="settings?tid={{$tor->id}}"><i class="fas fa-cog"></i></a>
                                    <a class="exit" onclick="checkDel({{$tor->id}});" ><i class="fas fa-sign-out-alt"></i></a>
                                @else
                                    <a class="exit" onclick="checkDel({{$tor->id}});" ><i class="fas fa-sign-out-alt"></i></a>
                                @endif

                            </span>
                        </td>
                    </tr>
                @endforeach
                    <tr>
                        <td  style="text-align: center"><br><a class="button" href="new">Start New Tournament</a></td>
                    </tr>
            </table>
        </article>
<div style="display: none">
    <form id='will_young' action="exittournament" method="POST">
        @csrf
        <input name="tid" id='wy_tid' value=""/>
    </form>
</div>

@endsection
@section('script')
    <script>
        var lobby = document.getElementsByClassName('lobby');
        var i;
        for(i=0;i<lobby.length;i++){
            lobby[i].addEventListener('click',function(event){
                if(!event.target.classList.contains('fa-sign-out-alt')) {
                    document.location.href = 'lobby?tid='+this.getAttribute('tid');
                }

            });
        }



        function checkDel($tid) {
            if (confirm('Are you sure you want to leave this tournament?')){
                document.getElementById('wy_tid').value = $tid;
                document.getElementById('will_young').submit();
            }

        };
    </script>
@endsection


