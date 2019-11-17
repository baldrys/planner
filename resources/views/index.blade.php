@extends('layouts.app')

@section('title', 'Активности')


@section('content')
<div class="container">
    <div class="activities">
        <p class="h1">Список активностей</p>
        <p class="h2">Ноябрь 2019</p>
        <table class="table table-striped text-center">
        <thead>
            <tr>
            <th scope="col" class="text-left">Активности /<br> День</th>
            <th scope="col"><p class="day">Пн</p> <p class="day-number">19</p></th>
            <th scope="col"><p class="day">Вт</p> <p class="day-number">19</p></th>
            <th scope="col"><p class="day">Ср</p> <p class="day-number">19</p></th>
            <th scope="col"><p class="day">Чт</p> <p class="day-number">19</p></th>
            <th scope="col"><p class="day">Пт</p> <p class="day-number">19</p></th>
            <th scope="col"><p class="day">Сб</p> <p class="day-number">19</p></th>
            <th scope="col"><p class="day">Вс</p> <p class="day-number">19</p></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-left">Название активности</td>
                <td>
                    <div class="dropdown">
                    <button class="btn btn-secondary fixed-width dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="dropdown-menu w-50">
                        <a class="dropdown-item"><i class="fas fa-check"></i></a>
                        <a class="dropdown-item"><i class="fas fa-times"></i></a>
                    </div >
                    </div>
                </td>
                <td><i class="fas fa-times"></i></td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-times"></i></td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-times"></i></td>
                <td><i class="fas fa-times"></i></td>
            </tr>
            <tr>
                <td class="text-left">Название активности</td>
                <td>
                    <div class="dropdown">
                    <button class="btn btn-secondary fixed-width dropdown-toggle" type="button" data-toggle="dropdown">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="dropdown-menu w-50">
                        <a class="dropdown-item"><i class="fas fa-check"></i></a>
                        <a class="dropdown-item"><i class="fas fa-times"></i></a>
                    </div >
                    </div>
                </td>
                <td><i class="fas fa-times"></i></td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-times"></i></td>
                <td><i class="fas fa-check"></i></td>
                <td><i class="fas fa-times"></i></td>
                <td><i class="fas fa-times"></i></td>
            </tr>
        </tbody>
        </table>
    </div>

</div>
@endsection