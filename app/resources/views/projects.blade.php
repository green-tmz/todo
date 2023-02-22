<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Проекты
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="col-md-5 col-lg-4 order-md-last">
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
                          <span class="text-primary">Проекты</span>
                          <span class="badge bg-primary rounded-pill">{{count($projects)}}</span>
                        </h4>
                        <ul class="list-group mb-3">
                            @if(count($projects) > 0)
                                @foreach ($projects as $project)
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                    <h6 class="my-0">{{$project->name}}</h6>
                                    <small class="text-muted">{{$project->user_name}}</small>
                                    </div>

                                    <span class="text-muted">
                                        <a href="/projects/edit/{{$project->id}}">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form method="POST" action="/projects/del/{{$project->id}}">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <div class="form-group">
                                                <button type="submit"><i class="bi bi-trash3-fill"></i></button>
                                            </div>
                                        </form>
                                    </span>
                                </li>
                                @endforeach
                            @else
                                <li class="list-group-item d-flex justify-content-between lh-sm">
                                    <div>
                                    <h6 class="my-0">Проекты не найдены</h6>
                                    </div>
                                </li>
                            @endif
                        </ul>

                        <form class="card p-2" action="{{route('projects.add')}}" method="POST">
                            @csrf
                          <div class="input-group">
                            <input type="text" class="form-control" name="name" placeholder="Название проекта">
                            <button type="submit" class="btn btn-primary">Добавить</button>
                          </div>
                        </form>
                      </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
