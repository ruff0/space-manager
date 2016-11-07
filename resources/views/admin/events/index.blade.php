@extends('admin.layouts.admin')

@section('body-class', '')

@section('new-form-text', 'Crear nuevo evento')
@section('new-form-url', route('admin.events.create'))

@section('content')
    <div class="page-content">

        @include('admin.common.sidebar')
        <div class="content-wrapper">
            @include('admin.common.header')
            <div class="content pb-20">
                <div class="panel panel-white">
                    <div class="panel-heading">
                        <h6 class="panel-title">Eventos</h6>
                        <div class="heading-elements">
                            <ul class="icons-list">
                                <li><a data-action="collapse"></a></li>
                            </ul>
                        </div>
                    </div>

                    <table class="table bookings-list table-lg">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Mes</th>
                            <th>Nombre</th>
                            <th>Sala</th>
                            <th>Fecha</th>
                            <th>Ultima actualización</th>
                            <th class="text-center text-muted" style="width: 30px;">
                                <i class="icon-checkmark3"></i>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $event)
                            <tr data-plan="{{$event->id}}">
                                <td>#{{$event->id}}</td>
                                <td>{{$event->time_from->format('Y F')}}</td>
                                <td>{{$event->member->fullname()}}</td>
                                <td>
                                    {{$event->resource->resourceable->name}} <br>
                                    <span class="text-muted">
									{{$event->bookable->name}}
								</span>
                                </td>
                                <td>
                                    <div class="text-muted">
                                        {{$event->time_from->format('j M \d\e Y')}}
                                        ( {{$event->time_from->diffInHours($event->time_to) }} horas)
                                        <br>
                                        desde : {{$event->time_from->format('H:i')}} -
                                        hasta : {{$event->time_to->format('H:i')}}
                                    </div>
                                </td>
                                <td>
                                    <i class="icon-calendar2 position-left"></i>
                                    {{ $event->updated_at->format('d M Y H:i')  }}
                                </td>
                                <td class="text-center">
                                    <ul class="icons-list">
                                        <li class="dropdown">
                                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i
                                                        class="icon-menu9"></i></a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                @if($event->isPaid())
                                                    <li>
                                                        <a href="{{ route('admin.bookings.edit', [$event->id]) }}">
                                                            <i class="icon-eye2"></i> Ver
                                                        </a>
                                                    </li>
                                                @endif

                                                @if(!$event->isPaid())
                                                    <li>
                                                        <a href="{{ route('admin.bookings.edit', [$event->id]) }}">
                                                            <i class="icon-pencil7"></i> Editar
                                                        </a>
                                                    </li>

                                                    <li>
                                                        <a href="{{route('admin.bookings.destroy', [$event->id])}}"
                                                           role="delete-form"
                                                           data-id="{{$event->id}}"
                                                           data-token="{{ csrf_token() }}"
                                                        >
                                                            <i class="icon-cross2 position-left"></i>
                                                            Cancelar
                                                        </a>
                                                    </li>
                                                @endif
                                            </ul>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
