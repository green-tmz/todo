<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Пользователи
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

                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                          <span class="text-primary">Пользователи</span>
                          <span class="badge bg-primary rounded-pill">{{count($users)}}</span>
                        </h4>
                        <ul class="list-group mb-3" id="taskList">
                            @if(count($users) > 0)
                                @foreach ($users as $user)
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                    <h6 class="my-0">{{$user->name}}</h6>
                                    <small class="text-muted">{{$user->email}}</small><br>
                                    @if($user->block)
                                    <small class="text-muted">Заблокирован</small>
                                    @else
                                    <small class="text-muted">Активен</small>
                                    @endif
                                    </div>

                                    <span class="text-muted">
                                        @if($user->block)
                                        <button onclick="blockUser({{$user->id}}, 1)">
                                            <i class="bi bi-x-square"></i>                                        </button>
                                        @else
                                        <button onclick="blockUser({{$user->id}}, 0)">
                                            <i class="bi bi-x-square-fill"></i>
                                        </button>
                                        @endif

                                        <button onclick="delUser({{$user->id}})">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </span>
                                </li>
                                @endforeach
                            @else
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                    <h6 class="my-0">Пользователи не найдены</h6>
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
