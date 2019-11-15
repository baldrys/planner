@extends('layouts.base')

@section('title', 'Активности')


@section('content')
<p class="h1">Список активностей</p>
<p class="h2">Ноябрь 2019</p>
<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">Активности /<br> День</th>
      <th scope="col"> <p>Пн</p> <p>19</p>  </th>
      <th scope="col">Вт</th>
      <th scope="col">Ср</th>
      <th scope="col">Чт</th>
      <th scope="col">Пт</th>
      <th scope="col">Сб</th>
      <th scope="col">Вс</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Название активности</td>
      <td><i class="fas fa-check"></i></td>
      <td><i class="fas fa-times"></i></td>
      <td><i class="fas fa-check"></i></td>
      <td><i class="fas fa-times"></i></td>
      <td><i class="fas fa-check"></i></td>
      <td><i class="fas fa-times"></i></td>
      <td><i class="fas fa-times"></i></td>
    </tr>
    <tr>
      <td>Название активности</td>
      <td><i class="fas fa-check"></i></td>
      <td><i class="fas fa-times"></i></td>
      <td><i class="fas fa-check"></i></td>
      <td><i class="fas fa-times"></i></td>
      <td><i class="fas fa-check"></i></td>
      <td><i class="fas fa-times"></i></td>
      <td><i class="fas fa-times"></i></td>
    </tr>
  </tbody>
</table>
@endsection