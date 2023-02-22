<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Задачи
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {{$errors->first()}}
                            </div>
                        @endif
                        @if (\Session::has('success'))
                            <div class="alert alert-success">
                                <ul>
                                    <li>{!! \Session::get('success') !!}</li>
                                </ul>
                            </div>
                        @endif
                        <form style="margin-bottom: 20px" method="POST" id="search" class="row gy-2 gx-3 align-items-center" >
                            @csrf
                            <div class="col-auto">
                              <label class="visually-hidden" for="autoSizingInput">Название</label>
                              <input type="text" class="form-control" id="name" id="autoSizingInput" placeholder="Название задачи">
                            </div>

                            <div class="col-auto">
                              <label class="visually-hidden" for="autoSizingSelect">Выберите статус</label>
                              <select class="form-select" id="status" id="autoSizingSelect">
                                <option selected>Выберите статус</option>
                                @foreach($statuses as $status)
                                <option value="{{$status->id}}">
                                    {{$status->name}}
                                </option>
                                @endforeach
                              </select>
                            </div>

                            <div class="col-auto">
                              <button type="submit" class="btn btn-primary">Найти</button>
                              <button class="btn btn-primary" onclick="refresh()">Сбросить</button>
                            </div>
                        </form>

                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                          <span class="text-primary">Проекты</span>
                          <span class="badge bg-primary rounded-pill">{{count($tasks)}}</span>
                        </h4>
                        <ul class="list-group mb-3" id="taskList">
                            @if(count($tasks) > 0)
                                @foreach ($tasks as $task)
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                    <h6 class="my-0">{{$task->name}}</h6>
                                    <small class="text-muted">{{$task->user_name}}</small> - <small class="text-muted">{{$task->project_name}}</small><br>
                                    <small class="text-muted">{{$task->status_name}}</small>
                                    </div>

                                    <span class="text-muted">
                                        <a href="/tasks/edit/{{$task->id}}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <button onclick="delTask({{$task->id}})">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </span>
                                </li>
                                @endforeach
                            @else
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                    <h6 class="my-0">Задачи не найдены</h6>
                                    </div>
                                </li>
                            @endif
                        </ul>

                        <a href="/tasks/add" class="btn btn-primary">Добавить</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
