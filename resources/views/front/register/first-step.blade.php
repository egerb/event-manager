@extends('layouts.app-front')



@section('content')
    <div class="col-xs-offset-2 col-xs-8">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">Регистрация на {{$lap->title}}</h3>
        </div>
        <div class="panel-body">
            <div class="col-xs-8 col-xs-offset-2">

                <div class="progress">
                    <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                        0%
                    </div>
                </div>

                <div id="firstForm" class="form-horizontal">
                    <div class="message">

                    </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10">
                                <input name="email" type="email" class="form-control" id="inputEmail" placeholder="Email" value="egor.admin@gmail.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPhone" class="col-sm-2 control-label">Телефон</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="input-group-addon">+</div>

                                    <input name="phone" type="text" class="form-control" id="inputPhone" placeholder="" value="380665290379">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 text-right">
                                <button id="secondStep" class="btn btn-default">Дальше >></button>
                            </div>
                        </div>
                    </div>

                <div id="secondAjax" class="text-center" style="display: none;">
                        <center>
                            <img src="{{asset('img/ajax-loader.gif')}}" />

                        </center>

                    </div>

                <div id="secondForm" class="form-horizontal" style="display: none;">
                    <div class="checkbox auto-fill" style="display: none;">
                        <label>
                            <input type="checkbox">Автозаполить анкету используя предыдущую регистрацию
                        </label>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Имя</label>
                        <div class="col-sm-10">
                            <input name="first_name" class="form-control" type="text" value="Ihor">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Фамилия</label>
                        <div class="col-sm-10">
                            <input name="last_name" class="form-control" type="text" value="Ihor">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Дата рождения</label>
                        <div class="col-sm-10">
                            <input name="birth_date" class="form-control datepicker" type="text" value="Ihor">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Пол</label>
                        <div class="col-sm-10">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" id="gender1" value="male" checked>
                                    Мужской
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" id="gender2" value="female" >
                                    Женский
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Город</label>
                        <div class="col-sm-10">
                            <input name="city" class="form-control" type="text" value="Полтава">
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
                            <input name="team" class="form-control" type="text" value="Полтава">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Клуб</label>
                        <div class="col-sm-10">
                            <input name="club" class="form-control" type="text" value="Полтава">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Размер футболки</label>
                        <div class="col-sm-10">

                            <label>
                                <input type="radio" name="t_shirt_size" id="" value="S" checked>&nbsp;S&nbsp;
                            </label>
                            <label>
                                <input type="radio" name="t_shirt_size" id="" value="M" checked>&nbsp;M&nbsp;
                            </label>

                            <label>
                                <input type="radio" name="t_shirt_size" id="" value="L" checked>&nbsp;L&nbsp;
                            </label>
                            <label>
                                <input type="radio" name="t_shirt_size" id="" value="XS" checked>&nbsp;XS&nbsp;
                            </label>
                            <label>
                                <input type="radio" name="t_shirt_size" id="" value="XL" checked>&nbsp;XL&nbsp;
                            </label>
                            <label>
                                <input type="radio" name="t_shirt_size" id="" value="XXL" checked>&nbsp;XXL&nbsp;
                            </label>
                            <label>
                                <input type="radio" name="t_shirt_size" id="" value="XXXL" checked>&nbsp;XXXL&nbsp;
                            </label>


                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Доп. информация</label>
                        <div class="col-sm-10">
                            <textarea name="additional_info" class="form-control" value="" ></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">
                            Планирует одолеть дистанцию</label>
                        <div class="col-sm-10">
                            <textarea name="additional_distance" class="form-control" value="" ></textarea>
                        </div>
                    </div>

                    <div class="form-group">
                        <button class="btn-danger btn-block register">Зарегистрироваться</button>
                    </div>

                </div>



            </div>

        </div>


    </div>
    </div>
    @endsection


@section('scripts')
    <script src="/js/jquery.maskedinput.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.ru.min.js"></script>
    <script>
        $('.datepicker').datepicker();
        $('#inputPhone').mask('99-(999)-999-99-99');
        $('#secondStep').click(function () {
            //$("#firstForm :input").attr("disabled", true);
            $('#secondAjax').css('display', 'block');
            $.ajax({
                url:'/find-user',
                method:'POST',
                data : {
                    'email':$('input[name=email]').val(),
                    'phone':$('input[name=phone]').val()
                },
                dataType: "json"
            }).done(function (response) {

                if (response.state == 'error')

                {
                   $('#firstForm div.message').html(response.html);
                    $("#firstForm :input").attr("disabled", false);
                    $('#secondAjax').css('display', 'none');
                }
                else
                    {
                        $('#secondAjax').css('display', 'none');
                    $('.progress-bar').css('width','20%').text('20%');
                    $('#secondForm').slideDown(700);
                    $('#secondForm').append(``);
                    if (response.profile != null) $('.auto-fill').fadeIn(500);
                     }


            });

            $('button.register').click(function(){
                console.log('reg');
                $.ajax({
                    url:'/register-participant',
                    method:'POST',
                    data:{
                        first_name:$('input[name=first_name]').val(),
                        last_name:$('input[name=last_name]').val(),
                        birth_date:$('input[name=birth_date]').val(),
                        gender:$('input[name=gender]').val(),
                        city:$('input[name=city]').val(),
                        contacts_data:$('input[name=contacts_data]').text(),
                        team:$('input[name=team]').val(),
                        club:$('input[name=club]').val(),
                        t_shirt_size:$('input[name=t_shirt_size]').val(),
                        additional_info:$('input[name=additional_info]').text(),
                        additional_distance:$('input[name=additional_distance]').text(),
                    }
                }).done(function (response) {
                    console.log(response);
                });
            });
        });

    </script>

    @endsection

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css" type="text/css">


    @endsection