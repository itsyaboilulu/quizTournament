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
                                @endif
                                    <a class="exit"><i class="fas fa-sign-out-alt"></i></a>
                            </span>
                        </td>
                    </tr>
                @endforeach
                    <tr>
                        <td  style="text-align: center"><br><a class="button" href="new">Start New Tournament</a></td>
                    </tr>
            </table>




        </article>


@endsection
@section('script')
    <script>
        var lobby = document.getElementsByClassName('lobby');
        var i;
        for(i=0;i<lobby.length;i++){
            lobby[i].addEventListener('click',function(){
                document.location.href = 'lobby?tid='+this.getAttribute('tid');
            });
        }
    </script>
@endsection


