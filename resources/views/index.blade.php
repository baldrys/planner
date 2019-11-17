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
                @foreach($userActivities[0]->dayActivities as $dayActivity)
                    <th scope="col"><p class="day">{{ Carbon\Carbon::parse($dayActivity->date)->translatedFormat('l') }}</p> <p class="day-number">{{ Carbon\Carbon::parse($dayActivity->date)->format('d') }}</p></th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($userActivities as $userActivity)
                <tr>
                    <td class="text-left">{{ $userActivity->activity->name }}</td>
                    @foreach ($userActivity->dayActivities as $dayActivity)
                        @if($today == $dayActivity->date)
                            <td>
                                <div class="dropdown">
                                <button class="btn btn-secondary fixed-width dropdown-toggle" type="button" data-toggle="dropdown">
                                    @if($dayActivity->is_done)
                                        <i class="fas fa-check"></i>
                                    @else
                                        <i class="fas fa-times"></i>
                                    @endif
                                </button>
                                <div class="dropdown-menu w-50">
                                    <a class="dropdown-item"><i class="fas fa-check"></i></a>
                                    <a class="dropdown-item"><i class="fas fa-times"></i></a>
                                </div >
                                </div>
                            </td>
                        @elseif($dayActivity->is_done)
                            <td><i class="fas fa-check"></i></td>
                        @else
                            <td><i class="fas fa-times"></i></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
        </table>
    </div>

</div>
@endsection