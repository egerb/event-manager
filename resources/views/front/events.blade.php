@extends('layouts.app-front')
@section('title')
    Наши мероприятия
    @endsection

<center>



@section('content')
        <div class="col-xs-8 col-xs-offset-2" style="margin-top:50px;">
        @if (count($events))
            <center>
                @foreach($events as $event)
                    <div class="panel panel-default col-xs-3">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Название: {{$event->title}}
                            </h3>
                        </div>
                        <div class="panel-body">
                            <p>Дата: {{$event->date}}</p>
                            <p>Город: {{$event->place}}</p>
                            <p><a class="btn btn-danger" href="/event/{{$event->date}}/{{$event->slug}}">Перейти</a>
                            </p>
                        </div>
                    </div>

                    @endforeach
            </center>

            @else
            <h1>Нету активных ивентов</h1>
            @endif
        </div>
    @endsection

</center>