@extends('layouts.app-front')
@section('title')
    {{$event->title}}
@endsection


@section('content')
    <center>
        @if (count($event))
            <div class="col-xs-10 col-xs-offset-1">
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Название ивента {{$event->title}}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-xs-12">
                            <label>Дата:</label>{{ $event->date}}
                        </div>
                        <div class="col-xs-6 col-xs-offset-3">
                            @if ($event->active_laps()->count() > 0)
                                <div class="col-xs-12">

                                    @foreach($event->active_laps() as $lap)
                                        <button type="button" data-toggle="modal" data-target="#lap-{{$lap->uid}}" class="btn btn-danger btn-block">
                                            {{$lap->title}}
                                        </button>
                                    @endforeach
                                </div>

                            @else
                                Нету активных забегов

                            @endif
                        </div>

                    </div>
                </div>
            </div>


            {{-- Inserting modals for each event --}}
            @if ($event->active_laps()->count() > 0)
                @foreach($event->active_laps() as $lap)


                <!-- Modal -->
                    <div class="modal fade" id="lap-{{$lap->uid}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Регистрация на {{$lap->title}}</h4>
                                </div>
                                <div class="modal-body">

                                    <div class="panel panel-danger">
                                        <div class="panel-body">
                                            <div class="col-xs-12">

                                                <div class="progress">
                                                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                                        0%
                                                    </div>
                                                </div>

                                                <div id="secondMessage-{{$lap->uid}}">

                                                </div>

                                                <div id="firstForm-{{$lap->uid}}" class="form-horizontal">
                                                    <div class="message">

                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                                                        <div class="col-sm-10">
                                                            <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email" value="egor.admin1@gmail.com">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="inputPhone" class="col-sm-2 control-label">Телефон</label>
                                                        <div class="col-sm-10">
                                                            <div class="input-group">
                                                                <div class="input-group-addon">+</div>

                                                                <input name="phone" type="text" class="form-control inputPhone" id="" placeholder="" value="380665290371">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-offset-2 col-sm-10 text-right">
                                                            <button  class="btn btn-default secondStep" data-lap="{{$lap->uid}}">Дальше >></button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="secondAjax-{{$lap->uid}}" class="text-center" style="display: none;">
                                                    <center>
                                                        <img src="{{asset('img/ajax-loader.gif')}}" />

                                                    </center>

                                                </div>

                                                <div id="secondForm-{{$lap->uid}}" class="form-horizontal" style="display: none;">
                                                    <div class="checkbox auto-fill" style="display: none;">
                                                        <label>
                                                            <input name="autofill" data-lap="{{$lap->uid}}" type="checkbox" >Автозаполить анкету используя предыдущую регистрацию
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Имя</label>
                                                        <div class="col-sm-10">
                                                            <input name="first_name" class="form-control" type="text" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Фамилия</label>
                                                        <div class="col-sm-10">
                                                            <input name="last_name" class="form-control" type="text" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Дата рождения</label>
                                                        <div class="col-sm-10">
                                                            День <select class="day"></select>
                                                            Месяц <select class="month"></select>
                                                            Год <select class="year"></select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Пол</label>
                                                        <div class="col-sm-10">
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="gender" id="male" value="male">
                                                                    Мужской
                                                                </label>
                                                            </div>
                                                            <div class="radio">
                                                                <label>
                                                                    <input type="radio" name="gender" id="female" value="female" >
                                                                    Женский
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Город</label>
                                                        <div class="col-sm-10">
                                                            <input name="city" class="form-control" type="text" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Контакты</label>
                                                        <div class="col-sm-10">
                                                            <textarea name="contacts_data" class="form-control" value="" placeholder="например: брат, тел - 066456456456, мама - 066456456456"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Команда</label>
                                                        <div class="col-sm-10">
                                                            <input name="team" class="form-control" type="text" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Клуб</label>
                                                        <div class="col-sm-10">
                                                            <input name="club" class="form-control" type="text" >
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Размер футболки</label>
                                                        <div class="col-sm-10">

                                                            <label>
                                                                <input type="radio" name="t_shirt_size" id="S" value="S" >&nbsp;S&nbsp;
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="t_shirt_size" id="M" value="M" >&nbsp;M&nbsp;
                                                            </label>

                                                            <label>
                                                                <input type="radio" name="t_shirt_size" id="L" value="L" >&nbsp;L&nbsp;
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="t_shirt_size" id="XS" value="XS" >&nbsp;XS&nbsp;
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="t_shirt_size" id="XL" value="XL" >&nbsp;XL&nbsp;
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="t_shirt_size" id="XXL" value="XXL" >&nbsp;XXL&nbsp;
                                                            </label>
                                                            <label>
                                                                <input type="radio" name="t_shirt_size" id="XXXL" value="XXXL" >&nbsp;XXXL&nbsp;
                                                            </label>


                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Доп. информация</label>
                                                        <div class="col-sm-10">
                                                            <textarea name="additional_info" class="form-control" ></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">
                                                            Планирует одолеть дистанцию</label>
                                                        <div class="col-sm-10">
                                                            <textarea name="additional_distance" class="form-control" ></textarea>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" value="{{$lap->uid}}" name="lapUid" />
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label">Код скидки: </label>
                                                        <div class="col-sm-10">
                                                            <input  type="text" name="promo_code" class="form-control">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <button class="btn-danger btn-block register" data-lap="{{$lap->uid}}">Зарегистрироваться</button>
                                                    </div>

                                                </div>
                                                <div id="thirdForm-{{$lap->uid}}" class="form-horizontal" style="display: none;">
                                                    <button class="btn btn-success btn-block pay">Оплатить on-line</button>

                                                </div>


                                            </div>

                                        </div>


                                    </div>
                                    <center>или заполнить анкету используя Facebook</center>
                                    <div class="panel ">
                                        <button class="btn btn-primary">Facebook</button>
                                    </div>

                                </div>
                                <div class="modal-footer">

                                </div>
                            </div>
                        </div>
                    </div>


                @endforeach
            @endif



        @else
            <h1 class="text-center">{{$message}}</h1>

        @endif
    </center>
