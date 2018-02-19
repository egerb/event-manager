@extends('layouts.app-front')


<center>



@section('content')
        @if (count($event))
        <h1>$event->title</h1>

            @else


            @endif

    @endsection

</center>