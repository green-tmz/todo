<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Models\Statuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class TaskController extends Controller
{
    public function index()
    {
        $statuses = Statuses::all();
        $user = User::find(Auth::user()->id);
        if ($user->group_id == 1) {
            $tasks = Task::join('users', 'tasks.user_id', '=', 'users.id')
                ->join('statuses', 'tasks.status_id', '=', 'statuses.id')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->get(['tasks.name', 'statuses.name as status_name', 'projects.name as project_name', 'tasks.id', 'users.name as user_name']);
        } else {
            $tasks = Task::join('users', 'tasks.user_id', '=', 'users.id')
                ->join('statuses', 'tasks.status_id', '=', 'statuses.id')
                ->join('projects', 'tasks.project_id', '=', 'projects.id')
                ->where('tasks.user_id', '=', $user->id)
                ->get(['tasks.name', 'statuses.name as status_name', 'projects.name as project_name', 'tasks.id', 'users.name as user_name']);
        };

        return view('tasks', [
            'tasks' => $tasks,
            'statuses' => $statuses
        ]);
    }

    public function add()
    {
        $statuses = Statuses::all();

        $user = User::find(Auth::user()->id);
        if ($user->group_id == 1) {
            $projects = Project::join('users', 'projects.user_id', '=', 'users.id')
                ->get(['projects.name', 'projects.id', 'users.name as user_name']);
        } else {
            $projects = Project::join('users', 'projects.user_id', '=', 'users.id')
                ->where('projects.user_id', '=', $user->id)
                ->get(['projects.name', 'projects.id', 'users.name as user_name']);
        };

        return view('tasks_add', [
            'statuses' => $statuses,
            'projects' => $projects
        ]);
    }

    public function postAdd(Request $request)
    {
        if (!$request->name) return Redirect::back()->withErrors(['msg' => 'Введите название задачи']);
        if ($request->projects == 'Выберите проект') return Redirect::back()->withErrors(['msg' => 'Выберите проект']);
        if ($request->status == 'Выберите статус') return Redirect::back()->withErrors(['msg' => 'Выберите статус']);

        $task = new Task();
        $task->name = $request->name;
        $task->user_id = Auth::user()->id;
        $task->status_id = $request->status;
        $task->project_id = $request->projects;

        if ($task->save()) {
            return Redirect::route('tasks')->with(['success' => 'Задача успешно добавлена']);
        } else {
            return Redirect::route('tasks')->withErrors(['msg' => 'Упс! Что то пошло не так']);
        }
    }

    public function edit($id)
    {
        $task = Task::find($id);
        $statuses = Statuses::all();

        $user = User::find(Auth::user()->id);
        if ($user->group_id == 1) {
            $projects = Project::join('users', 'projects.user_id', '=', 'users.id')
                ->get(['projects.name', 'projects.id', 'users.name as user_name']);
        } else {
            $projects = Project::join('users', 'projects.user_id', '=', 'users.id')
                ->where('projects.user_id', '=', $user->id)
                ->get(['projects.name', 'projects.id', 'users.name as user_name']);
        };

        return view('task_edit', [
            'task' => $task,
            'statuses' => $statuses,
            'projects' => $projects
        ]);
    }

    public function postEdit(Request $request, $id)
    {
        $task = Task::find($id);
        $task->name = $request->name;
        $task->status_id = $request->status;
        $task->project_id = $request->projects;

        if ($task->save()) {
            return Redirect::route('tasks')->with(['success' => 'Задача успешно изменена']);
        } else {
            return Redirect::route('tasks')->withErrors(['msg' => 'Упс! Что то пошло не так']);
        }
    }

    public function del(Request $request)
    {
        $task = Task::find($request['id']);
        if ($task->delete()) {
            return Redirect::back()->with(['success' => 'Задача успешно удалена']);
        } else {
            return Redirect::back()->withErrors(['msg' => 'Упс! Что то пошло не так']);
        }
    }

    public function search(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $tasks = [];
        if ($request['task'] && $request['status'] == "Выберите статус") {
            if ($user->group_id == 1) {
                $tasks = Task::join('users', 'tasks.user_id', '=', 'users.id')
                    ->join('statuses', 'tasks.status_id', '=', 'statuses.id')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->where('tasks.name', 'LIKE', '%' . $request['task'] . '%')
                    ->get(['tasks.name', 'statuses.name as status_name', 'projects.name as project_name', 'tasks.id', 'users.name as user_name']);
            } else {
                $tasks = Task::join('users', 'tasks.user_id', '=', 'users.id')
                    ->join('statuses', 'tasks.status_id', '=', 'statuses.id')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->where('tasks.user_id', '=', $user->id)
                    ->where('tasks.name', 'LIKE', '%' . $request['task'] . '%')
                    ->get(['tasks.name', 'statuses.name as status_name', 'projects.name as project_name', 'tasks.id', 'users.name as user_name']);
            };
        }

        if (!$request['task'] && $request['status'] != "Выберите статус") {
            if ($user->group_id == 1) {
                $tasks = Task::join('users', 'tasks.user_id', '=', 'users.id')
                    ->join('statuses', 'tasks.status_id', '=', 'statuses.id')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->where('tasks.status_id', '=', $request['status'])
                    ->get(['tasks.name', 'statuses.name as status_name', 'projects.name as project_name', 'tasks.id', 'users.name as user_name']);
            } else {
                $tasks = Task::join('users', 'tasks.user_id', '=', 'users.id')
                    ->join('statuses', 'tasks.status_id', '=', 'statuses.id')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->where('tasks.user_id', '=', $user->id)
                    ->where('tasks.status_id', '=', $request['status'])
                    ->get(['tasks.name', 'statuses.name as status_name', 'projects.name as project_name', 'tasks.id', 'users.name as user_name']);
            };
        }

        if ($request['status'] != "Выберите статус" && $request['task']) {
            if ($user->group_id == 1) {
                $tasks = Task::join('users', 'tasks.user_id', '=', 'users.id')
                    ->join('statuses', 'tasks.status_id', '=', 'statuses.id')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->where('tasks.status_id', '=', $request['status'])
                    ->where('tasks.name', 'LIKE', '%' . $request['task'] . '%')
                    ->get(['tasks.name', 'statuses.name as status_name', 'projects.name as project_name', 'tasks.id', 'users.name as user_name']);
            } else {
                $tasks = Task::join('users', 'tasks.user_id', '=', 'users.id')
                    ->join('statuses', 'tasks.status_id', '=', 'statuses.id')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->where('tasks.user_id', '=', $user->id)
                    ->where('tasks.status_id', '=', $request['status'])
                    ->where('tasks.name', 'LIKE', '%' . $request['task'] . '%')
                    ->get(['tasks.name', 'statuses.name as status_name', 'projects.name as project_name', 'tasks.id', 'users.name as user_name']);
            };
        }

        if (!$request['task'] && $request['status'] == "Выберите статус") {
            if ($user->group_id == 1) {
                $tasks = Task::join('users', 'tasks.user_id', '=', 'users.id')
                    ->join('statuses', 'tasks.status_id', '=', 'statuses.id')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->get(['tasks.name', 'statuses.name as status_name', 'projects.name as project_name', 'tasks.id', 'users.name as user_name']);
            } else {
                $tasks = Task::join('users', 'tasks.user_id', '=', 'users.id')
                    ->join('statuses', 'tasks.status_id', '=', 'statuses.id')
                    ->join('projects', 'tasks.project_id', '=', 'projects.id')
                    ->where('tasks.user_id', '=', $user->id)
                    ->get(['tasks.name', 'statuses.name as status_name', 'projects.name as project_name', 'tasks.id', 'users.name as user_name']);
            };
        }

        return response()->json($tasks);
    }
}
