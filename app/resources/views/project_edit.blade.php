<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Редактирование проекта
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="/projects/edit/{{$project->id}}" method="POST">
                        @csrf
                        <div class="mb-3">
                          <label for="inputName" class="form-label">Название проекта</label>
                          <input type="text" class="form-control" name="name" value="{{$project->name}}">
                        </div>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                        <a href="/projects" class="btn btn-primary">
                            Назад
                        </a>
                      </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
