@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <h3>Followed Blogs</h3>
                    <ul>
                        @foreach ($blogs as $blog)
                        <li>
                            {{$blog->name}}<br />
                            <a href="{{$blog->feed_url}}" target="_blank">
                                {{$blog->feed_url}}
                            </a><br />
                            Notify via {{$blog->pivot->notify_via}} at {{$blog->pivot->notify_location}}
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection