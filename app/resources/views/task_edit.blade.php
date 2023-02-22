<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Редактирование задачи
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        {{$errors->first()}}
                    </div>
                @endif
                <div class="p-6 text-gray-900">
                    <form action="/tasks/edit/{{$task->id}}" method="POST">
                        @csrf
                        <div class="mb-3">
                          <label for="inputName" class="form-label">Название задачи</label>
                          <input type="text" class="form-control" name="name" value="{{$task->name}}">
                        </div>
                        <select class="form-select" name="projects" style="margin-bottom: 10px">
                            <option selected>Выберите проект</option>
                            @foreach($projects as $project)
                            <option value="{{$project->id}}"
                                @if ($project->id == $task->project_id)
                                selected="selected"
                                @endif>
                                {{$project->name}}
                            </option>
                            @endforeach
                        </select>
                        <select class="form-select" name="status" style="margin-bottom: 10px">
                            <option selected>Выберите статус</option>
                            @foreach($statuses as $status)
                            <option value="{{$status->id}}"
                                @if ($status->id == $task->status_id)
                                selected="selected"
                                @endif>
                                {{$status->name}}
                            </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <a href="/tasks" class="btn btn-primary">
                            Назад
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
