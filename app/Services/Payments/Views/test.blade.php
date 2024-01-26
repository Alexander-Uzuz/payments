@extends('layouts.main')

@section('main.content')
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">
                                Тестовый платёж
                            </h5>

                            <p>
                                Вы можете подтвердить или отменить оплату в целях тестирования.
                            </p>

                            <div class="row">
                                <div class="col-6">
                                    Подтвердить
                                </div>

                                <div class="col-6">
                                    Отменить
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
