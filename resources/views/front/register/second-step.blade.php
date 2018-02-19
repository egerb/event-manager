@extends('layouts.app-front')



@section('content')
    <div class="col-xs-offset-2 col-xs-8">
    <div class="panel panel-danger">
        <div class="panel-heading">
            <h3 class="panel-title">Регистрация на {{$lap->title}}</h3>
        </div>
        <div class="panel-body">

            <div class="form-horizontal">
                <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="inputEmail" placeholder="Email">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputPhone" class="col-sm-2 control-label">Телефон</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <div class="input-group-addon">+</div>

                            <input type="text" class="form-control" id="inputPhone" placeholder="">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10 text-right">
                        <button type="submit" class="btn btn-default">Дальше >></button>
                    </div>
                </div>
            </div>




        </div>

        <div class="progress">
            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100" style="width: 30%">
                <span class="sr-only">80% Complete (danger)</span>
            </div>
        </div>
    </div>
    </div>
    @endsection


@section('scripts')
    <script src="/js/jquery.maskedinput.js">

    </script>
    <script>
        $('#inputPhone').mask('99-(999)-999-99-99');
    </script>
    @endsection