@extends('/layouts/main')
@section('head')
@endsection
@section('content')
        <article class="box post">
            <form action="createtournament" method="POST">
                @csrf
                <input type="text"   name="name"     value=""       placeholder="Tournament's Name"                         required>
                <input type="text"   name="password" value=""       placeholder="Password - leave blank to let anyone join"  maxlength="40">
                <input type="submit" name='create'   value="Create"                                                         >
            </form>
        </article>


@endsection