@endsection


@section('scripts')
    <script src="/js/jquery.maskedinput.js">
    </script>
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.ru.min.js"></script>--}}
    <script>
        var profile = {};
        $('.inputPhone:input').mask('99-(999)-999-99-99');
        //$('.datepicker:input').mask('99-99-9999');

        function pad(num, size) {
            var s = num+"";
            while (s.length < size) s = "0" + s;
            return s;
        }

        $( document ).ready(function() {
            console.log( "ready!" );

            for (i = new Date().getFullYear(); i > 1900; i--){
                $('.year').append($('<option />').val(i).html(i));
            }

            for (i = 1; i < 13; i++){
                $('.month').append($('<option />').val(pad(i,2)).html(pad(i,2)));
            }

            for (i = 1; i < 32; i++){
                $('.day').append($('<option />').val(i).html(i));
            }

        });



        $('.secondStep').click(function () {
            var lap_uid = $(this).data('lap');
            console.log(lap_uid);
            //$("#firstForm :input").attr("disabled", true);
            $('#secondAjax-'+lap_uid).css('display', 'block');
            $.ajax({
                url:'/find-user',
                method:'POST',
                data : {
                    'email':$('#firstForm-'+lap_uid+' input[name=email]').val(),
                    'phone':$('#firstForm-'+lap_uid+' input[name=phone]').val()
                },
                dataType: "json"
            }).done(function (response) {

                if (response.state == 'error')

                {
                    $('#firstForm-'+lap_uid+' div.message').html(response.html);
                    $('#firstForm-'+lap_uid+' :input').attr("disabled", false);
                    $('#secondAjax-'+lap_uid).css('display', 'none');
                }
                else
                {
                    $('#secondAjax-'+lap_uid).css('display', 'none');
                    $('#lap-'+lap_uid+' .progress-bar').css('width','20%').text('20%');
                    $('#firstForm-'+lap_uid).slideUp(700);
                    $('#secondForm-'+lap_uid).slideDown(700);
                    if (response.profile != null) {
                        $('.auto-fill').fadeIn(500);
                        profile = response.profile;
                    }
                }


            });

            $('button.register').click(function(){
                var lap_uid = $(this).data('lap');
                console.log('reg');
                console.log(
                    $('#lap-'+lap_uid+' select.day :selected').val(),
                    $('#lap-'+lap_uid+' select.month :selected').val(),
                    $('#lap-'+lap_uid+' select.year :selected').val(),
                );
                $.ajax({
                    url:'/register-participant',
                    method:'POST',
                    data:{
                        lapUid : $('#secondForm-'+lap_uid+' input[name=lapUid]').val(),
                        first_name:$('#secondForm-'+lap_uid+' input[name=first_name]').val(),
                        last_name:$('#secondForm-'+lap_uid+' input[name=last_name]').val(),
                        birth_date: $('#lap-'+lap_uid+' select.day :selected').val()+'-'+
                        $('#lap-'+lap_uid+' select.month :selected').val()+'-'+
                        $('#lap-'+lap_uid+' select.year :selected').val(),
                        gender:$('#secondForm-'+lap_uid+' input[name=gender]:checked').val(),
                        city:$('#secondForm-'+lap_uid+' input[name=city]').val(),
                        contacts_data:$('#secondForm-'+lap_uid+' input[name=contacts_data]').text(),
                        team:$('#secondForm-'+lap_uid+' input[name=team]').val(),
                        club:$('#secondForm-'+lap_uid+' input[name=club]').val(),
                        t_shirt_size:$('#secondForm-'+lap_uid+' input[name=t_shirt_size]:checked').val(),
                        additional_info:$('#secondForm-'+lap_uid+' input[name=additional_info]').text(),
                        additional_distance:$('#secondForm-'+lap_uid+' input[name=additional_distance]').text(),
                        promo_code:$('#secondForm-'+lap_uid+' input[name=promo_code]').val(),
                    }
                }).done(function (response) {
                    $('.progress-bar')
                        .removeClass('progress-bar-danger')
                        .addClass('progress-bar-success')
                        .css('width','90%')
                        .text('90%');
                    //$('#firstForm').fadeOut(500);
                    $('#secondForm-'+lap_uid).slideUp(700);
                    $('#thirdForm-'+lap_uid).slideDown(700);
                    if (response.state == 'error') {
                        $('#secondMessage-'+lap_uid).html(response.html);
                    }
                    console.log(response);
                });
            });
        });

        $('.auto-fill input[type=checkbox]').change(function () {
            var lap_uid = $(this).data('lap');
            if ($(this).prop( "checked" )) {
                for (var key in profile) {
                    if (key ==='birth_date') {
                        let birth = profile[key].split('-');
                        $('#lap-'+lap_uid+' select.day').val(birth[0]);
                        $('#lap-'+lap_uid+' select.month').val(birth[1]);
                        $('#lap-'+lap_uid+' select.year').val(birth[2]);
                    }
                    if (key === 'gender') {
                        $('#secondForm-'+lap_uid+" #"+profile[key]).prop('checked', true);
                        //console.log(key,profile[key]);
                    }  else if (key ==='t_shirt_size') {
                        $('#secondForm-'+lap_uid+" #"+profile[key]).prop('checked', true);
                    }

                    else {
                        $('#secondForm-'+lap_uid+' input[name='+key+']').val(profile[key]);
                    }
                }
            }
            else {

            }

        });

    </script>

@endsection

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" type="text/css">


@endsection

